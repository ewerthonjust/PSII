<?php
namespace Adianti\Widget\Form;

use Adianti\Widget\Form\AdiantiWidgetInterface;
use Adianti\Widget\Form\TField;

/**
 * Hidden field
 *
 * @version    7.2
 * @package    widget
 * @subpackage form
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class THidden extends TField implements AdiantiWidgetInterface
{
    protected $id;
    
    /**
     * Return the post data
     */
    public function getPostData()
    {
        $name = str_replace(['[',']'], ['',''], $this->name);
        
        if (isset($_POST[$name]))
        {
            return $_POST[$name];
        }
        else
        {
            return '';
        }
    }
    
    /**
     * Show the widget at the screen
     */
    public function show()
    {
        // set the tag properties
        $this->tag->{'name'}   = $this->name;  // tag name
        $this->tag->{'value'}  = $this->value; // tag value
        $this->tag->{'type'}   = 'hidden';     // input type
        $this->tag->{'widget'} = 'thidden';
        $this->tag->{'style'}  = "width:{$this->size}";
        
        if ($this->id and empty($this->tag->{'id'}))
        {
            $this->tag->{'id'} = $this->id;
        }
        else
        {
            $this->tag->{'id'} = 'thidden_' . mt_rand(1000000000, 1999999999);
        }
        
        // shows the widget
        $this->tag->show();
    }
}