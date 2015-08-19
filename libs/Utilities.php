<?php
/**
 * User: Engr. Naveed
 * Date: 1/27/2015
 * Time: 9:50 PM
 */

class DeleteResponse {
    public $succeeded;
    public $detail;

    function __construct($detail, $succeeded = true)
    {
        $this->detail = $detail;
        $this->succeeded = $succeeded;
    }

}

class Error {
    public $field;
    public $desc;

    function __construct($field,$desc){
        $this->field = $field;
        $this->desc = $desc;
    }
}

class FKeyInfo {
    public $fClass;
    public $fField;
    /**
     * @var string
     * Possible Values:
     * select:
     * A <select> tag will be shown
     * hint:
     * Hints will be shown via ajax
     * live:
     * example: section is a live fkey
     * fClass: Class_section
     * fField: id
     * type: live
     * local Field to match: classId
     */
    public $type = "";
    /**
     * @var string
     * used only in case of live fkeys
     * e.g. used in Student class
     * Note: column with dependentFields and the field to match are the same (see Student class) You have to specify both.
     */
    public $fieldToMatch;

    function __construct($class, $field, $type){
        $this->fClass = $class;
        $this->fField = $field;
        $this->type = $type;
    }
}

class ChildClass {
    public $name;
    /**
     * @var string
     * possible values:
     * no action, restrict, cascade, set null
     */
    public $onDelete;
    public $onUpdate;
    public $autoInsert = false;
    /**
     * @var bool
     */
    public $showAutoInsertForm = true;
    public $fieldsWithInput = array();
    public $fieldsWithDesc = array();
    /**
     * @var bool
     * whether the child records are displayed in recordDetail.php or not
     * e.g. Employee and Student Attendeance recs are unnecessary to display, there may be too many
     */
    public $showUnderRecDetail = true;

    function __construct($name, $onDelete = 'no action', $onUpdate = 'no action'){
        $this->name = $name;
        $this->onDelete = $onDelete;
        $this->onUpdate = $onUpdate;
    }


}