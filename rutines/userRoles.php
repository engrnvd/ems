<?php
require_once "../initialize.php";

// find all user roles, pages
// foreach role:
    // foreach page:
    // if not already exists: insert rec

$roles = User_rol::findAll();
$pages = Pag::findAll();
foreach ( $roles as $role_id => $role ){
    foreach ( $pages as $page_id => $page ){
        if(!User_roles__pag::findByCondition("user_roles_id={$role_id} and pages_id = {$page_id}")){
            $rec = new User_roles__pag();
            $rec->user_roles_id->val = $role_id;
            $rec->pages_id->val = $page_id;
            $rec->dbSave();
        }
    }
}