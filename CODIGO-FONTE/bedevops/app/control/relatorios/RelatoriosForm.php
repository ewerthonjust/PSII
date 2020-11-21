<?php

class RelatoriosForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bedevops';
    private static $activeRecord = 'Relatorio';
    private static $primaryKey = 'id';
    private static $formName = 'form_Relatorio';

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
        $this->form->setFormTitle("Cadastro de relatórios");


        $id = new TEntry('id');
        $user_id = new TDBCombo('user_id', 'permission', 'SystemUsers', 'id', '{name}','name asc'  );
        $titulo = new TEntry('titulo');
        $descricao = new TText('descricao');
        $criacao = new TDateTime('criacao');

        $titulo->addValidation("Título", new TRequiredValidator()); 
        $descricao->addValidation("Descrição", new TRequiredValidator()); 
        $criacao->addValidation("Data da criação", new TRequiredValidator()); 

        $titulo->setMaxLength(100);
        $criacao->setMask('dd/mm/yyyy hh:ii:ss');
        $criacao->setDatabaseMask('yyyy-mm-dd hh:ii:ss');
        $id->setEditable(false);
        $user_id->setEditable(false);
        $criacao->setEditable(false);

        $titulo->placeholder = "(Ex.: \"Workshop_devops_2020\", \"Test_%user%_112020\")\"";
        $descricao->placeholder = "(Ex.: Relatório gerado durante apresentação do dia....\")";

        $id->setSize(100);
        $criacao->setSize(150);
        $user_id->setSize('25%');
        $titulo->setSize('100%');
        $descricao->setSize('100%', 70);

        TTransaction::open('permission');
        $user = new SystemUsers(TSession::getValue('userid'));
        TTransaction::close();

        $object = new stdClass();
        $object->user_id = $user->id;
        TForm::sendData(self::$formName, $object);

        $object = new stdClass();
        $object->criacao = date("d/m/Y h:i:s");
        TForm::sendData(self::$formName, $object);
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$id,new TLabel("Usuário:", null, '14px', null),$user_id]);
        $row2 = $this->form->addFields([new TLabel("Título:", '#000000', '14px', null)],[$titulo]);
        $row3 = $this->form->addFields([new TLabel("Descrição:", '#000000', '14px', null)],[$descricao]);
        $row4 = $this->form->addFields([new TLabel("Data da criação:", '#000000', '14px', null)],[$criacao]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Prosseguir", new TAction([$this, 'onSave']), 'fas:angle-double-right #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["Relatórios","Cadastro de relatórios"]));
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

            $object = new Relatorio(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->criacao = date('Y-m-d h:i:s', strtotime($object->criacao));

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/
            /*

            new TMessage('info', "Registro salvo", $messageAction); 

            */

            $pageParam = ['ReportId' => $data->id]; // ex.: = ['key' => 10]
            TApplication::loadPage('ItensRelatorioForm', 'onshow', $pageParam);
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

                $object = new Relatorio($key); // instantiates the Active Record 

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

