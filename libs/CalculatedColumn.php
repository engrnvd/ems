<?php
/**
 * User: Engr. Naveed
 * Date: 07-Feb-15
 * Time: 5:14 PM
 */

class CalculatedColumn {
    /**
     * @var
     * name of the field after which $this should appear (in html tables etc)
     */
    public $after;
    /**
     * @var
     */
    public $object;
    /**
     * @var
     */
    public $name;

    function __construct($name,$object,$after)
    {
        $this->after = $after;
        $this->object = $object;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function val(){
        return call_user_func(array($this->object, $this->name));
    }

    public function __toString(){
        return (string)$this->val();
    }
} 