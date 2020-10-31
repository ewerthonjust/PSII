<?php

class PerguntasList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'bedevops';
    private static $activeRecord = 'Pergunta';
    private static $primaryKey = 'id';
    private static $formName = 'formList_Pergunta';
    private $showMethods = ['onReload', 'onSearch'];

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Listagem de perguntass");

        $id = new TEntry('id');
        $pergunta = new TEntry('pergunta');
        $descricao = new TEntry('descricao');
        $ferramenta_id = new TDBCombo('ferramenta_id', 'bedevops', 'Ferramenta', 'id', '{nome}','nome asc'  );
        $categoria_id = new TDBCombo('categoria_id', 'bedevops', 'Categoria', 'id', '{categoria}','categoria asc'  );

        $pergunta->setMaxLength(200);
        $descricao->setMaxLength(300);

        $id->setSize(100);
        $pergunta->setSize('100%');
        $descricao->setSize('100%');
        $categoria_id->setSize('100%');
        $ferramenta_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Pergunta:", null, '14px', null)],[$pergunta]);
        $row3 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null)],[$descricao]);
        $row4 = $this->form->addFields([new TLabel("Ferramenta:", null, '14px', null)],[$ferramenta_id]);
        $row5 = $this->form->addFields([new TLabel("Categoria:", null, '14px', null)],[$categoria_id]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'far:file-alt #000000');

        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['PerguntasForm', 'onShow']), 'fas:plus #69aa46');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Código", 'center' , '70.1167px');
        $column_pergunta = new TDataGridColumn('pergunta', "Pergunta", 'left');
        $column_descricao = new TDataGridColumn('descricao', "Descrição", 'left');
        $column_ferramenta_nome = new TDataGridColumn('ferramenta->nome', "Ferramenta", 'left');
        $column_categoria_categoria = new TDataGridColumn('categoria->categoria', "Categoria", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_pergunta);
        $this->datagrid->addColumn($column_descricao);
        $this->datagrid->addColumn($column_ferramenta_nome);
        $this->datagrid->addColumn($column_categoria_categoria);

        $action_onEdit = new TDataGridAction(array('PerguntasForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('PerguntasList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Questionário","Consultar Perguntas"]));
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new Pergunta($key, FALSE); 

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }

    public function onExportCsv($param = null) 
    {
        try
        {
            $this->onSearch();

            TTransaction::open(self::$database); // open a transaction
            $repository = new TRepository(self::$activeRecord); // creates a repository for Customer
            $criteria = $this->filter_criteria;

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            $records = $repository->load($criteria); // load the objects according to criteria
            if ($records)
            {
                $file = 'tmp/'.uniqid().'.csv';
                $handle = fopen($file, 'w');
                $columns = $this->datagrid->getColumns();

                $csvColumns = [];
                foreach($columns as $column)
                {
                    $csvColumns[] = $column->getLabel();
                }
                fputcsv($handle, $csvColumns, ';');

                foreach ($records as $record)
                {
                    $csvColumns = [];
                    foreach($columns as $column)
                    {
                        $name = $column->getName();
                        $csvColumns[] = $record->{$name};
                    }
                    fputcsv($handle, $csvColumns, ';');
                }
                fclose($handle);

                TPage::openFile($file);
            }
            else
            {
                new TMessage('info', _t('No records found'));       
            }

            TTransaction::close(); // close the transaction
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->pergunta) AND ( (is_scalar($data->pergunta) AND $data->pergunta !== '') OR (is_array($data->pergunta) AND (!empty($data->pergunta)) )) )
        {

            $filters[] = new TFilter('pergunta', 'like', "%{$data->pergunta}%");// create the filter 
        }

        if (isset($data->descricao) AND ( (is_scalar($data->descricao) AND $data->descricao !== '') OR (is_array($data->descricao) AND (!empty($data->descricao)) )) )
        {

            $filters[] = new TFilter('descricao', 'like', "%{$data->descricao}%");// create the filter 
        }

        if (isset($data->ferramenta_id) AND ( (is_scalar($data->ferramenta_id) AND $data->ferramenta_id !== '') OR (is_array($data->ferramenta_id) AND (!empty($data->ferramenta_id)) )) )
        {

            $filters[] = new TFilter('ferramenta_id', '=', $data->ferramenta_id);// create the filter 
        }

        if (isset($data->categoria_id) AND ( (is_scalar($data->categoria_id) AND $data->categoria_id !== '') OR (is_array($data->categoria_id) AND (!empty($data->categoria_id)) )) )
        {

            $filters[] = new TFilter('categoria_id', '=', $data->categoria_id);// create the filter 
        }

        $param = array();
        $param['offset']     = 0;
        $param['first_page'] = 1;

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload($param);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'bedevops'
            TTransaction::open(self::$database);

            // creates a repository for Pergunta
            $repository = new TRepository(self::$activeRecord);
            $limit = 20;

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid

                    $this->datagrid->addItem($object);

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

}

