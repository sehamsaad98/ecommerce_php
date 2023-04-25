<?php

$do='';
if(isset($_GET['do'])){
    $do=$_GET['do'];
}else{
    $do='manage';
}

// pages
if($do=='manage'){
    echo 'you are in the manage page';

}elseif($do=='add'){
    echo 'you are in the add page';

}else{
    echo'this page not found';
}