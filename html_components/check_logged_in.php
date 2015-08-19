<?php
// check for logged in
// if the user is already on login page, don't take him anywhere else
//prser();
// $user is defined in initialize.php
if (!$user->isLoggedIn() && !preg_match("/login\.php/", $_SERVER['REQUEST_URI'])) {
    redirect('login.php');
}
