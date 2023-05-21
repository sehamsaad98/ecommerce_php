<?php
ob_start();
session_start();
$pageTitle='Homepage';
include "init.php"; ?>
<div class="container categories">        
    <div class="row  row-cols-sm-2 row-cols-md-3 row-cols-lg-4 ">
    <?php  foreach(getAll( '*','items' , 'WHERE approve = 1','' ,'id' ) as $item){
         echo'<div class="col mb-2  ">';
         echo' <div class="card item-box ">' ;
         echo '<span class="price-tag text-center">$'.$item['price'] .'</span>';
         echo '<span class="favorit "><i class="fa-regular fa-heart"></i> </span>';
         echo"<img src='admin/images/items/ " . $item['image'] . "' class='card-img-top' style='height:350px;' > ";
         echo '<div class="card-body">';
         echo '<h5 class="card-title"><a href="items.php?item_id=' . $item['id'].'">'.$item['name'] .'</a></h5>';
        //  echo '<p class="card-text p-0 m-0">'. $item['description'] .  '<span class="".</p>';
         echo '<a href="val.php?id='.$item['id'] .'" class="btn btn-cart m-0"><i class="fa-solid fa-cart-shopping"></i> Add to cart <span class="">.</a>';
         echo '<p class="date  card-text p-0 m-0"> '. $item['add_date'] .  '<span class="">.</p>';
         echo '</div>';
         echo '</div>';
         echo ' </div>';
    } ?> 
</div>
</div>



<?php
include $tpl.'footer.php';
ob_end_flush();
?>

