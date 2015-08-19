<?php
require_once "../initialize.php";

// config classes
// foreach class:
    // if there are no defInstallments
        // starting month => 12
        // 1 to starting month
        //`config_class_id` = this id
        // `month` = this month
        // `fee_category_id` = 1 "tuition fee"
        // `amount` = annual dues / 12
$config_classes = Config_class::findAll();
foreach ( $config_classes as $conClassId => $confClass ){
    if($confClass instanceof Config_class){}
    if( !$confClass->defInstallments() ){
        for( $month = $confClass->starting_month->val; $month <= 12; $month++ ){
            $defInstallment = new Default_installment();
            $defInstallment->config_class_id->val = $conClassId;
            $defInstallment->fee_category_id->val = 1;
            $defInstallment->amount->val = $confClass->annual_dues->val / 12;
            $defInstallment->month->val = $month;
            $defInstallment->dbSave();
        }
        for( $month = 1; $month < $confClass->starting_month->val; $month++ ){
            $defInstallment = new Default_installment();
            $defInstallment->config_class_id->val = $conClassId;
            $defInstallment->fee_category_id->val = 1;
            $defInstallment->amount->val = $confClass->annual_dues->val / 12;
            $defInstallment->month->val = $month;
            $defInstallment->dbSave();
        }
    }
}
