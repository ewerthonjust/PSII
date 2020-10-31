<?php

class Categoria extends TRecord
{
    const TABLENAME  = 'categoria';
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
     * Method getPerguntas
     */
    public function getPerguntas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_id', '=', $this->id));
        return Pergunta::getObjects( $criteria );
    }
    /**
     * Method getResultados
     */
    public function getResultados()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_id', '=', $this->id));
        return Resultado::getObjects( $criteria );
    }

    
}

