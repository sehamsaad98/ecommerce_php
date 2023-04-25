<?php
/*
==============================================
==categories
==you can add|edit|delete members here
==============================================
*/

session_start();
$pageTitle = 'categories';
// print_r($_SESSION);
if (isset($_SESSION['usersession'])) {
    include 'init.php';
    $do = '';
    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }
    // start manage page 
    if ($do == 'manage') {//manage pag categories
        echo 'welcome';
     
    }elseif($do == 'add'){
        
    }elseif($do == 'insert'){
        
    }elseif($do == 'update'){ 
     
}
elseif($do=='Delete'){
   
}elseif($do=='Activate'){
   
}
               // end manage page
    include $tpl . 'footer.php';
} else {
    header('location:index.php');
    exit();
}
