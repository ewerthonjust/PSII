<?php

class DashboardChart extends TPage
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
        $this->form->setFormTitle("Último relatório gerado");

        $titulo = new TEntry('titulo');
        $autor = new TEntry('autor');
        $criacao = new TEntry('criacao');
        $descricao = new TText('descricao');

        $titulo->setMaxLength(200);

        $autor->setSize('40%');
        $titulo->setSize('40%');
        $criacao->setSize('40%');
        $descricao->setSize('40%', 70);

        $autor->setEditable(false);
        $titulo->setEditable(false);
        $criacao->setEditable(false);
        $descricao->setEditable(false);

        $row1 = $this->form->addFields([new TLabel("Título:", null, '14px', null)],[$titulo]);
        $row2 = $this->form->addFields([new TLabel("Autor:", null, '14px', null)],[$autor]);
        $row3 = $this->form->addFields([new TLabel("Data da criação:", null, '14px', null)],[$criacao]);
        $row4 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null)],[$descricao]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Gerar", new TAction([$this, 'onGenerate']), 'fas:search #ffffff');
        $btn_ongenerate->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Relatórios","Home"]));
        $container->add($this->form);

        TButton::disableField(self::$formName, 'btn_onexport');

        parent::add($container);

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

        $this->carregar();
    }

public function busca()
    {
        TTransaction::open('bedevops');
        $count = Relatorio::where('id',  'is not', null)->count();
        if ($count > 0) {
            $object = new stdClass();
            $object->titulo = Relatorio::last()->titulo;
            $object->autor = Relatorio::last()->user->name;
            $object->criacao = Relatorio::last()->criacao;
            $object->descricao = Relatorio::last()->descricao;
            //$object->fieldName = 'insira o novo valor aqui'; //sample
            TForm::sendData(self::$formName, $object);
            TSession::setValue(__CLASS__.'_filters', NULL);
            $filters[] = new TFilter('relatorio_id', '=', Relatorio::last()->id);
            TSession::setValue(__CLASS__.'_filters', $filters);
        } 
        TTransaction::close();

    }

    /**
     * Load the datagrid with data
     */
    public function carregar()
    {
        try
        {
            $this->busca();
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

            //<onBeforeChartLoad>

            //</onBeforeChartLoad>

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            //<onAfterChartLoad>

            //</onAfterChartLoad>

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

}

