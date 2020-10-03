<?php

class Categorias extends TRecord
{
    const TABLENAME  = 'categorias';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('categoria');
            
    }

    /**
     * Method getPerguntass
     */
    public function getPerguntass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categorias_id', '=', $this->id));
        return Perguntas::getObjects( $criteria );
    }

    
}

