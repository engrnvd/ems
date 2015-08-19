<?php
/**
 * Created by PhpStorm.
 * User: Engr. Naveed
 * Date: 2/5/2015
 * Time: 6:16 PM
 */

class FilterOptions {
    /**
     * @var string
     */
    private $condStr = "";
    /**
     * @var array
     * e.g. array(
     * 'date' => 'date >= <startDate>' AND date < <endDate>,
     * 'gender' => 'gender = 'male''
     * 'class_id' => 'class_id = 1'
     * )
     */
    private $condArray = array();
    /**
     * @var FilterField[]
     */
    public $filterFields = array();

    /**
     * @param $filterFields FilterField[]
     */
    function __construct($filterFields){
        $this->filterFields = $filterFields;

        // handle filterResults Request
        global $curPage;
        if(isset($_POST['filter'])){ $curPage->saveConfig('filter',$_POST['filter']); }

        // get page config from session and build condition array
        if($filterConfig = $curPage->getConfig('filter')){
            //$curPage->pr();
            //prses();
            foreach ( $filterConfig as $key => $value ){
                if(!empty($value)){
                    if(is_array($value) && areSet(array('start','end'),$value)){ // its a bw filter field
                        $this->condArray[$key] = "$key >= '{$value['start']}' AND $key < '{$value['end']}'";
                        foreach ( $value as $k => $v ){ $filterFields[$key]->bwValues[$k] = $v; }
                    }else{
                        $this->condArray[$key] = "$key = '{$value}'";
                        $filterFields[$key]->val = $value;
                    }
                }
            }
        }
    }

    /**
     * @return string
     */
    function conditionStr(){ return $this->condStr; }

    /**
     * @param String
     * @return TableObject[] | Student[]
     */
    function getRecords($classname){
        if(!empty($this->condArray)){
            $condArray = $this->condArray;
            foreach ( $condArray as $key => $value ){
                $obj = new $classname;
                if(!property_exists($obj,$key)){ unset($condArray[$key]); }
            }
            $this->condStr = join(" AND ", $condArray);
        }
        if(empty($this->condStr)){$this->condStr = "1"; }
        // pr($this->conditionStr(),"building cond for $classname");
        return $classname::findByCondition($this->condStr);
    }

    /**
     * @param string $label
     * @return string
     */
    function markup($label = ""){
        $output = "<div id='filterOptions' class='panel-group hidden-print'>";
        $output .= "<div class='panel panel-primary'>";
        $output .= "<div class='panel-heading'>";
        $output .= "<h4 class='panel-title'><a data-toggle='collapse' data-parent='#filterOptions' href='#ffFormCont'>Filter Options</a></h4>";
        $output .= "</div>"; // panel-heading
        $output .= $label ? " For $label" : "";
        $output .= "<div class='panel-collapse collapse in' id='ffFormCont'>";
        $output .= "<div class='panel-body'>";
        $output .= "<form method='post' id='filterOptionsForm' class='form-inline'>";
        foreach ( $this->filterFields as $fltfld ){ $output .= $fltfld->getMarkup(); }
        $output .= "<div class='form-group'>";
        $output .= "<input class='form-control btn btn-primary' type='submit' id='filterButton' name='filterResults' value='Filter Results'>";
        $output .= "</div>";
        $output .= "</form>";
        $output .= "</div>"; // panel-body
        $output .= "</div>"; // panel-collapse collapse
        $output .= "</div>"; // panel panel-primary
        $output .= "</div>"; // panel-group
        return $output;
    }

    /**
     * @return string
     * used in testReportStudent.php
     */
    function durationStr(){
        $retutn = "";
        $date = isset($this->filterFields['date']) ? $this->filterFields['date'] : false;
        if( $date && $date instanceof FilterField && !empty($date->bwValues) ){
            $months = getMonthsFromDates($date->bwValues['start'],$date->bwValues['end']);
            if($months['start'] == $months['end']){ return $months['start']; }
            $retutn = join(" - ", $months);
        }
        return $retutn;
    }
}