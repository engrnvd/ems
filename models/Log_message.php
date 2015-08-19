<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class Log_messag extends Log_messagAuto{
	static $joinedTables = array();
	static $childRefField = '';
	static $displayFields = array('user_id','action','time');

	function __construct($id = null){
		parent::__construct($id);
        $this->user_id->fkeyInfo = new FKeyInfo('User','id','select');
	}

    static function saveLog($action,$userRec = null){
        $log = new Log_messag();
        global $user;
        if(!$userRec){ $userRec = $user; }
        if(!empty($userRec->id->val)){ // if user is naveed, their will not be any user id
            $log->action->val = $action;
            $log->user_id->val = $userRec->id->val;
            $log->time->val = strftime("%Y-%m-%d-%H-%M-%S", (time() + 5*3600));
            return $log->dbSave();
        }
        return true;
    }

    static function clearLog(){
        global $db;
        if($db->delete(static::tablename(),"1")){
            static::saveLog("Log Cleared");
            return true;
        }
        return false;
    }

    static function reportHeads(){
        return array(
            'time',
            'user_id',
            'action',
        );
    }




}
