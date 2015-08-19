<?php
require_once __DIR__."/../html_components/require_comps_start.php";


if(Log_messag::saveLog("Test action performed")){
    pEcho("saved");
}else{
    pEcho("faild to save");
}