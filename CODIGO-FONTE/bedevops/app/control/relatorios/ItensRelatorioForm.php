<?php

class ItensRelatorioForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bedevops';
    private static $activeRecord = 'ItemRelatorio';
    private static $primaryKey = 'id';
    private static $formName = 'form_ItemRelatorio';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Formulário de perguntas");

        TTransaction::open('bedevops');
        $data = Pergunta::orderBy('id')->load();
        TTransaction::close();
        foreach ($data as &$value) {
            $row = $this->form->addContent([new TFormSeparator("", '#333333', '18', '#a3a0a0')]);
            $id = $value->id;
            $resposta = new TRadioGroup("resposta_$id");
            $resposta->addItems(['1'=>'Sim','2'=>'Não']);
            $resposta->setLayout('horizontal');
            #$resposta->setBooleanMode();
            $resposta->setUseButton();
            $resposta->setSize(80);
            $resposta->addValidation("de resposta da pergunta $id", new TRequiredValidator());

            $comentario = new TEntry("comentario_$id");
            $comentario->setSize('100%');
            $comentario->placeholder = "Comentários";
            $comentario->setMaxLength(200);
            $comentario->addValidation("de comentarios da pergunta $id", new TRequiredValidator());
            $row = $this->form->addFields([new TLabel("$id - $value->pergunta", 500, '14px', null)],
                                                [$resposta],
                                                    [$comentario]);
            $row->layout = [' col-xs-12 col-sm-12 col-lg-12 col-md-12',' col-xs-3 col-sm-3 col-lg-3 col-md-3',' col-xs-9 col-sm-9 col-lg-9 col-md-9'];
        }


        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        #$btnClose = $this->form->addAction(new TAction([$this, 'onClose']));

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {   
            $messageAction = null;
            $this->form->validate(); // validate form data
            TTransaction::open('bedevops');
            $perguntas = Pergunta::orderBy('id')->load();
            $lastrelatorio = Relatorio::last()->id;
            $categorias = Categoria::orderBy('id')->load();
            TTransaction::close();
            foreach ($perguntas as &$pergunta) {
                TTransaction::open(self::$database); // open a transaction

                /**
                // Enable Debug logger for SQL operations inside the transaction
                TTransaction::setLogger(new TLoggerSTD); // standard output
                TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
                **/

            $object = new ItemRelatorio(); // create an empty object 
            $object->pergunta_id = $pergunta->id;
            $object->resposta = $param["resposta_$pergunta->id"];
            $object->comentario = $param["comentario_$pergunta->id"];
            $object->relatorio_id = $lastrelatorio;

            $object->store(); // save the object 

/*
            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 
*/
            TTransaction::close();
            }
            foreach ($categorias as &$categoria) {
                TTransaction::open(self::$database); // open a transaction
                $count = Pergunta::where('categoria_id', '=', $categoria->id)->count();
                $equivalencia = 0;
                foreach ($perguntas as &$pergunta) {
                    if ($pergunta->categoria_id == $categoria->id && $param["resposta_$pergunta->id"] == 1 ) {
                        $equivalencia++;
                    }
                }
                $value = $equivalencia * 100 / $count;
                /*
                $result = new Resultados(); // create an empty object 
                */
                $result = new Resultado();
                $result->categoria_id = $categoria->id;
                $result->relatorio_id = $lastrelatorio;
                $result->valor = $value;

                $result->store(); // save the object 

    /*
                // get the generated {PRIMARY_KEY}
                $data->id = $object->id; 
    */
                #$this->form->setData($data); // fill form data
                TTransaction::close(); // close the transaction
            }
            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', "Registro salvo", $messageAction); 

            TApplication::loadPage('ResultadosChart', 'onshow');
            exit;
                TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new ItemRelatorio($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public function onClose($param = null) 
    {
        TTransaction::open('bedevops');
        Relatorio::last()->delete();
        TTransaction::close();
    }

}

