<?php

class PerguntasForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bedevops';
    private static $activeRecord = 'Pergunta';
    private static $primaryKey = 'id';
    private static $formName = 'form_Pergunta';

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
        $this->form->setFormTitle("Cadastro de perguntas");


        $id = new TEntry('id');
        $pergunta = new TEntry('pergunta');
        $descricao = new TEntry('descricao');
        $ferramenta_id = new TDBCombo('ferramenta_id', 'bedevops', 'Ferramenta', 'id', '{nome}','nome asc'  );
        $categoria_id = new TDBCombo('categoria_id', 'bedevops', 'Categoria', 'id', '{categoria}','categoria asc'  );

        $pergunta->addValidation("Question", new TRequiredValidator()); 
        $ferramenta_id->addValidation("Ferramenta id", new TRequiredValidator()); 
        $categoria_id->addValidation("Categorias id", new TRequiredValidator()); 

        $id->setEditable(false);

        $pergunta->setMaxLength(200);
        $descricao->setMaxLength(300);

        $id->setSize(100);
        $pergunta->setSize('100%');
        $descricao->setSize('100%');
        $categoria_id->setSize('100%');
        $ferramenta_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Pergunta: *", '#000000', '14px', null)],[$pergunta]);
        $row3 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null)],[$descricao]);
        $row4 = $this->form->addFields([new TLabel("Ferramenta: *", '#010101', '14px', null)],[$ferramenta_id]);
        $row5 = $this->form->addFields([new TLabel("Categoria: *", '#000000', '14px', null)],[$categoria_id]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["Questionário","Cadastro de perguntas"]));
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

            $object = new Pergunta(); // create an empty object 

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

                $object = new Pergunta($key); // instantiates the Active Record 

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

