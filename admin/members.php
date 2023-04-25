<?php
/*
==============================================
==manage members
==you can add|edit|delete members here
==============================================
*/

session_start();
$pageTitle = 'Members';
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
    if ($do == 'manage') {//manage pag member
       $query='';
       if(isset($_GET['page']) && $_GET['page']=='pending'){
        $query='AND regStatus = 0';
       }
        // Select All Users Except Admin
    $stmt=$con->prepare("SELECT * FROM users WHERE groupid != 1 $query");
    // excute the statement
    $stmt->execute();
    // assign to variabels
    $rows=$stmt->fetchAll();

    
    ?>
    <h1 class="text-center"> Manage Members</h1>
            <div class="container ">
                <div class="table-responsive">
                    <table class="table table-bordered main-table text-center ">
                        <tr class="">
                            <td>#ID</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registered Date</td>
                            <td>Control</td>

                        </tr>
                        <?php  foreach($rows as $row){
                            echo "<tr>";
                            echo"<td>" . $row['id'] . "</td>";
                            echo"<td>" . $row['username'] . "</td>";
                            echo"<td>" . $row['email'] . "</td>";
                            echo"<td>" . $row['fullname'] . "</td>";
                            echo"<td>" .$row['date']. "</td>";
                            echo"<td> 
                            <a href='members.php?do=edit&userid=". $row['id']."' class='btn btn-success'><i class='fa fa-edit '></i>Edit</a>
                            <a href='members.php?do=Delete&userid=". $row['id']."' class='btn btn-danger confirm'><i class='fa fa-close '></i>Delete</a>";
                              if($row['regStatus']== 0){
                                echo "<a href='members.php?do=Activate&userid=". $row['id']."' class='btn btn-info activate '><i class='fa-solid fa-play'></i>
                                Activate</a>";
                              }
                            echo"</td>";
                            echo "</tr>";
                        } ?>

                    </table>
                </div>

  <a href='members.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i> add  member </a>
            </div>
 

    <!-- end manage page design -->
   <?php }elseif($do == 'add'){
        ?>
            <!--  add members page  -->
            <h1 class="text-center"> add new Member</h1>
            <div class="container contform ">
                <form action="members.php?do=insert" method="POST" class="form-horizontal ">
                    <!-- start Username input -->
                    <div class="mb-3  row p-0">
                        <label for="inputPassword" class="col-sm-1  col-form-label " autocomplete="off" >Username</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="username"  required="required" placeholder=" Username To Login Into Shop" >
                        </div>
                    </div>
                     <!-- ens Username input -->
                    <!-- start Password input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Password</label>
                        <div class="col-sm-10 col-md-5 password" >
                         <input type="password" class="form-control form-control-lg pass" name="password" autocomplete="new-password"  required="required" placeholder=" Password Must Be Hard & Complex" >
                         <span class="iconspan"><i class="show-pass fa fa-eye fa-lg   " id="font"></i></span>

                        </div>
                    </div>
                     <!-- ens Password input -->
                    <!-- start Password input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Email</label>
                        <div class="col-sm-10 col-md-5 ">
                            <input type="email" class="form-control form-control-lg " name="email" placeholder="Email Must Be Valid"  required="required">
                        </div>
                    </div>
                     <!-- ens Password input -->
                    <!-- start Full name input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Full name</label>
                        <div class="col-sm-10 col-md-5 ">
                            <input type="text" class="form-control form-control-lg " name="full" placeholder=" Full Name Appear In Your Profile"  required="required">
                        </div>
                    </div>
                     <!-- ens Full name input -->
                    <!-- start submit input -->
                    <div class="mb-3  row">
                        <div class=" offset-sm-1 col-sm-10">
                            <input type="submit"  value="Add Member" class="btn btn-danger btn-lg " placeholder=""  required="required">
                        </div>
                    </div>
                     <!-- ens submit input -->
                </form>
            </div>
    <?php
    }elseif($do == 'insert'){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            echo '<h1 class="text-center"> update  Members</h1>';
            echo '<div class="container">';

            // get variables from the form (from ths name of the input )
            $user= $_POST['username'];
            $pass=$_POST['password'];           
            $email= $_POST['email'];
            $fullname= $_POST['full'];
            $hashpass=sha1($_POST['password']);

            // validate the form
            $formerror=array();
             if (empty($user)){
                $formerror[]= "sorry user name con't be <strong>empty</strong>";
            }
             elseif (strlen($user)< 4){
                $formerror[]= "sorry user name con't be less than <strong>4 charactars </strong>";
            }
            elseif (strlen($user)>10){
                $formerror[]= " sorry user name con't be more than <strong>10 charactars</strong> ";
            }
           
            if (empty($email)){
                $formerror[]= "sorry  email con't be <strong>empty</strong>";
            } 
            if (empty($pass)){
                $formerror[]= "sorry  password con't be <strong>empty</strong>";
            }      
            if (empty($fullname)){
                $formerror[]= " sorry full name con't be <strong>empty</strong>";
            }
            foreach($formerror as $error){
                echo "<div class='alert alert-danger'>" .  $error  . "</div>";
            }
            // if there is no error proceed the insert operation
            // insert into db 
            if (empty($formerror)){
                //Check If User Exist in database 
       
                $check=checkItem("username", "users", $user);
                if($check == 1 ){
                    $theMsg= "sorry this user is exist";
                    redirectFunction($theMsg , 'back' );
                    
                }else{
               //insert info in db
               $stmt=$con->prepare("INSERT INTO 
                                          users (username, password , fullname , email,regStatus, date) 
                                    VALUES (:zuser , :zpass , :zfull , :zemail ,1, now())");
                $stmt->execute(array(
                    'zuser' => $user,
                    'zpass'=> $hashpass,
                    'zfull'=>$fullname,
                    'zemail'=> $email
                ));
               //echo success message 
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record insert</div>';
                redirectFunction($theMsg , 'back' );
       }
            }
       
        }else{
            echo "<div class='container'>";
            $theMsg ='<div class ="alert alert-danger ">sorry you cant prows this page directly</div>';
            redirectFunction($theMsg , 'back' );
            echo "</div>";
        }
        echo '</div>';   
     }elseif($do == 'edit') { 
     
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
            <form action="members.php?do=update" method="POST" class="form-horizontal ">
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
      }elseif($do == 'update'){ //update page
        echo '<h1 class="text-center"> update  Members</h1>';
        echo '<div class="container">';
        if($_SERVER['REQUEST_METHOD']=='POST'){
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
           foreach($formerror as $error){
               echo "<div class='alert alert-danger'>" .  $error  . "</div>";
           }
            // if there is no error proceed the update operation
            // update db with this info
            if (empty($formerror)){
                $stmt = $con->prepare("UPDATE users SET username = ? ,email = ? , fullname = ? , password = ? WHERE id = ?");
                $stmt->execute(array($user , $email , $fullname, $pass, $id  ));
               //echo success message 
               $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record updated</div>';
                redirectFunction($theMsg , 'back' , 4 );
            }
       
        }else{
            $theMsg= '<div class ="alert alert-danger">sorry you cant prows this page directly</div>';

            redirectFunction($theMsg );
        }
        echo '</div>';
     
}
elseif($do=='Delete'){
    // delete member page 
     // using short if condion to chick if userid  is numeric and get the integer value of it 
     echo '<h1 class="text-center"> Delete  Members</h1>';
     echo '<div class="container">';
     $userid=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']):0;
       
     // select all data from db using this  id
    //  $stmt=$con->prepare("SELECT  *  FROM   users WHERE  id= ? ");
     $check=checkItem('id' , 'users' , $userid);      
     // if there is such id show this form 
     if ($check>0){
         $stmt=$con->prepare("DELETE FROM users WHERE id =:zuser");
         
         $stmt->bindParam(":zuser" , $userid);
         $stmt->execute();
         $theMsg= "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record Deleted</div>';
         redirectFunction($theMsg , 'back' );

     }else{
        $theMsg= "<div class = 'alert alert-danger'>This Id Is Not Exist</div>";
        redirectFunction($theMsg );
     }
     echo '</div>';
}elseif($do=='Activate'){
   // Activate member page 
     // using short if condion to chick if userid  is numeric and get the integer value of it 
     echo '<h1 class="text-center"> Activate  Members</h1>';
     echo '<div class="container">';
     $userid=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']):0;
       
     // select all data from db using this  id
    //  $stmt=$con->prepare("SELECT  *  FROM   users WHERE  id= ? ");
     $check=checkItem('id' , 'users' , $userid);      
     // if there is such id show this form 
     if ($check>0){
         $stmt=$con->prepare("UPDATE users SET regStatus = 1 WHERE id = ? ");
         $stmt->execute(array($userid));
         $theMsg= "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record Activated</div>';
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
