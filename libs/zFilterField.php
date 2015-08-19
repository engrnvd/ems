<?php
/**
 * Created by PhpStorm.
 * User: Engr. Naveed
 * Date: 2/5/2015
 * Time: 12:15 PM
 */

class FilterField extends TableColumn{
    /**
     * @var bool
     * adds empty <option> tag to <select> tags
     */
    public $addEmptyOption = true;
    /**
     * @var string
     * possible  values:
     * - eq, lt, gt, bw
     */
    public $filterType = 'eq';
    /**
     * @var array
     * values for start and end
     */
    public $bwValues = array('start'=>'','end'=>'',);

    /**
     * @param $tableColumn TableColumn
     */
    function __construct($tableColumn){
        foreach ( $tableColumn as $key => $value ){
            $this->$key = $value;
            $this->required = false;
        }
    }

    /**
     * @return string
     */
    function getMarkup(){
        $output = "";
        switch ($this->filterType){
            case 'bw':
                $name = $this->name;
                foreach ( $this->bwValues as $key => $val ){
                    $config = array( 'name'=>'filter['.$name.']['.$key.']', );
                    $output .= "<div class='form-group'>";
                    $output .= "<label for='".$config['name']."'>".uc_words($key." ".$name)."</label>";
                    $this->val = $this->bwValues[$key];
                    $output .= $this->getInputMarkup($config);
                    $output .= "</div>";
                }
                break;
            case 'eq':
            case 'lt':
            case 'gt':
            default:
                $config = array( 'name'=>'filter['.$this->name.']', );
                $output .= "<div class='form-group'>";
                $output .= "<label for='".$config['name']."'>".uc_words($this->name)."</label>";
                $output .= $this->getInputMarkup($config);
                $output .= "</div>";
                break;
        }
        return $output;
    }

    /**
     * @param array $config
     * @return string
     */
    public function getInputMarkup($config = array()){
        $config['addEmptyOption'] = $this->addEmptyOption;
        $output = parent::getInputMarkup($config);
        return $output;
    }


} 