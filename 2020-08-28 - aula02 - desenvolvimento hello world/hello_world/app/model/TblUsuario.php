<?php

class TblUsuario extends TRecord
{
    const TABLENAME  = 'tbl_usuario';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_cidade;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('sobrenome');
        parent::addAttribute('empresa');
        parent::addAttribute('cidade');
        parent::addAttribute('telefone');
        parent::addAttribute('email');
            
    }

    /**
     * Method set_tbl_cidade
     * Sample of usage: $var->tbl_cidade = $object;
     * @param $object Instance of TblCidade
     */
    public function set_fk_cidade(TblCidade $object)
    {
        $this->fk_cidade = $object;
        $this->cidade = $object->id;
    }

    /**
     * Method get_fk_cidade
     * Sample of usage: $var->fk_cidade->attribute;
     * @returns TblCidade instance
     */
    public function get_fk_cidade()
    {
    
        // loads the associated object
        if (empty($this->fk_cidade))
            $this->fk_cidade = new TblCidade($this->cidade);
    
        // returns the associated object
        return $this->fk_cidade;
    }

    
}

