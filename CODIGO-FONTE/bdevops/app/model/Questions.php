<?php

class Questions extends TRecord
{
    const TABLENAME  = 'questions';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $Ferramentas;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('question');
        parent::addAttribute('descricao');
        parent::addAttribute('Ferramentas_id');
            
    }

    /**
     * Method set_tools
     * Sample of usage: $var->tools = $object;
     * @param $object Instance of Tools
     */
    public function set_Ferramentas(Tools $object)
    {
        $this->Ferramentas = $object;
        $this->Ferramentas_id = $object->id;
    }

    /**
     * Method get_Ferramentas
     * Sample of usage: $var->Ferramentas->attribute;
     * @returns Tools instance
     */
    public function get_Ferramentas()
    {
    
        // loads the associated object
        if (empty($this->Ferramentas))
            $this->Ferramentas = new Tools($this->Ferramentas_id);
    
        // returns the associated object
        return $this->Ferramentas;
    }

    /**
     * Method getReportItemss
     */
    public function getReportItemss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('questions_id', '=', $this->id));
        return ReportItems::getObjects( $criteria );
    }

    
}

