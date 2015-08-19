<?php
/**
 * Created by PhpStorm.
 * User: EngrNaveed
 * Date: 12/26/2014
 * Time: 10:39 AM
 */
class HtmlMarkup{

    function helpLink($href,$title="Help about this page."){
        $output = "<a class='helpLink' href='{$href}' target='_blank' title='{$title}'>".icon('question-sign')."</a>";
        return $output;
    }

    function echoError($errMsg){ echo "<p class='has-error hidden-print'>Error: $errMsg.</p>"; }

    function pageBreak(){ echo "<p class='pagebreak' style='page-break-after: always'>--Page Break Here--</p>"; }

    function pageBreakWidFooter(){
        $this->footerForPrint();
        $this->pageBreak();
    }

    function link($title,$href,$config=array()){
        $markup = "<a href='{$href}'";
        foreach ( $config as $attrib => $value ){
            $markup .= " $attrib='{$value}'";
        }
        $markup .= ">{$title}</a>";
        return $markup;
    }
    function link_blank($title,$href){
        return $this->link($title,$href,array("target"=>"_blank"));
    }

    function headerForPrint(){
        global $app_info;
        echo "<div class='headerForPrint visible-print'>";
//        echo "<div class='headerForPrint'>";
        echo "<div class='logo'><img src='images/logoA90.png' alt=''/></div>";
        echo "<h1>".$app_info['site_title']."</h1>";
        echo "</div>";
    }

    function footerForPrint(){
        global $app_info;
        echo "<footer class='footerForPrint visible-print'>";
            echo "<div>";
                echo "<p>".$app_info['site_title']." - ".icon('earphone')." ".$app_info['contact']."</p>";
            echo "</div>";
        echo "</footer>";
    }

    function echoTable($classname,$records){
        global $html;
        echo "<div id='tableContainer' class='table-responsive'>";
        require __DIR__."/../html_components/tableMarkup.php";
        echo "</div>";
    }

    function echoNewRecForm($classname){
        require __DIR__."/../html_components/newRecForm.php";
    }

    // hidden inputs, to be visible when an editable is clicked
    function echoHiddenInputs($columns){
//        $columns instanceof TableObject ? $columns->pr('callee'): pr($columns,'callee');
        if( $columns instanceof TableObject){
            echo "<div class='hidden'>";
            foreach ( $columns as $column ){
                if($column instanceof TableColumn){ echo $column->getInputForEditable(); }
            }
            echo "</div>";
        }else{
            echo "<p class='has-error'>Error: Edit function is disabled.</p>";
        }
    }

    function editable($field,$value,$table,$recordId){
        if($field=='id'){ return $value; }
        $cellId = encrypt( $table."-".$field."-".$recordId );
        return "<span class='editable' data-cell-id='".$cellId."' data-input-id='".$field."'>".$value."</span>";
    }

    public function getHtmlOptionsForArray( $array , $selectedVal=null, $config = array() ){
        $output = "";
        if(isset($config['addEmptyOption']) && $config['addEmptyOption'] == true ){
            $output .=  "<option></option>";
        }
        for ($i=0; $i < count($array) ; $i++) {
            $selected = $selectedVal == $array[$i] ? "selected" : "";
            $output .=  "<option $selected>".$array[$i]."</option>";
        }
        return $output;
    }

    public function queryStringFromArray( $arr ){
        if(!empty($arr)){
            foreach ($arr as $key => $value) {
                $qsArr[] = $key."=".urlencode($value);
            }
            $qString = implode("&", $qsArr);
            return $qString;
        }
        return false;
    }

    public function showTrForArray( $arr , $unwantedFields = array() ){
        if(!empty($arr)){
            foreach ($arr as $key => $value) {
                if( !in_array( $key, $unwantedFields ) ){
                    echo "<tr><td>".$key.":</td><td>".$value."</td></tr>";
                }
            }
        }
    }

