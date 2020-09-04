<?php

class TblUsuarioForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'hello_world';
    private static $activeRecord = 'TblUsuario';
    private static $primaryKey = 'id';
    private static $formName = 'form_TblUsuario';

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
        $this->form->setFormTitle("Cadastro de tbl usuario");


        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $sobrenome = new TEntry('sobrenome');
        $empresa = new TEntry('empresa');
        $cidade = new TDBCombo('cidade', 'hello_world', 'TblCidade', 'id', '{nome}','nome asc'  );
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');

        $nome->addValidation("Nome", new TRequiredValidator()); 
        $sobrenome->addValidation("Sobrenome", new TRequiredValidator()); 
        $empresa->addValidation("Empresa", new TRequiredValidator()); 
        $cidade->addValidation("Tbl cidade id", new TRequiredValidator()); 

        $id->setEditable(false);

        $nome->setMaxLength(50);
        $email->setMaxLength(100);
        $empresa->setMaxLength(50);
        $telefone->setMaxLength(20);
        $sobrenome->setMaxLength(20);

        $id->setSize(100);
        $nome->setSize('100%');
        $email->setSize('100%');
        $cidade->setSize('100%');
        $empresa->setSize('100%');
        $telefone->setSize('100%');
        $sobrenome->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$nome]);
        $row2->layout = ['col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Sobrenome:", '#ff0000', '14px', null, '100%'),$sobrenome]);
        $row3->layout = ['col-sm-12'];

        $row4 = $this->form->addFields([new TLabel("Empresa:", '#ff0000', '14px', null, '100%'),$empresa]);
        $row4->layout = ['col-sm-12'];

        $row5 = $this->form->addFields([new TLabel("Tbl cidade id:", '#ff0000', '14px', null, '100%'),$cidade]);
        $row5->layout = ['col-sm-12'];

        $row6 = $this->form->addFields([new TLabel("Telefone:", null, '14px', null, '100%'),$telefone]);
        $row6->layout = ['col-sm-12'];

        $row7 = $this->form->addFields([new TLabel("Email:", null, '14px', null, '100%'),$email]);
        $row7->layout = ['col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
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

            $object = new TblUsuario(); // create an empty object 

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

                $object = new TblUsuario($key); // instantiates the Active Record 

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

