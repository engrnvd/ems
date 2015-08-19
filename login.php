<?php require_once 'html_components/require_comps_start.php';
if(isset($_GET['logout'])){
	$user->logout();
	$session->setMessage("You are now logged out." , "info");
    redirect('login.php');
}

//if the user is already logged in, no need to ask him again for the credentials, take him to the admin area:
if( $user->isLoggedIn() ){ redirect('index.php'); }

// else check to see if the form is submitted. If yes, authenticate...
if ( areSet( array( 'username','password' ), $_POST ) )
{
    if( User::authenticate($_POST['username'],$_POST['password']) )
    {
        redirect('index.php');
    }
    else
    {
        $session->setMessage("Incorrect Username and / or Password.",'danger');
        redirect("login.php");
    }
}

// page starts here:
?>
<div class="modalBackdrop"></div>
	<div class='row'>
	<div class='col-sm-12 col-lg-4 col-lg-offset-4'>
        <form id="loginForm" class="form-horizontal gridBkg" role="form" method="post">
            <div class="input-group">
                <label for="username" class="input-group-addon"><?=icon('user')?></label>
                <input class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <label for="password" class="input-group-addon"><?=icon('lock')?></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                    <div class="checkbox">
                        <label> <input type="checkbox" name="rememberMe"> Remember me </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                    <button type="submit" class="btn btn-primary form-control">Login</button>
                </div>
            </div>
        </form>
    </div>
    </div>
<?php require_once 'html_components/require_comps_end.php'; ?>
