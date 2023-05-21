<?php
/*
==============================================
==categories
==you can add|edit|delete members here
==============================================
*/
ob_start();

session_start();
$pageTitle = 'Edit Profile';
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
        if($do == 'edit') { 
     
            //edit page 
            // using short if condion to chick if userid  is numeric and get the integer value of it 
            $userid=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']):0;
           
           // select all data from db using this  id
           $stmt=$con->prepare("SELECT  *  FROM   users WHERE  id= ? ");
           //    execute data 
           $stmt->execute(array($userid));
           // do fetch for data
           $doFetch=$stmt->fetch();
           // count rows
           $row= $stmt->rowCount();        
           // if there is such id show this form 
           if ( $row >  0){?>
             
            <!-- echo 'welcom this is edit page your id =' . $_GET['userid']; -->
            <h1 class="text-center"> Edit Members</h1>
            <div class="container ">
                <form action="editprofile.php?do=update" method="POST" class="form-horizontal " enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $userid?>" name="userid">
                    <!-- start Username input -->
                    <div class="mb-3  row p-0">
                        <label for="inputPassword" class="col-sm-1  col-form-label " autocomplete="off" >Username</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="username" value="<?php echo $doFetch['username']?> " required="required">
                        </div>
                    </div>
                     <!-- ens Username input -->
                    <!-- start Password input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Password</label>
                        <div class="col-sm-10 col-md-5 ">
                        <input type="hidden"  name="oldpassword" value="<?php echo $doFetch['password']?>" >
                         <input type="password" class="form-control form-control-lg " name="newpassword" autocomplete="new-password" >
                        </div>
                    </div>
                     <!-- ens Password input -->
                    <!-- start Password input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Email</label>
                        <div class="col-sm-10 col-md-5 ">
                            <input type="email" class="form-control form-control-lg " name="email" value="<?php echo $doFetch['email']?>" >
                        </div>
                    </div>
                     <!-- ens Password input -->
                    <!-- start Full name input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Full name</label>
                        <div class="col-sm-10 col-md-5 ">
                            <input type="text" class="form-control form-control-lg " name="full" value="<?php echo $doFetch['fullname']?>">
                        </div>
                    </div>
                     <!-- ens Full name input -->
                     <!-- start member image  input -->
                           <div class="mb-3  row">
                            <label for="inputPassword" class="col-sm-1  col-form-label">Member Image</label>
                            <div class="col-sm-10 col-md-5 ">
                            <input type="hidden" name="old_image" value="<?php echo $doFetch['avatar'] ?>">
                                <input type="file" class="form-control form-control-lg " name="avatar" placeholder=" Choose your image "  >
                            </div>
                        </div>
                    <!-- ens member image  input -->              
                    <!-- start submit input -->
                    <div class="mb-3  row">
                        <div class=" offset-sm-1 col-sm-10">
                            <input type="submit"  value="update" class="btn btn-danger btn-lg ">
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
          }elseif($do == 'update'){  //update page
            echo '<h1 class="text-center"> update  Members</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $old_image =$_POST['old_image'];
    
                //uploade variables
                $imageName=$_FILES['avatar']['name'];
                $imageSize=$_FILES['avatar']['size'];
                $imageType=$_FILES['avatar']['type'];
                $imageTmp= $_FILES['avatar']['tmp_name'];
                $imageAllowedExtentions=array("jpeg" , "jpg" , "gif" ,"png" );
                // to get image extention using explode
                $typ =explode('.', $imageName);
                $endOfimagename= end($typ);
                $imageExtention = strtolower($endOfimagename);
    
                // get variables from the form (from ths name of the input )
                $id= $_POST['userid'];
                $user= $_POST['username'];
                $email= $_POST['email'];
                $fullname= $_POST['full'];
                // short if (condition ? true : false)
                $pass=empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']);
                // validate the form
                $formerror=array();
                if (empty($user)){
                   $formerror[]= "sorry user name con't be <strong>empty</strong>";
               }
               if (strlen($user)< 4){
                   $formerror[]= "sorry user name con't be less than <strong>4 charactars </strong>";
               }
               if (strlen($user) > 20) {
                $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
            }
              
               if (empty($email)){
                   $formerror[]= "sorry  email con't be <strong>empty</strong>";
               }    
               if (empty($fullname)){
                   $formerror[]= " sorry full name con't be <strong>empty</strong>";
               }
    
               if( !empty($imageName) && ! in_array($imageExtention ,$imageAllowedExtentions)){
                $formerror[]= " sorry this Extention is not  <strong>Allowed </strong>";
               }
              if( $imageSize >4194304){
                $formerror[]= " sorry image can't be more than <strong>4 MB</strong>";
              }
               foreach($formerror as $error){
                   echo "<div class='alert alert-danger'>" .  $error  . "</div>";
               }
                // if there is no error proceed the update operation
                // update db with this info
                if (empty($formerror)){              
                     $stmt2 = $con->prepare('SELECT
                                              *
                                            FROM
                                              users 
                                            WHERE
                                              username=?
                                            AND
                                              id !=?');
                    $stmt2->execute(array($user , $id));
                    $count= $stmt2->rowCount();
                    if($count == 1){
                        $theMsg= '<div class ="alert alert-danger">sorry this user is exist</div>';
                        redirectFunction($theMsg , 'back' );
                    }else{
                        if(empty($imageName)){
                            $image=$old_image ;
                        }else
                        {
                            $image = rand(0, 10000000000) . '_' . $imageName;
                            move_uploaded_file($imageTmp , "admin\images\avatars\\ ". $image) ;     
                        } 
                         $stmt = $con->prepare("UPDATE users SET username = ? ,email = ? , fullname = ? , password = ?,avatar=? WHERE id = ?");
                    $stmt->execute(array($user , $email , $fullname, $pass,$image, $id  ));
                   //echo success message 
                   $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record updated</div>';
                    redirectFunction($theMsg , 'back' , 4 ); 
                    }
    
                }
           
            }else{
                $theMsg= '<div class ="alert alert-danger">sorry you cant prows this page directly</div>';
    
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
ob_end_flush();
