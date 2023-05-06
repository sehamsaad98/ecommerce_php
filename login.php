<?php 
	ob_start();
session_start();
// print_r($_SESSION);
$pageTitle='login';
if(isset($_SESSION['user'])){
    header('location:index.php');
}
  include 'init.php';
  // check if user come from http post request
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['login'])){

    
    $user= $_POST['username'];
    $pass= $_POST['password'];
    $hashedpass=sha1($pass);
    // echo $hashedpass;

    // check if user exist id database (statement)
    $stmt=$con->prepare("SELECT 
                               id,username , password 
                        FROM 
                            users 
                        WHERE 
                               username= ? 
                        AND 
                               password= ? ");
    $stmt->execute(array($user , $hashedpass));
    $get = $stmt->fetch();

    // count rows
    $row= $stmt->rowCount();

    // if $row > 0 this mean the database contain recored about this username
    if($row > 0 ){
        $_SESSION['uid'] = $get['id'];//Register User Id In Session 
        $_SESSION['user'] = $user; // Register Session Name
        header('Location: index.php'); // Redirect To Dashboard Page

        exit();
    }
  }else{
    $user=$_POST['username'];
    $password =$_POST['password'];
    $password2=$_POST['password2'];
    $email = $_POST['email'];
    $formErrors=array();
    if(isset($user)){
        $filterdUser = filter_var($user,FILTER_SANITIZE_STRING);
        if(strlen($filterdUser) < 4){
            $formErrors[]= "user name can't be less than 4 character";
        }
    }
    if(isset($password) && isset($password2)){
        if (empty($password)){
            $formErrors[]= "sory Email can't be empty";
        }
          $pass1= sha1($password) ;
          $pass2=sha1($password2)  ;
          if ($pass1 !== $pass2 ){
            $formErrors[]= "paswords is not identical " ;
          }
  }
  if(isset($email)){
    $filterdEmail = filter_var($email,FILTER_SANITIZE_EMAIL);
    if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true){
        $formErrors[]= "this Email is not valid " ;

    }
 }
 if (empty($formErrors)){
    //Check If User Exist in database 

    $check=checkItem("username", "users", $_POST['username']);
    if($check == 1 ){
        $formErrors[]= "sorry this user is alredy exist " ;

    }else{
   //insert info in db
   $stmt=$con->prepare("INSERT INTO 
                              users (username, password , email,regStatus, date) 
                        VALUES (:zuser , :zpass  , :zemail ,0, now())");
    $stmt->execute(array(
        'zuser' => $user,
        'zpass'=> sha1( $password),
        'zemail'=> $email
    ));
   //echo success message 
   $successMsg = 'Congrats Your are now Registerd user';
}
}

}
}

  ?>


<!-- <div class="container picture ">
    <h1 class="text-center"><span class="login"> Login</span> <span class="SignUp"> | signup</span></h1>
    <form class="login">
        <input  class="form-control" type="text" name="username" autocomplete="off">
        <input  class="form-control" type="password" name="password" autocomplete="new-password">
        <input  class="btn btn-danger " type="submit" value="login">


    </form>
</div> -->

<section class="intro">
    <div class=" container-fluid">
        <div class="row text-center">
            <div class="col-md-5 text">
                   <h1 class="fc">
                    online shop
                  </h1>
                <!-- buttons start -->
                <span type="button" class="button-login" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fas fa-lock"></i>
                Login
                </span>   
                <span type="button" class="button-login" data-bs-toggle="modal" data-bs-target="#register">
                <i class="fa-regular fa-user"></i>
                Register
                </span>  
                <!-- buttons End -->

                <!-- Login Form Start -->
               <div class="modal   fade text-start" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Login Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <div class="modal-body">
                       <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                       <div class="input-container">
                        <label >
                            <i class="fa fa-user"></i>
                            Username
                        </label>
                        <div>
                            <input type="text" placeholder="Username" name="username"  required>
                            <span class="asterisk">*</span>
                        </div></div>
                        <div class="input-container">
                         <label >
                            <i class="fa fa-key"></i>
                            Password
                        </label>
                        <div>
                            <input type="password" placeholder="Password" name="password" autocomplete="new-password" required>
                            <span class="asterisk">*</span>
                        </div></div>
                        <div>
                            <button class="btn btn-dark btn-login" type="submit" name="login">
                                <i class="fa fa-lock"></i>
                                    Login
                            </button>
                        </div>
                        <div class="foot">
                            <a href="#" class="new-acc">
                                I didn't have an account !!!
                            </a>
                        </div>
                       </form>
                    </div>
                    </div>
                    </div><br>           
                 </div>
           
            <!-- Login Form End -->
            <!-- register form start -->
            <div class="modal   fade text-start" id="register" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">register Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <div class="modal-body">
                       <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <div class="input-container">
                        <label >
                            <i class="fa fa-user"></i>
                            Username
                        </label>
                        <div>
                            <input pattern=".{4,}" title="username most be ar least 4 chars " type="text" placeholder="Username" name="username" autocomplete="off" required >
                            <span class="asterisk">*</span>
                        </div></div>
                        <div class="input-container">
                         <label >
                            <i class="fa fa-key"></i>
                            Password
                        </label>
                        <div>
                            <input type="password" minlength="4" placeholder="Type a Complex Password" name="password" autocomplete="new-password" required >
                            <span class="asterisk">*</span>
                        </div></div>
                        <div class="input-container">

                        <label >
                            <i class="fa fa-key"></i>
                            Password
                        </label>
                        <div>
                            <input type="password" minlength="4" placeholder="Type Your Password " name="password2" autocomplete="new-password" required>
                            <span class="asterisk">*</span>
                        </div></div>
                        <div class="input-container">

                        <label >
                        <i class="fa-solid fa-envelope"></i>
                            Email
                        </label>
                        <div>
                            <input type="email" placeholder="type a vlid  Email" name="email" required >
                            <span class="asterisk">*</span>
                        </div></div>
                        <div>
                            <button class="btn btn-dark btn-login" type="submit" name="signup">
                                <i class="fa fa-lock"></i>
                                    Login
                            </button>
                        </div>
                        <!-- <div class="foot">
                            <a href="#" class="new-acc">
                                I didn't have an account !!!
                            </a>
                        </div> -->
                       </form>
                    </div>
                    </div>
                    </div><br>           
                 </div>
            </div> 
            <!-- register form End -->
 
            <img src="sss081-removebg-preview.png" class="col-md-6">
        </div>

    </div>

        <div class="the-error text-center ">
         <?php if(!empty($formErrors)){
           foreach($formErrors as $error){
            echo "<div class='alert alert-danger fw-bold'>" . $error . "</div>";
           }
         }
            if(isset($successMsg)){
                echo '<div class="alert alert-info">' . $successMsg . '</div>';
            } ?>
        </div>
</section>


<?php
include $tpl.'footer.php';
ob_end_flush();