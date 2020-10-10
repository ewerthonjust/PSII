<?php

class ItensRelatorio extends TRecord
{
    const TABLENAME  = 'itens_relatorio';
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
     * Method set_perguntas
     * Sample of usage: $var->perguntas = $object;
     * @param $object Instance of Perguntas
     */
    public function set_pergunta(Perguntas $object)
    {
        $this->pergunta = $object;
        $this->pergunta_id = $object->id;
    }

    /**
     * Method get_pergunta
     * Sample of usage: $var->pergunta->attribute;
     * @returns Perguntas instance
     */
    public function get_pergunta()
    {
    
        // loads the associated object
        if (empty($this->pergunta))
            $this->pergunta = new Perguntas($this->pergunta_id);
    
        // returns the associated object
        return $this->pergunta;
    }
    /**
     * Method set_relatorios
     * Sample of usage: $var->relatorios = $object;
     * @param $object Instance of Relatorios
     */
    public function set_relatorio(Relatorios $object)
    {
        $this->relatorio = $object;
        $this->relatorio_id = $object->id;
    }

    /**
     * Method get_relatorio
     * Sample of usage: $var->relatorio->attribute;
     * @returns Relatorios instance
     */
    public function get_relatorio()
    {
    
        // loads the associated object
        if (empty($this->relatorio))
            $this->relatorio = new Relatorios($this->relatorio_id);
    
        // returns the associated object
        return $this->relatorio;
    }

    
}

