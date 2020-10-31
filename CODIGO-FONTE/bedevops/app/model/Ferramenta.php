<?php

class Ferramenta extends TRecord
{
    const TABLENAME  = 'ferramenta';
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
     * Method getPerguntas
     */
    public function getPerguntas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('ferramenta_id', '=', $this->id));
        return Pergunta::getObjects( $criteria );
    }

    
}

