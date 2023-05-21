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
                            items.id=? 
                        AND 
                             approve = 1");
 //    execute data 
 $stmt->execute(array($item_id));
 // do fetch for data
 
 $count = $stmt->rowcount();
 if($count > 0){
    $item = $stmt->fetch();
 
?>
<h1 class="text-center"><?php echo $item['name'] ;?></h1>
 <div class="container">
    <div class="row show-item">
        <div class="col-md-3">
            <img src='admin/images/items/ <?php echo $item['image'] ;?> ' class='card-img-top' style='height:350px;' class="card-img-top" alt="..."> 
        </div>
        <div class="col-md-9 item-info ">
            <h2><span>Name : </span><?php echo  $item['name'] ?> </h2>
            <p><span>Description : </span> <?php echo  $item['description'] ?> </p>
            <ul class="list-unstyled">
            <li>
            <i class="fa-regular fa-calendar-days"></i>
            <span>Added Date : </span><?php echo  $item['add_date'] ?> </li>
            <li> 
            <i class="fa-solid fa-money-bill"></i>
                 :$<?php echo  $item['price'] ?> </li>
            <li>  
                <i class="fa fa-building fa-fw"></i>
                <span>made in : </span>  <?php echo  $item['country_made'] ?>  </li>
            <li> 
                <i class="fa fa-tags fa-fw"></i>
                <span>category : </span> <a href="categories.php?pageid=<?php echo  $item['cat_id'] ?>"> <?php echo  $item['category_name'] ?> </a></li>
            <li>
                <i class="fa fa-user fa-fw"></i>
                <span>Added By :  </span> <a href="#"><?php echo  $item['username'] ?></a> </li>
            <li class="tag-items">
                <i class="fa fa-user fa-fw"></i>
                <span>Tags :  </span> 
                <?php $alltags= explode(',' , $item['tags']);
                    foreach($alltags as $tag){
                        $tag=str_replace(' ' ,'' , $tag );
                        if(!empty($tag)){
                        echo "<a href='tags.php?name=" . strtolower($tag) . "'class='tag-link' >" . $tag .' </a> | ';
                    }
                    }
                 ?>

                </li>
                
            </ul>
        </div>
    </div>
   <hr class="item-hr">
<?php  if (isset($_SESSION['user'])){ 
?> 
<!-- Add Comment Start -->
   <div class="row">
     <div class="offset-md-3  col-md-6">
        <div class="add-comment">
       <h3> Add Your Commet</h3>
       <form action="<?php echo $_SERVER['PHP_SELF'] . '?item_id=' . $item['id']?>" method="POST">
        <textarea class="form-control" name="comment" required></textarea>
        
        <input type="submit" class="btn btn-primary mt-2" value="add comment">
       </form>     
       <?php  
       if($_SERVER['REQUEST_METHOD']== 'POST'){
         $comment = $_POST['comment'] ;
         $itemid  = $item['id'];
         $userid  = $_SESSION['uid'];
         if(!empty($comment)){
            $stmt = $con->prepare('INSERT INTO 
                                      comments(comment ,status, added_date, item_id , user_id )
                                      VALUES(:zcomment , 0 , NOW(), :zitemid , :zuserid )');
              $stmt->execute(array(
								'zcomment' => $comment,
								'zitemid' => $itemid,
								'zuserid' => $userid
              ));
              if($stmt){
                echo '<div class="alert alert-success mt-2"> Comment Added</div>';
              }
                                   
         }
        }
       ?>       
        </div>
     </div>    
   </div>
<!-- End Comment Start -->
      <?php }else{
        echo "<a href= 'login.php'>login or register </a> to add comment";
      }?>
    <hr class="item-hr">
    <?php 
      $stmt=$con->prepare("SELECT 
                comments.*  ,users.username,users.avatar 
            FROM 
                comments
             JOIN 
                users 
            ON 
                users.id = comments.user_id
            WHERE 
                item_id = ?
            AND 
                status =1
            ORDER BY 
                c_id DESC 
  ");
        // excute the statement
        $stmt->execute(array($item['id']));
        // assign to variabels
        $comments=$stmt->fetchAll();



        foreach($comments as $comment){?>
          <div class="comment-area">
            <div class="row">
              <div class="col-sm-2 text-center">

              <img src='admin/images/avatars/ <?php echo $comment['avatar'] ;?> '  class="img-thumbnail rounded-circle mx-auto d-block" alt="user image "> 
              <?php echo  $comment['username'] ?> </div>
              <div class="col-sm-10">
               <p class="lead"> <?php echo  $comment['comment'] ?> </p></div>
            </div>
           </div>
            <hr class="item-hr">

<?php } ?>

 </div>
<?php 
} else {
    echo '<div class="container">';
    $theMsg= '<div class="alert alert-danger text-center mt-3 fw-bold " > There No Such ID  Or This Item Is Waiting Approval </div>'; 
    redirectFunction($theMsg , 'back' );

    echo '</div>';
}
include $tpl . 'footer.php';
ob_end_flush();

?>