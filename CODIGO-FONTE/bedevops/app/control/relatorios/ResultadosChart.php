<?php

class ResultadosChart extends TPage
{
    private $form; // form
    private $loaded;
    private static $database = 'bedevops';
    private static $activeRecord = 'Resultado';
    private static $primaryKey = 'id';
    private static $formName = 'formChart_Resultado';

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
        $this->form->setFormTitle("Consulta de Relatórios");

        $relatorio_id = new TDBCombo('relatorio_id', 'bedevops', 'Relatorio', 'id', '{titulo}','id asc'  );
        $categoria_id = new TDBCombo('categoria_id', 'bedevops', 'Categoria', 'id', '{categoria}','categoria asc'  );

        $relatorio_id->enableSearch();
        $relatorio_id->setSize('40%');
        $categoria_id->setSize('20%');

        $row1 = $this->form->addFields([new TLabel("Título", null, '14px', null)],[$relatorio_id]);
        $row2 = $this->form->addFields([new TLabel("Categoria:", null, '14px', null)],[$categoria_id]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Filtrar", new TAction([$this, 'onGenerate']), 'fas:search #ffffff');
        $btn_ongenerate->addStyleClass('btn-primary'); 

        $btn_onaction = $this->form->addAction("Cadastrar", new TAction([$this, 'onAction']), 'fas:hammer #ffffff');
        $btn_onaction->addStyleClass('btn-success'); 

        $btn_onexport = $this->form->addHeaderAction("Exportar", new TAction([$this, 'onExport']), 'fas:file-pdf #ffffff');
        $btn_onexport->addStyleClass('btn-danger'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Relatórios","Consulta"]));
        $container->add($this->form);

        TButton::disableField(self::$formName, 'btn_onexport');

        parent::add($container);

    }

    public function onAction($param = null) 
    {
        try 
        {
            //code here

            TApplication::loadPage('RelatoriosForm', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onExport($param = null) 
    {
        try 
        {
            if (!empty($param['relatorio_id']))
            {

                $pageParam = ['key' => $param['relatorio_id']]; // ex.: = ['key' => 10]
                TApplication::loadPage('RelatoriosDocument', 'onGenerate', $pageParam);

            } else {
                new TMessage('info', "Você deve selecionar o relatório que você deseja exportar.");
            }
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
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

        if (isset($data->relatorio_id) AND ( (is_scalar($data->relatorio_id) AND $data->relatorio_id !== '') OR (is_array($data->relatorio_id) AND (!empty($data->relatorio_id)) )) )
        {

            $filters[] = new TFilter('relatorio_id', '=', $data->relatorio_id);// create the filter 
        }
        if (isset($data->categoria_id) AND ( (is_scalar($data->categoria_id) AND $data->categoria_id !== '') OR (is_array($data->categoria_id) AND (!empty($data->categoria_id)) )) )
        {

            $filters[] = new TFilter('categoria_id', '=', $data->categoria_id);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);
    }

    /**
     * Load the datagrid with data
     */
    public function onGenerate()
    {
        try
        {
            $this->onSearch();
            // open a transaction with database 'bedevops'
            TTransaction::open(self::$database);
            $param = [];
            // creates a repository for Resultado
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = new TCriteria;

            if ($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            if ($objects)
            {
                $dataTotals = [];
                $data = [];
                $groups = [];
                foreach ($objects as $obj)
                {
                    $group1 = $obj->categoria->categoria;
                    $group2 = $obj->relatorio->titulo;

                    $groups[$group2] = true;
                    $numericField = $obj->valor;

                    $dataTotals[$group1][$group2]['count'] = isset($dataTotals[$group1][$group2]['count']) ? $dataTotals[$group1][$group2]['count'] + 1 : 1;
                    $dataTotals[$group1][$group2]['sum'] = isset($dataTotals[$group1][$group2]['sum']) ? $dataTotals[$group1][$group2]['sum'] + $numericField  : $numericField;

                }

                $groups = ['x'=>true]+$groups;
                $data = [array_keys($groups)];
                $line = array_fill(0, count($groups), NULL);

                foreach ($dataTotals as $group1 => $group1Totals) 
                {

                    $lineData = $line;

                    $lineData[0] = $group1;
                    foreach ($group1Totals as $group2 => $totals) 
                    {
                        $posi = array_search($group2, array_keys($groups));

                        $lineData[$posi] = $totals['sum'];

                    }
                    $data[] = $lineData;
                }

                $chart = new THtmlRenderer('app/resources/c3_bar_chart.html');
                $chart->enableSection('main', [
                    'data'=> json_encode($data),
                    'height' => 300,
                    'precision' => 0,
                    'decimalSeparator' => ',',
                    'thousandSeparator' => '.',
                    'prefix' => '',
                    'sufix' => '',
                    'width' => 100,
                    'widthType' => '%',
                    'title' => 'Resultado',
                    'showLegend' => 'true',
                    'showPercentage' => 'false',
                    'barDirection' => 'false'
                ]);

                parent::add($chart);
            }
            else
            {
                new TMessage('error', _t('No records found'));
            }

            // close the transaction
            TTransaction::close();
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

        TTransaction::open('bedevops');
        $count = Relatorio::where('id',  'is not', null)->count();
        if ($count > 0) {
            // Código gerado pelo snippet: "Enviar dados para campo"
            $object = new stdClass();
            $object->relatorio_id = Relatorio::last()->id;
            //$object->fieldName = 'insira o novo valor aqui'; //sample
            TForm::sendData(self::$formName, $object);
            // -----
            TButton::enableField(self::$formName, 'Exportar Relatório');
        } else {

            new TMessage('info', "Você foi redirecionado para a página de cadastro de relatórios por não existir nenhum relatório cadastrado.", $this->onAction());

        }
        TTransaction::close();
    }

}

