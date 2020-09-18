<?php

class ReportItems extends TRecord
{
    const TABLENAME  = 'report_items';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $questions;
    private $reports;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('questions_id');
        parent::addAttribute('reports_id');
        parent::addAttribute('resposta');
        parent::addAttribute('descricao');
            
    }

    /**
     * Method set_questions
     * Sample of usage: $var->questions = $object;
     * @param $object Instance of Questions
     */
    public function set_questions(Questions $object)
    {
        $this->questions = $object;
        $this->questions_id = $object->id;
    }

    /**
     * Method get_questions
     * Sample of usage: $var->questions->attribute;
     * @returns Questions instance
     */
    public function get_questions()
    {
    
        // loads the associated object
        if (empty($this->questions))
            $this->questions = new Questions($this->questions_id);
    
        // returns the associated object
        return $this->questions;
    }
    /**
     * Method set_reports
     * Sample of usage: $var->reports = $object;
     * @param $object Instance of Reports
     */
    public function set_reports(Reports $object)
    {
        $this->reports = $object;
        $this->reports_id = $object->id;
    }

    /**
     * Method get_reports
     * Sample of usage: $var->reports->attribute;
     * @returns Reports instance
     */
    public function get_reports()
    {
    
        // loads the associated object
        if (empty($this->reports))
            $this->reports = new Reports($this->reports_id);
    
        // returns the associated object
        return $this->reports;
    }

    
}

