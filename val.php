<?php
ob_start();
session_start();
$pageTitle='Homepage';
include "init.php";
if(isset($_GET['id'])){

    $id=$_GET['id'];
    $product= getAll('*','items' ," where id=$id" , '','id');
    foreach($product as $data){
?>

<center>
<div class="main">      
   <h2 class="fw-bold m-4">are you sure you want to add this item into your cart ? </h2>

  <img src="d73bb1ab2d3ece2d807c82de6a18bd7f-removebg-preview.png" >
   <form action="insertCat.php" method="post">
       <input type="text" name="name"  value="<?php echo $data["name"]?>">
       <input type="text" name="price"  value="<?php echo $data["price"]?>">
       <button name="addtocart" type="submit" class="btn btn-danger">I am sure</button>
         <br>
         <a href="index.php" class=" mt-4 fw-bold">Back to Homepage</a>
   </form>
</div>
</center>

<?php
}}

    include $tpl.'footer.php';
    ob_end_flush();
    ?>
