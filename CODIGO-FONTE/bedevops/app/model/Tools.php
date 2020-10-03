<?php

class Tools extends TRecord
{
    const TABLENAME  = 'tools';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('descricao');
            
    }

    /**
     * Method getQuestionss
     */
    public function getQuestionss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('Ferramentas_id', '=', $this->id));
        return Questions::getObjects( $criteria );
    }

    
}

