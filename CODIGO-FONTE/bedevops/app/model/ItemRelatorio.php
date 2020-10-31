<?php

class ItemRelatorio extends TRecord
{
    const TABLENAME  = 'item_relatorio';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $pergunta;
    private $relatorio;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pergunta_id');
        parent::addAttribute('resposta');
        parent::addAttribute('comentario');
        parent::addAttribute('relatorio_id');
            
    }

    /**
     * Method set_pergunta
     * Sample of usage: $var->pergunta = $object;
     * @param $object Instance of Pergunta
     */
    public function set_pergunta(Pergunta $object)
    {
        $this->pergunta = $object;
        $this->pergunta_id = $object->id;
    }

    /**
     * Method get_pergunta
     * Sample of usage: $var->pergunta->attribute;
     * @returns Pergunta instance
     */
    public function get_pergunta()
    {
    
        // loads the associated object
        if (empty($this->pergunta))
            $this->pergunta = new Pergunta($this->pergunta_id);
    
        // returns the associated object
        return $this->pergunta;
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

