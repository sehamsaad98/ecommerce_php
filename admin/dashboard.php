<?php
session_start();
// print_r($_SESSION);
if (isset($_SESSION['usersession'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';
    // start dashboard page \
    $numUsers = 5; // The Number Of The Latest Users 
    $latestUsers = getLatest("*", "users", "id", $numUsers  ); //Latest Users Array 
    $numItems = 5; // The Number Of The Latest Items
    $latestItems = getLatest("*", "items", "id", $numItems); //Latest Items Array 
    $numcomments = 2; // The Number Of The Latest Items
    $latestcomment = getLatest("*", "comments", "c_id", $numcomments); //Latest Items Array 
?>
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    <i class="fa fa-users"></i>
                  <div class="info">
                  Total Members
                    <span><a href="members.php"><?php echo countItmes('id', 'users') ?></a></span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                <i class="fa-solid fa-user-plus"></i>
                <div class="info">
                    Pending Members
                    <span><a href="members.php?do=manage&page=pending">
                            <?php echo checkItem('regStatus', 'users', 0) ?>
                        </a></span>                    
                 </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                <i class="fa-solid fa-tags"></i> 
                <div class="info">
                 Total Items
                <span><a href="items.php"><?php echo countItmes('id', 'items') ?></a></span>                   
                </div>               
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">            
                    <i class="fa-solid fa-comments"></i>
                    <div class="info">
                    Total Comments
                    <span><a href="comments.php"><?php echo countItmes('c_id', 'comments') ?></a></span>                   
                    </div>
                </div>
            </div>
        </div>  
    </div>


    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-users"></i> Latest <?php echo $numUsers ?> Regested Users
                        <span class="toggle-info float-end">
                        <i class="fa-sharp fa-solid fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <ul class="list-group list-group-flush latest-users ">
                        <?php    
                            $stmt=$con->prepare("SELECT * FROM users WHERE groupid != 1  ORDER BY  id DESC  LIMIT $numUsers ");
                            // excute the statement
                            $stmt->execute();
                            // assign to variabels
                            $rows=$stmt->fetchAll();
                        if(  !empty($rows)){             
                        foreach ($rows as $user) {
                            echo " <li class='list-group-item'>" . $user['username'] ;
                            echo " <a href='members.php?do=edit&userid=". $user['id'] . "'>";
                             echo "<span class='btn btn-success float-end'>";
                             echo"<i class='fa fa-edit'></i>Edit ";
                             if($user['regStatus']== 0){
                                echo "<a href='members.php?do=Activate&userid=". $user['id']."' class='btn btn-info activate  float-end '><i class='fa-solid fa-play'></i>Activate</a>";
                              }
                             echo "</span> </a></li> ";
                        }}else{
                            echo " <li class='list-group-item  text-center'> There Is No Record Here </li>"  ;
                        }
                        ?>
                    </ul>
                </div>   
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <?php $theLatest = 3; ?>
                    <div class="card-header">
                        <i class="fa fa-home"></i> Latest <?php echo $numItems ?> Items Added
                        <span class="toggle-info float-end">
                        <i class="fa-sharp fa-solid fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <ul class="list-group list-group-flush latest-users">
                        <?php
                        if(!empty($latestItems)){
                      foreach ($latestItems as $item) {
                        echo " <li class='list-group-item '>" . $item['name'] ;
                        echo " <a href='items.php?do=edit&item_id=". $item['id'] . "'>";
                         echo "<span class='btn btn-success float-end'>";
                         echo"<i class='fa fa-edit'></i>Edit ";
                         if($item['approve']== 0){
                            echo "<a href='items.php?do=Approve&item_id=". $item['id']."' class='btn btn-info activate btn-sm  float-end '><i class='fa-solid fa-check'></i>Approve </a>";
                          }
                         echo "</span> </a></li> ";
                    }}else{
                        echo " <li class='list-group-item  text-center m-3'> There Is No Record To Show </li>"  ;

                    }
                        ?>
                    </ul>
                </div>
            </div>



        </div>
    <!-- start latest comments -->
    <div class="row pt-3">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                    <i class="fa-solid fa-comments"></i> latest <?php echo $numcomments ?> Comments
                        <span class="toggle-info float-end">
                        <i class="fa-sharp fa-solid fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <ul class="list-group list-group-flush latest-users p-3 ">
                       <?php  
 					$stmt = $con->prepare("SELECT 
												comments.*, users.username AS Member  
											FROM 
												comments
											INNER JOIN 
												users 
											ON 
												users.id = comments.user_id
                                            ORDER BY 
                                               c_id DESC 
                                               limit 
                                               $numcomments");

					// Execute The Statement
					$stmt->execute();
					// Assign To Variable 
					$comments = $stmt->fetchAll();
                    if(!empty($comments)){
                     foreach($comments as $comment){  
                     echo "<div class='box-comment  '>";
                     echo '<span class="member-name">' . $comment['Member'] .'</span>';
                     echo '<p class="member-com">' . $comment['comment'] .'</p>';
                     echo "</div>";
                    }         
                    }else{
                        echo " <li class='list-group-item  text-center m-3'> There Is No Record To Show </li>"  ;

                    }
               
                       ?>
                    </ul>
                </div>   
            </div>





        </div>
    <!-- end latest comments -->
    </div>

<?php
    // end dashboard page 
    include $tpl . 'footer.php';
} else {

    header('location:index.php');
    exit();
}
