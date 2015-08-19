<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Pag extends PagAuto{
	static $joinedTables = array();
	static $childRefField = 'parent_id';
	static $displayFields = array('title','url');
    public $name = "";

	function __construct($id = null){
		parent::__construct($id);
        $this->parent_id->fkeyInfo = new FKeyInfo('Pag','id','hint');
	}

    /**
     * @param $configCateg: String
     * possible values: 'filter'
     * @return array
     */
    public function getConfig($configCateg){
        if( isset($_SESSION[$this->name][$configCateg]) ){ return $_SESSION[$this->name][$configCateg]; }
        return array();
    }

    public function saveConfig($configCateg, $configArray){
        $_SESSION[$this->name][$configCateg] = $configArray;
    }

    static function childClasses(){
        return  array(
            new ChildClass('Pag', 'restrict'),
        );
    }

    static function classTitle(){ return "Page"; }

    public function isPaginated(){
        return $this->getConfig('pagination');
    }


}