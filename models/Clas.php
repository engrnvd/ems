<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Clas extends ClasAuto{
	static $joinedTables = array();
    static $displayFields = array('class','campus_id','session');
//    static $childClasses = array('Class_section','Student','Test');
    static $childRefField = 'class_id';

    function __construct($id = null){
        parent::__construct($id);
        $this->class->fkeyInfo = new FKeyInfo('Config_class','class','select');
        $this->campus_id->fkeyInfo = new FKeyInfo('Campus','id','select');
        $this->subcampus_id->fkeyInfo = new FKeyInfo('Sub_campus','id','select');
        $this->degree_id->fkeyInfo = new FKeyInfo('Degre','id','select');
    }

    /**
     * @param array $config
     * @return TableObject[]
     */
    function class_sections($config=array()){ return $this->getChildRecs('Class_section',$config); }

    /**
     * @param array $config
     * @return TableObject[]
     */
    function students($config=array()){ return $this->getChildRecs('Student',$config); }

    /**
     * @return int
     */
    function maxRollNum(){
        if($this->id->val){ $student = Student::findOneByCondition("class_id=".$this->id->val." ORDER BY roll_num DESC"); }
        else{ return 0; }
        return ( $student && !$student->isEmpty() ) ? $student->roll_num->val : 0;
    }

    /**
     * @return Config_class
     */
    function config(){
        return Config_class::findOneByCondition("class='".$this->class."'");
    }

    /**
     * @return string|TableObject[]
     */
    function subjectCombinations(){
        if( $subjCombIds = $this->config()->getLinkedRecs('Subject_combination')){
            return Subject_combination::findByCondition("id in(".join(",",$subjCombIds).")");
        }
        return "";
    }

    /**
     * @return array
     */
    static function childClasses(){
        return array(
            new ChildClass('Class_section', 'restrict'),
            new ChildClass('Student','restrict'),
            new ChildClass('Test','restrict')
        );
    }

    /**
     * @return string
     */
    static function classTitle(){
        return "Class";
    }
}
