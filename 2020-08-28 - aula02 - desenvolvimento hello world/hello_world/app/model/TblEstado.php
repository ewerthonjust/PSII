<?php

class TblEstado extends TRecord
{
    const TABLENAME  = 'tbl_estado';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getTblCidades
     */
    public function getTblCidades()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado', '=', $this->id));
        return TblCidade::getObjects( $criteria );
    }

    
}

