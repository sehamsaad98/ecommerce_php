<?php
/*
==============================================
==manage members
==you can add|edit|delete members here
==============================================
*/

session_start();
$pageTitle = 'Comments';
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
    if ($do == 'manage') {//manage pag Comment
        // Select All Comments 
    $stmt=$con->prepare("SELECT 
                            comments.* ,items.name AS Item_name ,users.username As Username 
                         FROM 
                            comments 
                         INNER JOIN 
                            items 
                         ON 
                            items.id = comments.item_id 
                         INNER JOIN 
                            users 
                         ON 
                            users.id = items.member_id
                        ORDER BY 
                            c_id DESC  ");
    // excute the statement
    $stmt->execute();
    // assign to variabels
    $comments=$stmt->fetchAll();
    if(!empty($comments)){
    ?>
    <h1 class="text-center"> Manage Comments</h1>
            <div class="container ">
                <div class="table-responsive">
                    <table class="table table-bordered main-table text-center ">
                        <tr class="">
                            <td>#ID</td>
                            <td>Comment</td>
                            <td>Item Name</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>

                        </tr>
                        <?php  foreach($comments as $comment){
                            echo "<tr>";
                            echo"<td>" . $comment['c_id'] . "</td>";
                            echo"<td>" . $comment['comment'] . "</td>";
                            echo"<td>" . $comment['Item_name'] . "</td>";
                            echo"<td>" . $comment['Username'] . "</td>";
                            echo"<td>" .$comment['added_date']. "</td>";
                            echo"<td> 
                            <a href='comments.php?do=edit&comid=". $comment['c_id']."' class='btn btn-success'><i class='fa fa-edit '></i>Edit</a>
                            <a href='comments.php?do=Delete&comid=". $comment['c_id']."' class='btn btn-danger confirm'><i class='fa fa-close '></i>Delete</a>";
                            if($comment['status']== 0){
                               echo "<a href='comments.php?do=Approve&comid=". $comment['c_id']."' class='btn btn-info activate '><i class='fa-solid fa-check'></i>
                               Approve</a>";
                             }    
                            echo"</td>";
                            echo "</tr>";
                        } ?>
                    </table>
                </div>
            </div>
            <?php }else{
                    echo "<div class='container'>";
                    echo "<div class='alert alert-info fw-bold text-center'>There Is No  Record To Show  </div>";
                    echo "</div>";
                 }  ?>  
    <!-- end manage page design -->
   <?php 
     }elseif($do == 'edit') { 
        //edit page 
        // using short if condion to chick if commentid  is numeric and get the integer value of it 
        $comid=isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']):0;
       
       // select all data from db using this  id
       $stmt=$con->prepare("SELECT  *  FROM   comments WHERE  c_id= ? ");
       //    execute data 
       $stmt->execute(array($comid));
       // do fetch for data
       $doFetch=$stmt->fetch();
       // count rows
       $row= $stmt->rowCount();        
       // if there is such id show this form 
       if ( $row >  0){?>
         
        <!-- echo 'welcom this is edit page your id =' . $_GET['userid']; -->
        <h1 class="text-center"> Edit Comments</h1>
        <div class="container ">
            <form action="comments.php?do=update" method="POST" class="form-horizontal ">
                <input type="hidden" value="<?php echo $comid?>" name="comid">
                <!-- start Comment input -->
                <div class="mb-3  row p-0">
                    <label for="inputPassword" class="col-sm-1  col-form-label " autocomplete="off" >comment</label>
                    <div class="col-sm-10 col-md-5  ">
                        <textarea name="comment" class="form-control"> <?php echo $doFetch['comment']?></textarea>
                    </div>
                </div>
                 <!-- ens Comment input -->
                <!-- start submit input -->
                <div class="mb-3  row">
                    <div class=" offset-sm-1 col-sm-10">
                        <input type="submit"  value="Save" class="btn btn-danger btn-lg ">
                    </div>
                </div>
                 <!-- ens submit input -->
            </form>
        </div>
<?php
     //    if there is such id show error
    }else{
        echo '<div class="container">';
        $theMsg = '<div class = "alert alert-danger">there is no such id</div>';
        redirectFunction($theMsg  );
        echo '</div>';
     }
      }elseif($do == 'update'){ //update page
        echo '<h1 class="text-center"> update  Comments</h1>';
        echo '<div class="container">';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // get variables from the form (from ths name of the input )
            $id= $_POST['comid'];
            $comment= $_POST['comment'];

            // short if (condition ? true : false)            
                $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id = ?");
                $stmt->execute(array($comment , $id ));
               //echo success message 
               $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record updated</div>';
                redirectFunction($theMsg , 'back' , 4 );
            
       
        }else{
            $theMsg= '<div class ="alert alert-danger">sorry you cant prows this page directly</div>';

            redirectFunction($theMsg );
        }
        echo '</div>';
     
}
elseif($do=='Delete'){
    // delete comment page 
     // using short if condion to chick if comid  is numeric and get the integer value of it 
     echo '<h1 class="text-center"> Delete  Comment</h1>';
     echo '<div class="container">';
     $comid=isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']):0;
       
     // select all data from db using this  id
    //  $stmt=$con->prepare("SELECT  *  FROM   users WHERE  id= ? ");
     $check=checkItem('c_id' , 'comments' , $comid);      
     // if there is such id show this form 
     if ($check>0){
         $stmt=$con->prepare("DELETE FROM comments WHERE c_id =:zcomment");
         
         $stmt->bindParam(":zcomment" , $comid);
         $stmt->execute();
         $theMsg= "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record Deleted</div>';
         redirectFunction($theMsg , 'back' );

     }else{
        $theMsg= "<div class = 'alert alert-danger'>This Id Is Not Exist</div>";
        redirectFunction($theMsg );
     }
     echo '</div>';
}elseif($do=='Approve'){
      // Approve comment page 
     // using short if condion to chick if comid  is numeric and get the integer value of it 
     echo '<h1 class="text-center"> Approve Items</h1>';
     echo '<div class="container">';
     $comid=isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']):0;
     // select all data from db using this  item_id
     $check=checkItem('c_id' , 'comments' , $comid);      
     // if there is such id show this form 
     if ($check>0){
         $stmt=$con->prepare("UPDATE comments SET status = 1 WHERE c_id = ? ");
         $stmt->execute(array($comid));
         $theMsg= "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'Comment Approve</div>';
         redirectFunction($theMsg , 'back' );

     }else{
        $theMsg= "<div class = 'alert alert-danger'>This Id Is Not Exist</div>";
        redirectFunction($theMsg );
     }
     echo '</div>';   
}
               // end manage page
    include $tpl . 'footer.php';
} else {
    header('location:index.php');
    exit();
}
