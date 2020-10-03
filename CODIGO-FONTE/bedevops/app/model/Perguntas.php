<?php

class Perguntas extends TRecord
{
    const TABLENAME  = 'perguntas';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $ferramenta;
    private $categorias;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pergunta');
        parent::addAttribute('descricao');
        parent::addAttribute('ferramenta_id');
        parent::addAttribute('categorias_id');
            
    }

    /**
     * Method set_ferramentas
     * Sample of usage: $var->ferramentas = $object;
     * @param $object Instance of Ferramentas
     */
    public function set_ferramenta(Ferramentas $object)
    {
        $this->ferramenta = $object;
        $this->ferramenta_id = $object->id;
    }

    /**
     * Method get_ferramenta
     * Sample of usage: $var->ferramenta->attribute;
     * @returns Ferramentas instance
     */
    public function get_ferramenta()
    {
    
        // loads the associated object
        if (empty($this->ferramenta))
            $this->ferramenta = new Ferramentas($this->ferramenta_id);
    
        // returns the associated object
        return $this->ferramenta;
    }
    /**
     * Method set_categorias
     * Sample of usage: $var->categorias = $object;
     * @param $object Instance of Categorias
     */
    public function set_categorias(Categorias $object)
    {
        $this->categorias = $object;
        $this->categorias_id = $object->id;
    }

    /**
     * Method get_categorias
     * Sample of usage: $var->categorias->attribute;
     * @returns Categorias instance
     */
    public function get_categorias()
    {
    
        // loads the associated object
        if (empty($this->categorias))
            $this->categorias = new Categorias($this->categorias_id);
    
        // returns the associated object
        return $this->categorias;
    }

    /**
     * Method getItensRelatorios
     */
    public function getItensRelatorios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pergunta_id', '=', $this->id));
        return ItensRelatorio::getObjects( $criteria );
    }

    
}

