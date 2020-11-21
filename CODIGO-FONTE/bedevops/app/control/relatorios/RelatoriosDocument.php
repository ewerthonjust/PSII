<?php

class RelatoriosDocument extends TPage
{
    private static $database = 'bedevops';
    private static $activeRecord = 'Relatorio';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/RelatoriosDocumentTemplate.html';

    /**
     * Form constructor
     * @param $param Request
     */
    
    public function __construct( $param )
    {
       parent::__construct(); 
    }

    public static function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $class = self::$activeRecord;
            $object = new $class($param['key']);

            $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
            $html->setMaster($object);

            $objectsResultado_relatorio_id = Resultado::where('relatorio_id', '=', $param['key'])->load();
            $html->setDetail('Resultado.relatorio_id', $objectsResultado_relatorio_id);
            $objectsItemRelatorio_relatorio_id = ItemRelatorio::where('relatorio_id', '=', $param['key'])->load();
            $html->setDetail('ItemRelatorio.relatorio_id', $objectsItemRelatorio_relatorio_id);

            $objectsItemRelatorio_relatorio_id = ItemRelatorio::where('relatorio_id', '=', $param['key'])
                     ->where('resposta', '=', '2')->load();
            $html->setDetail('ItemRelatorio.relatorio_id', $objectsItemRelatorio_relatorio_id);

	    $html->process();

	    $name = Relatorio::find($param['key']);
            $name = $name->titulo;

	    $document = 'tmp/'.$name.'.pdf'; 
            $html->saveAsPDF($document, 'A4', 'portrait');

            TTransaction::close();

            if(empty($param['returnFile']))
            {
                parent::openFile($document);

                new TMessage('info', _t('Document successfully generated'));    
            }
            else
            {
                return $document;
            }
        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

}

