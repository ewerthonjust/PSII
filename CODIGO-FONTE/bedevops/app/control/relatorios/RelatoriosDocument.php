<?php

class RelatoriosDocument extends TPage
{
    private static $database = 'bedevops';
    private static $activeRecord = 'Relatorios';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/RelatoriosDocumentTemplate.html';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {

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

            $html->process();

            $document = 'tmp/'.uniqid().'.pdf'; 
            $html->saveAsPDF($document, 'A4', 'portrait');

            TTransaction::close();

            if(empty($param['returnFile']))
            {
                $window = TWindow::create('PDF', 0.8, 0.8);
                $object = new TElement('object');
                $object->data  = "download.php?file={$document}";
                $object->type  = 'application/pdf';
                $object->style = "width: 100%; height:calc(100% - 10px)";
                $window->add($object);
                $window->show();

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

