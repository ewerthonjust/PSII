<?php

class Ferramentas extends TRecord
{
    const TABLENAME  = 'ferramentas';
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
     * Method getPerguntass
     */
    public function getPerguntass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('ferramenta_id', '=', $this->id));
        return Perguntas::getObjects( $criteria );
    }

    
}

