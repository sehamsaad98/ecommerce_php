<?php
	ob_start();
session_start();
$pageTitle = 'Show Items';
include "init.php"; 
 // using short if condion to chick if userid  is numeric and get the integer value of it 
 $item_id = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;

 // select all data from db using this  id
 $stmt = $con->prepare("SELECT 
                            items.*, 
                            categories.name AS category_name, users.username 
                        FROM 
                            items    
                        INNER JOIN 
                            categories 
                        ON 
                            categories.id = items.cat_id
                        INNER JOIN 
                            users 
                        ON 
                            users.id = items.member_id
                        WHERE 
                            items.id=? ");
 //    execute data 
 $stmt->execute(array($item_id));
 // do fetch for data
 
 $count = $stmt->rowcount();
 if($count > 0){
    $item = $stmt->fetch();
 
?>
<h1 class="text-center"><?php echo $item['name'] ;?></h1>
 <div class="container">
    <div class="row">
        <div class="col-md-3">
            <img src="sss02.jpg" class="card-img-top" alt="..."> 
        </div>
        <div class="col-md-9">
            <h2><?php echo  $item['name'] ?> </h2>
            <p><?php echo  $item['description'] ?> </p>
            <span><?php echo  $item['add_date'] ?> </span>
            <div> $<?php echo  $item['price'] ?> </div>
            <div>made in :  <?php echo  $item['country_made'] ?> </div>
            <div>category :  <?php echo  $item['category_name'] ?> </div>
            <div>Added By :  <?php echo  $item['username'] ?> </div>




        </div>
    </div>
 </div>
<?php 
} else {
    echo "there no such id " ; 
}
include $tpl . 'footer.php';
ob_end_flush();

?>