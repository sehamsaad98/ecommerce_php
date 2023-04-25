<?php
session_start();
// print_r($_SESSION);
$nonavbar='';
$pageTitle='login';
if(isset($_SESSION['usersession'])){
   header('location:dashboard.php');

}
include "init.php";
// include "connect.php";


// check if user come from http post request
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username= $_POST['user'];
    $password= $_POST['password'];
    $hashedpass=sha1($password);
    // echo $hashedpass;

    // check if user exist id database (statement)
    $stmt=$con->prepare("SELECT 
                               id , username , password 
                        FROM 
                            users 
                        WHERE 
                               username= ? 
                        AND 
                               password= ? 
                        AND 
                               groupId=1
                        LIMIT 1");
    $stmt->execute(array($username , $hashedpass));
    // do fetch for data
    $doFetch=$stmt->fetch();
    // count rows
    $row= $stmt->rowCount();

    // if $row > 0 this mean the database contain recored about this username
    if($row > 0 ){
        $_SESSION['usersession']= $username;//register session name
        $_SESSION['ID']= $doFetch['id'];//register session id
        exit;
    }

}
?>
<form class="login d-grid gap-2" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center"> admin login</h4>
    <input class="form-control input-lg" type="text" name="user" placeholder="user name" autocapitalize="off">
    <input class="form-control input-lg" type="password" name="password" placeholder="password" autocapitalize="new-password">
    <input class="btn btn-danger btn-block btn-lg" type="submit" value="login">


</form>


<!-- <div class="container login">
    <div class="row">
        <div class="col-md-4" id="side1">
            <h2>Hello friend!</h2>
            <p>creat new Acount</p>
            <div class="btn"><a href="singup.html">sing up</a></div>

           </div>
    </div>
    <div class="col-md-4" id="side2">
        <h3>login Account</h3>
        <div class="inp">
            <input type="text" placeholder="user name" required>
            <input type="password" placeholder="password" required>

        </div>
        <p>forgot your password</p>
        <div class="icons">
        <i class="fa-brands fa-square-facebook"></i>
        <i class="fa-brands fa-twitter"></i>
        <i class="fa-brands fa-square-instagram"></i>
        </div>
        <input class="btn btn-primary" id="login " value="login" type="submit"></input>
    </div>
</div> -->


<?php
include $tpl.'footer.php';?>