<?php

class Relatorio extends TRecord
{
    const TABLENAME  = 'relatorio';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('user_id');
        parent::addAttribute('titulo');
        parent::addAttribute('descricao');
        parent::addAttribute('criacao');
            
    }

    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_user(SystemUsers $object)
    {
        $this->user = $object;
        $this->user_id = $object->id;
    }

    /**
     * Method get_user
     * Sample of usage: $var->user->attribute;
     * @returns SystemUsers instance
     */
    public function get_user()
    {
    
        // loads the associated object
        if (empty($this->user))
            $this->user = new SystemUsers($this->user_id);
    
        // returns the associated object
        return $this->user;
    }

    /**
     * Method getItemRelatorios
     */
    public function getItemRelatorios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('relatorio_id', '=', $this->id));
        return ItemRelatorio::getObjects( $criteria );
    }
    /**
     * Method getResultados
     */
    public function getResultados()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('relatorio_id', '=', $this->id));
        return Resultado::getObjects( $criteria );
    }

    
}

