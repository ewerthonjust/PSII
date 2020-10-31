<?php

class Pergunta extends TRecord
{
    const TABLENAME  = 'pergunta';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $ferramenta;
    private $categoria;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pergunta');
        parent::addAttribute('descricao');
        parent::addAttribute('ferramenta_id');
        parent::addAttribute('categoria_id');
            
    }

    /**
     * Method set_ferramenta
     * Sample of usage: $var->ferramenta = $object;
     * @param $object Instance of Ferramenta
     */
    public function set_ferramenta(Ferramenta $object)
    {
        $this->ferramenta = $object;
        $this->ferramenta_id = $object->id;
    }

    /**
     * Method get_ferramenta
     * Sample of usage: $var->ferramenta->attribute;
     * @returns Ferramenta instance
     */
    public function get_ferramenta()
    {
    
        // loads the associated object
        if (empty($this->ferramenta))
            $this->ferramenta = new Ferramenta($this->ferramenta_id);
    
        // returns the associated object
        return $this->ferramenta;
    }
    /**
     * Method set_categoria
     * Sample of usage: $var->categoria = $object;
     * @param $object Instance of Categoria
     */
    public function set_categoria(Categoria $object)
    {
        $this->categoria = $object;
        $this->categoria_id = $object->id;
    }

    /**
     * Method get_categoria
     * Sample of usage: $var->categoria->attribute;
     * @returns Categoria instance
     */
    public function get_categoria()
    {
    
        // loads the associated object
        if (empty($this->categoria))
            $this->categoria = new Categoria($this->categoria_id);
    
        // returns the associated object
        return $this->categoria;
    }

    /**
     * Method getItemRelatorios
     */
    public function getItemRelatorios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pergunta_id', '=', $this->id));
        return ItemRelatorio::getObjects( $criteria );
    }

    
}