    public function graphMarkup( $graphData, $options ){
        $output = "<p><a class='showModal' href='#' target-modal='".$options['main_id']."'>".$options['link']."</a></p>";
        $output .= "<div id='".$options['main_id']."' class='graphsContainer modal'>";
        $output .= "<h2>".$options['main_title']."</h2>";
        $output .= "<p><a href='#' class='printGraph'>Print</a></p>";
        foreach ($graphData as $hItem) {
            $graph_heading = $hItem[$options['graph_heading']];
            $bars = array();
            if($hItem['barsData']){
                foreach ($hItem['barsData'] as $key => $barItem) {
                    $bar = array( "bar_title" => "", "bar_max" => "", "bar_val" => "" );
                    foreach ($bar as $key => $value) {
                        if ( is_array($options[$key]) && isset( $options[$key]['func'] ) ) { // build params
                            foreach ( $options[$key]['params'] as $k => $v ) {
                                $params = array();
                                $params[] = $barItem[$v];
                            }
                            $bar[$key] = call_user_func_array( $options[$key]['func'], $params );
                        }else{
                            $bar[$key] = $barItem[$options[$key]];
                        }
                    }
                    $bars[] = $bar;
                }
                // pr($bars);
                $output .= graph( $graph_heading, $bars );
            }
        }
        $output .= "</div>"; // graphsContainer
        // $output .= "</div>"; // modalBkg
        return $output;
    }

    public function graph( $heading, $bars ){
        // You need to specify the following
        // 1. Graph heading (string)
        // 2. Bars (assoc. array)
        //     i. bar Max Value: max
        //     ii. bar Title: title
        //     iii. bar Value: val
        if ( $heading && $bars && is_array($bars) ) {
            $output = "<div id='".$heading."Graph' class='graph'>
            <h2 class='graphHeading'>".$heading."</h2>
            <div class='barsContainer'>";
            foreach ($bars as $key => $bar) {
                // $output .= "<div class='bars' total='".$bar['bar_max']."' baseTitle='".$bar['bar_title']."'>".$bar['bar_val']."</div>";
                // $output .= "<div class='bars' total='25' baseTitle='22'>21</div>";
                if ( isset($bar['bar_max']) && isset($bar['bar_title']) && isset($bar['bar_val']) ) {
                    $output .= "<div class='bars' total='".$bar['bar_max']."' baseTitle='".$bar['bar_title']."'>".$bar['bar_val']."</div>";
                }
            }
            $output .= "</div>"; //#barsContainer
            $output .= "</div>"; //.graph
            return $output;
        }
        return "Error: Graph data not properly specified.";
    }

    public function showBoolOptions( $selectedVal = 0 ){
        $output = "";
        for ($i=0; $i < 2 ; $i++) {
            $selected = $selectedVal == $i ? "selected" : "";
            $output .= "<option value='".$i."' $selected>".formBool($i)."</option>";
        }
        return $output;
    }

    public function monthsOptions($selectedVal=null){
        $output = "";
        for ($i=1; $i <= 12 ; $i++) {
            $selected = $selectedVal == $i ? "selected" : "";
            $output .= "<option value='".$i."' $selected>".date( "F" , mktime(0, 0, 0, $i, 1, 2000) )."</option>";
        }
        return $output;
    }

    public function dateOptions( $selectedVal=null ){
        for ($i=1; $i < 32 ; $i++) {
            $selected = $selectedVal == $i ? "selected" : "";
            echo "<option $selected>".$i."</option>";
        }
    }

    function showOptionsForDbTable( $columnName_display, $columnName_value, $tbl , $selectedVal=null){
        global $db;
        $output = "";
        $rows = $db->findBySql("SELECT DISTINCT ".$columnName_display.",".$columnName_value." FROM ".$tbl."");
        foreach ($rows as $row) {
            $selected = $selectedVal == $row[$columnName_display] ? "selected" : "";
            $output .= "<option value='{$row[$columnName_value]}' {$selected}>{$row[$columnName_display]}</option>";
        }
        return $output;
    }

}

$html = new HtmlMarkup();
