<?php
// required vars:
?>
<div id='changePwdCntnr' class='panel-group hidden-print'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <h4 class='panel-title'><a data-toggle='collapse' data-parent='#changePwdCntnr' href='#chPwdFormCont'>Change
                    Your Password</a></h4>
        </div>
        <div class='panel-collapse collapse' id='chPwdFormCont'>
            <div class='panel-body'>
                <form id="chngPwdForm" class="form-horizontal" method="post">
                    <div class='form-group'>
                        <label for='oldPwd' class='col-sm-4 control-label'>Old Password</label>

                        <div class='col-sm-4'><input class='form-control' type="password" id='oldPwd' name='oldPwd'
                                                     required></div>
                    </div>
                    <div class='form-group'>
                        <label for='newPwd' class='col-sm-4 control-label'>New Password</label>

                        <div class='col-sm-4'><input class='form-control' type="password" id='newPwd' name='newPwd'
                                                     required></div>
                    </div>
                    <div class='form-group'>
                        <label for='confrmPwd' class='col-sm-4 control-label'>Confirm Password</label>

                        <div class='col-sm-4'><input class='form-control' type="password" id='confrmPwd'
                                                     name='confrmPwd' required></div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-4 col-sm-offset-4'><input class='form-control btn btn-primary' type='submit'
                                                                     id='chPwdButton' name='chPwd' value='Update'></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>