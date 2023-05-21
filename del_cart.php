<?php
ob_start();
session_start();
$pageTitle = 'cart';
include 'init.php';        
echo '<div class="container">';
$ID =$_GET['id'];
$check=checkItem('id' , 'cart' , $ID);      
// if there is such id show this form 
if ($check>0){
    $stmt=$con->prepare("DELETE FROM cart WHERE id =:zcart");
    
    $stmt->bindParam(":zcart" , $ID);
    $stmt->execute();
    $theMsg= "<div class='alert alert-success mt-4' >" . $stmt->rowcount() .'   ' .'record Deleted</div>';
    redirectFunction($theMsg , 'back' );

}else{
   $theMsg= "<div class = 'alert alert-danger'>This Id Is Not Exist</div>";
   redirectFunction($theMsg );
}
echo '</div>';
header('location:cart.php');