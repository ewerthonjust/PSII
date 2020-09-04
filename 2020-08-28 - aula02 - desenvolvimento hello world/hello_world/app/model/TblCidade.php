<?php

class TblCidade extends TRecord
{
    const TABLENAME  = 'tbl_cidade';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_estado;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('estado');
            
    }

    /**
     * Method set_tbl_estado
     * Sample of usage: $var->tbl_estado = $object;
     * @param $object Instance of TblEstado
     */
    public function set_fk_estado(TblEstado $object)
    {
        $this->fk_estado = $object;
        $this->estado = $object->id;
    }

    /**
     * Method get_fk_estado
     * Sample of usage: $var->fk_estado->attribute;
     * @returns TblEstado instance
     */
    public function get_fk_estado()
    {
    
        // loads the associated object
        if (empty($this->fk_estado))
            $this->fk_estado = new TblEstado($this->estado);
    
        // returns the associated object
        return $this->fk_estado;
    }

    /**
     * Method getTblUsuarios
     */
    public function getTblUsuarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cidade', '=', $this->id));
        return TblUsuario::getObjects( $criteria );
    }

    
}

