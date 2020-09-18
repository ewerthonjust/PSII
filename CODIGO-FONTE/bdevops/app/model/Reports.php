<?php

class Reports extends TRecord
{
    const TABLENAME  = 'reports';
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
     * Method getReportItemss
     */
    public function getReportItemss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('reports_id', '=', $this->id));
        return ReportItems::getObjects( $criteria );
    }

    
}

