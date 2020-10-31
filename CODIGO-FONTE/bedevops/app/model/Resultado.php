<?php

class Resultado extends TRecord
{
    const TABLENAME  = 'resultado';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $categoria;
    private $relatorio;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('categoria_id');
        parent::addAttribute('relatorio_id');
        parent::addAttribute('valor');
            
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
     * Method set_relatorio
     * Sample of usage: $var->relatorio = $object;
     * @param $object Instance of Relatorio
     */
    public function set_relatorio(Relatorio $object)
    {
        $this->relatorio = $object;
        $this->relatorio_id = $object->id;
    }

    /**
     * Method get_relatorio
     * Sample of usage: $var->relatorio->attribute;
     * @returns Relatorio instance
     */
    public function get_relatorio()
    {
    
        // loads the associated object
        if (empty($this->relatorio))
            $this->relatorio = new Relatorio($this->relatorio_id);
    
        // returns the associated object
        return $this->relatorio;
    }

    
}

