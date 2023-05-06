<?php 
ob_start();
session_start();
include "init.php";?>
<div class="container categories">
    <h1 class="text-center">  <?php echo str_replace('-' , ' ' ,$_GET['pagename'] ) ?></h1>
        
    <div class="row row-cols-md-4 row-cols-sm-2">
    <?php  foreach(getItems('cat_id',$_GET['pageid']) as $item){
         echo'<div class="col  ">';
         echo' <div class="card item-box ">' ;
         echo '<span class="price-tag">'.$item['price'] .'</span>';
         echo '<span class="favorit "><i class="fa-regular fa-heart"></i> </span>';
         echo '<img src="sss02.jpg" class="card-img-top" alt="..."> ';
         echo '<div class="card-body">';
         echo '<h5 class="card-title">'.$item['name'] .'</h5>';
         echo '<p class="card-text p-0 m-0">'. $item['description'] .  '<span class="".</p>';
         echo '<p class="card-text p-0 m-0">'. $item['price'] .  '<span class="".</p>';

         echo '</div>';
         echo '</div>';
         echo ' </div>';
    } ?> 
    <?php  foreach(getItems('cat_id',$_GET['pageid']) as $item){
         echo'<div class="col  ">';
         echo' <div class="card item-box ">' ;
         echo '<span class="price-tag">'.$item['price'] .'</span>';
         echo '<span class="favorit"><i class="fa-regular fa-heart"></i> </span>';
         echo '<img src="sss02.jpg" class="card-img-top" alt="..."> ';
         echo '<div class="card-body">';
         echo '<h5 class="card-title">'.$item['name'] .'</h5>';
         echo '<p class="card-text p-0 m-0">'. $item['description'] .  '<span class="".</p>';
         echo '<p class="card-text p-0 m-0">'. $item['price'] .  '<span class="".</p>';

         echo '</div>';
         echo '</div>';
         echo ' </div>';
    } ?> 
        <?php  foreach(getItems('cat_id',$_GET['pageid']) as $item){
         echo'<div class="col  ">';
         echo' <div class="card item-box ">' ;
         echo '<span class="price-tag">'.$item['price'] .'</span>';
         echo '<span class="favorit"><i class="fa-regular fa-heart"></i> </span>';
         echo '<img src="sss02.jpg" class="card-img-top" alt="..."> ';
         echo '<div class="card-body">';
         echo '<h5 class="card-title">'.$item['name'] .'</h5>';
         echo '<p class="card-text p-0 m-0">'. $item['description'] .  '<span class="".</p>';
         echo '<p class="card-text p-0 m-0">'. $item['price'] .  '<span class="".</p>';

         echo '</div>';
         echo '</div>';
         echo ' </div>';
    } ?> 
</div>
</div>

<?php include $tpl.'footer.php';
ob_end_flush();
?>