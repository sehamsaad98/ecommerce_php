<?php
ini_set('display_errors' , 'on');
error_reporting(E_ALL);
include 'admin/connect.php';
$sessionUser = '';
if(isset($_SESSION['user'])){
    $sessionUser=$_SESSION['user'];
}
$tpl = 'includes/templates/';//tempelate dirctory
$lang='includes/languages/';
$func='includes/functions/';//fuction directory
$css='layout/css/'; //lead to css directory
$js='layout/js/'; //lead to js directory

// iclude important files
include $func . 'functions.php';
include $lang . "en.php";
include $tpl.'header.php';


// include navbar on all pages Except The One With $noNavbar variable
// if( !isset($nonavbar)){
//  include $tpl.'navbar.php';   
// }



