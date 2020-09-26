<?php

class ReportsForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = 'bdevops';
    private static $activeRecord = 'Reports';
    private static $primaryKey = 'id';
    private static $formName = 'form_Reports';

    use Adianti\Base\AdiantiMasterDetailTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setSize(0.8, null);
        parent::setTitle("Gerar Relatório");
        parent::setProperty('class', 'window_modal');

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Gerar Relatório");


        $report_items_reports_questions_question = new TCombo('report_items_reports_questions_question');
        $report_items_reports_resposta = new TRadioGroup('report_items_reports_resposta');
        $report_items_reports_descricao = new TEntry('report_items_reports_descricao');
        $report_items_reports_id = new THidden('report_items_reports_id');

        $report_items_reports_questions_question->setValue('{1}');
        $report_items_reports_questions_question->enableSearch();
        $report_items_reports_resposta->addItems(['1'=>'Sim','2'=>'Não']);
        $report_items_reports_resposta->setLayout('horizontal');
        $report_items_reports_resposta->setBooleanMode();
        $report_items_reports_descricao->setMaxLength(200);

        $report_items_reports_questions_question->autofocus = 'autofocus';

        $report_items_reports_resposta->setSize(80);
        $report_items_reports_descricao->setSize('100%');
        $report_items_reports_questions_question->setSize('100%');

        $row1 = $this->form->addFields([new TFormSeparator("Perguntas", '#333333', '18', '#eeeeee')]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Questão", '#ff0000', '14px', null)],[$report_items_reports_questions_question]);
        $row3 = $this->form->addFields([new TLabel("Resposta:", '#ff0000', '14px', null)],[$report_items_reports_resposta]);
        $row4 = $this->form->addFields([new TLabel("Descricao:", null, '14px', null)],[$report_items_reports_descricao]);
        $row5 = $this->form->addFields([$report_items_reports_id]);         
        $add_report_items_reports = new TButton('add_report_items_reports');

        $action_report_items_reports = new TAction(array($this, 'onAddReportItemsReports'));

        $add_report_items_reports->setAction($action_report_items_reports, "Responder");
        $add_report_items_reports->setImage('fas:plus #000000');

        $this->form->addFields([$add_report_items_reports]);

        $detailDatagrid = new TQuickGrid;
        $detailDatagrid->disableHtmlConversion();
        $this->report_items_reports_list = new BootstrapDatagridWrapper($detailDatagrid);
        $this->report_items_reports_list->style = 'width:100%';
        $this->report_items_reports_list->class .= ' table-bordered';
        $this->report_items_reports_list->disableDefaultClick();
        $this->report_items_reports_list->addQuickColumn('', 'edit', 'left', 50);
        $this->report_items_reports_list->addQuickColumn('', 'delete', 'left', 50);

        $column_report_items_reports_questions_id = $this->report_items_reports_list->addQuickColumn("Questions id", 'report_items_reports_questions_id', 'left');
        $column_report_items_reports_resposta = $this->report_items_reports_list->addQuickColumn("Resposta", 'report_items_reports_resposta', 'left');
        $column_report_items_reports_descricao = $this->report_items_reports_list->addQuickColumn("Descricao", 'report_items_reports_descricao', 'left');

        $this->report_items_reports_list->createModel();
        $this->form->addContent([$this->report_items_reports_list]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        parent::add($this->form);

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

            $object = new Reports(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $this->fireEvents($object);

            $report_items_reports_items = $this->storeItems('ReportItems', 'reports_id', $object, 'report_items_reports', function($masterObject, $detailObject){ 

                //code here

            }); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', "Registro salvo", $messageAction); 

                TWindow::closeWindow(parent::getId()); 

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

                $object = new Reports($key); // instantiates the Active Record 

                $report_items_reports_items = $this->loadItems('ReportItems', 'reports_id', $object, 'report_items_reports', function($masterObject, $detailObject, $objectItems){ 

                    //code here

                    $objectItems->report_items_reports_questions_question = null;
                    if(isset($detailObject->questions->question) && $detailObject->questions->question)
                    {
                        $objectItems->report_items_reports_questions_question = $detailObject->questions->question;
                    }
                    $objectItems->report_items_reports_questions_question = null;
                    if(isset($detailObject->questions->question) && $detailObject->questions->question)
                    {
                        $objectItems->report_items_reports_questions_question = $detailObject->questions->question;
                    }

                }); 

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);
                $this->onReload();

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

        TSession::setValue('report_items_reports_items', null);

        $this->onReload();
    }

    public function onAddReportItemsReports( $param )
    {
        try
        {
            $data = $this->form->getData();

            if(!$data->report_items_reports_questions_question)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', "Questions id"));
            }             
            if(!$data->report_items_reports_resposta)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', "Resposta"));
            }             

            $report_items_reports_items = TSession::getValue('report_items_reports_items');
            $key = isset($data->report_items_reports_id) && $data->report_items_reports_id ? $data->report_items_reports_id : uniqid();
            $fields = []; 

            $fields['report_items_reports_questions_question'] = $data->report_items_reports_questions_question;
            $fields['report_items_reports_resposta'] = $data->report_items_reports_resposta;
            $fields['report_items_reports_descricao'] = $data->report_items_reports_descricao;
            $report_items_reports_items[ $key ] = $fields;

            TSession::setValue('report_items_reports_items', $report_items_reports_items);

            $data->report_items_reports_id = '';
            $data->report_items_reports_questions_question = '';
            $data->report_items_reports_resposta = '';
            $data->report_items_reports_descricao = '';

            $this->form->setData($data);
            $this->fireEvents($data);
            $this->onReload( $param );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());
            $this->fireEvents($data);
            new TMessage('error', $e->getMessage());
        }
    }

    public function onEditReportItemsReports( $param )
    {
        $data = $this->form->getData();

        // read session items
        $items = TSession::getValue('report_items_reports_items');

        // get the session item
        $item = $items[$param['report_items_reports_id_row_id']];

        $data->report_items_reports_questions_question = $item['report_items_reports_questions_question'];
        $data->report_items_reports_resposta = $item['report_items_reports_resposta'];
        $data->report_items_reports_descricao = $item['report_items_reports_descricao'];

        $data->report_items_reports_id = $param['report_items_reports_id_row_id'];

        // fill product fields
        $this->form->setData( $data );

        $this->fireEvents($data);

        $this->onReload( $param );

    }

    public function onDeleteReportItemsReports( $param )
    {
        $data = $this->form->getData();

        $data->report_items_reports_questions_question = '';
        $data->report_items_reports_resposta = '';
        $data->report_items_reports_descricao = '';

        // clear form data
        $this->form->setData( $data );

        // read session items
        $items = TSession::getValue('report_items_reports_items');

        // delete the item from session
        unset($items[$param['report_items_reports_id_row_id']]);
        TSession::setValue('report_items_reports_items', $items);

        $this->fireEvents($data);

        // reload sale items
        $this->onReload( $param );

    }

    public function onReloadReportItemsReports( $param )
    {
        $items = TSession::getValue('report_items_reports_items'); 

        $this->report_items_reports_list->clear(); 

        if($items) 
        { 
            $cont = 1; 
            foreach ($items as $key => $item) 
            {
                $rowItem = new StdClass;

                $action_del = new TAction(array($this, 'onDeleteReportItemsReports')); 
                $action_del->setParameter('report_items_reports_id_row_id', $key);
                $action_del->setParameter('row_data', base64_encode(serialize($item)));
                $action_del->setParameter('key', $key);

                $action_edi = new TAction(array($this, 'onEditReportItemsReports'));  
                $action_edi->setParameter('report_items_reports_id_row_id', $key);  
                $action_edi->setParameter('row_data', base64_encode(serialize($item)));
                $action_edi->setParameter('key', $key);

                $button_del = new TButton('delete_report_items_reports'.$cont);
                $button_del->setAction($action_del, '');
                $button_del->setFormName($this->form->getName());
                $button_del->class = 'btn btn-link btn-sm';
                $button_del->title = "Excluir";
                $button_del->setImage('fas:trash-alt #dd5a43');

                $rowItem->delete = $button_del;

                $button_edi = new TButton('edit_report_items_reports'.$cont);
                $button_edi->setAction($action_edi, '');
                $button_edi->setFormName($this->form->getName());
                $button_edi->class = 'btn btn-link btn-sm';
                $button_edi->title = "Editar";
                $button_edi->setImage('far:edit #478fca');

                $rowItem->edit = $button_edi;

                $rowItem->report_items_reports_questions_question = '';
                if(isset($item['report_items_reports_questions_question']) && $item['report_items_reports_questions_question'])
                {
                    TTransaction::open('bdevops');
                    $questions = Questions::find($item['report_items_reports_questions_question']);
                    if($questions)
                    {
                        $rowItem->report_items_reports_questions_question = $questions->render('{id}');
                    }
                    TTransaction::close();
                }

                $rowItem->report_items_reports_resposta = isset($item['report_items_reports_resposta']) ? $item['report_items_reports_resposta'] : '';
                $rowItem->report_items_reports_descricao = isset($item['report_items_reports_descricao']) ? $item['report_items_reports_descricao'] : '';

                $row = $this->report_items_reports_list->addItem($rowItem);

                $cont++;
            } 
        } 
    } 

    public function onShow($param = null)
    {

        TSession::setValue('report_items_reports_items', null);

        $this->onReload();

    } 

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->report_items_reports_questions_question))
            {
                $value = $object->report_items_reports_questions_question;

                $obj->report_items_reports_questions_question = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->report_items->reports->questions->question))
            {
                $value = $object->report_items->reports->questions->question;

                $obj->report_items_reports_questions_question = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    public function onReload($params = null)
    {
        $this->loaded = TRUE;

        $this->onReloadReportItemsReports($params);
    }

    public function show() 
    { 
        if (!$this->loaded AND (!isset($_GET['method']) OR $_GET['method'] !== 'onReload') ) 
        { 
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }

}

