<?php

class RelatoriosForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bedevops';
    private static $activeRecord = 'Relatorios';
    private static $primaryKey = 'id';
    private static $formName = 'form_Relatorios';

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
        $this->form->setFormTitle("Relatório");


        $id = new TEntry('id');
        $user_id = new TDBCombo('user_id', 'bedevops', 'SystemUsers', 'id', '{name}','id asc'  );
        $descricao = new TEntry('descricao');

        $descricao->addValidation("Descricao", new TRequiredValidator()); 

        $user_id->setDefaultOption(false);
        $descricao->setMaxLength(200);

        $id->setEditable(false);
        $user_id->setEditable(false);

        $id->setSize(100);
        $user_id->setSize('50%');
        $descricao->setSize('100%');

        TTransaction::open('permission');
        $user = new SystemUsers(TSession::getValue('userid'));
        $user_id->setValue("$user->id");
        TTransaction::close();
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Usuário:", '#000000', '14px', null)],[$user_id]);
        $row3 = $this->form->addFields([new TLabel("Descricão:", '#ff0000', '14px', null)],[$descricao]);

        TTransaction::open('bedevops');
        $data = Perguntas::orderBy('id')->load();
        foreach ($data as &$value) {
            $row = $this->form->addContent([new TFormSeparator("", '#333333', '18', '#a3a0a0')]);
            $id = $value->id;
            $report_items_reports_resposta = new TRadioGroup("report_items_reports_resposta_$id");
            $report_items_reports_resposta->addItems(['1'=>'Sim','2'=>'Não']);
            $report_items_reports_resposta->setLayout('horizontal');
            $report_items_reports_resposta->setBooleanMode();
            $report_items_reports_resposta->setUseButton();
            $report_items_reports_resposta->addValidation('Campo', new TRequiredValidator);
            $report_items_reports_resposta->setSize(80);
            #$report_items_reports_resposta->addValidation("resposta da pergunta $id", new TRequiredValidator());

            $report_items_reports_descricao = new TEntry("report_items_reports_descricao_$id");
            $report_items_reports_descricao->setSize('100%');
            $report_items_reports_descricao->placeholder = "Comentários";
            $report_items_reports_descricao->setMaxLength(200);
            $row = $this->form->addFields([new TLabel("$value->id - $value->pergunta", 500, '14px', null)],
                                                [$report_items_reports_resposta],
                                                    [$report_items_reports_descricao]);
            $row->layout = [' col-xs-12 col-sm-12 col-lg-12 col-md-12',' col-xs-3 col-sm-3 col-lg-3 col-md-3',' col-xs-9 col-sm-9 col-lg-9 col-md-9'];
        }

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["Relatórios","Cadastro de relatorios"]));
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Relatorios(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', "Registro salvo", $messageAction); 

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

                $object = new Relatorios($key); // instantiates the Active Record 

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

}

