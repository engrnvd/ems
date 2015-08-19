<?php require_once 'html_components/require_comps_start.php';

// handle changePwd Request
if(isset($_POST['chPwd'])){
    //$user->pr();
    $oldPwdHshd = sha1($_POST['oldPwd']);
    // validate
    $validator->validateMatchingFields(array('newPwd','confrmPwd'),$_POST);
    if($oldPwdHshd != $user->password->val){
        $msg = "Sorry, You enterd a wrong passord.";
        $msgType = 'danger';
    }elseif($errors = $validator->extractErrors()){
        $msg = "The two Passords don't match.";
        $msgType = 'danger';
    }elseif( empty($_POST['newPwd']) || empty($_POST['confrmPwd']) ){
        $msg = "The Passords can not be empty.";
        $msgType = 'danger';
    }else{
        $user->password->val = $_POST['newPwd'];
        if($user->dbSave()){
            $msg = "Password Changed.";
            $msgType = "success";
        }else{
            $msg = "Could Not Change Password. Try Again Later.";
            $msgType = "danger";
        }
    }
    $session->setMessage($msg,$msgType);
    reloadCurrentPage();
}





?>

<h2>Welcome to Preferences, <?php echo $user->userFullName(); ?>!</h2>
<p>What would you like to do?</p>

<?php require_once 'html_components/changePassword.php'; ?>


<?php require_once 'html_components/require_comps_end.php'; ?>
