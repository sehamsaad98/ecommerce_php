<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo $css ;?>bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css ;?>front.css"  >
    <link rel="stylesheet" type="text/css" href="layout/css/front.css"  >
    <!-- fonts start  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,500;0,700;0,800;0,900;1,200;1,500;1,700&display=swap" rel="stylesheet">
    <!-- aladin fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,500;0,700;0,800;0,900;1,200;1,500;1,700&family=Teko:wght@300&display=swap" rel="stylesheet">

 

    <link rel="stylesheet" href="<?php echo $css ;?>style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
    /* .navbar-light .navbar-nav .nav-link:focus, .navbar-light .navbar-nav .nav-link:hover {
  color: rgba(191, 45, 45, 0.9);
} */
.dropdown.dropdown-menu{
   background-color: red;
 }
 .dropdown-menu{
   background-color: white;
   color:red;
 }
</style>
    
</head>
<body>

  <!-- <div class="upper-par">
    <div class="container ">
    <a href="login.php">
				<span class="pull-right">Login/Signup</span>
			</a>
    </div>
  </div> -->
<!-- new nav -->

<header>
  <div class="navbar ">
    <div class="logo">
      <a href="index.php"><i class="fa fa-home"></i>Homepage</a>
    </div>
    <ul class="links">
      <?php 
            $getCategories=getCat();
            foreach($getCategories as $getcat){
              echo '<li>
                <a  href="categories.php?pageid='.$getcat['id'].'&pagename='.str_replace(' ','-',$getcat['name']) .'">' 
                . $getcat['name'] .
                '</a>
              </li>';
            }
            ?>

    </ul>
    <?php 
    if(isset($_SESSION['user'])){
            
           checkUserStatus($_SESSION['user']);
           echo '<div class="contain">';
           echo '<a href="newad.php" class=" action_btn btn-success new-add">new ad</a>';
           echo '<a href="profile.php" class="action_btn ms-2 me-1">My Profile </a> ';
           echo '<a href="logout.php" class="action_btn ">logout </a> ';
           echo '</div>';
           if( checkUserStatus($sessionUser) == 1){
            //user not active 
           
           }
  }else{  ?>
  <a href="login.php" class="action_btn"> Login | Signup</a>
    <?php }?>
    <div class="toggle_btn"><i class="fa-solid fa-bars"></i></div>
  </div>
  <div class="dropdown_menu ">
    <?php 
            $getCategories=getCat();
            foreach($getCategories as $getcat){
              echo '<li >
                <a  href="categories.php?pageid='.$getcat['id'].'&pagename='.str_replace(' ','-',$getcat['name']) .'">' 
                . $getcat['name'] .
                '</a>
              </li>';
            }
            ?>

<?php 
    if(isset($_SESSION['user'])){
      echo '<div class="contain">';
      
      echo '<a href="profile.php" class="action_btn  mb-1">My Profile </a> ';
      echo '<a href="newad.php" class=" action_btn mb-1 btn-success new-add">new ad</a>';
      echo '<a href="logout.php" class="action_btn ">logout </a> ';
      echo '</div>';

    }else{  ?>
  <a href="login.php" class="action_btn"> Login | Signup</a>
    <?php }?>
  </div>
</header>



<script>
  const toggleBtn = document.querySelector('.toggle_btn')
  const toggleBtnIcon = document.querySelector('.toggle_btn i ')
  const dropdownMenu = document.querySelector('.dropdown_menu')
  toggleBtn.onclick=function(){
    dropdownMenu.classList.toggle('open')
    const isOpen=dropdownMenu.classList.contains('open')
    toggleBtnIcon.classList=isOpen
    ? 'fa-solid fa-xmark'
    : 'fa-solid fa-bars'
  }
</script>



  <!-- <nav class="navbar navbar-expand-lg px-0 sticky-top">
    <div class="container-fluid">
      <div class="brand d-flex justify-content-start">
        <a class="navbar-brand  " href="index.php">Homepage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        </div>
        <div class="collapse navbar-collapse " id="app-nav">
            <ul class=" navbar-nav   ">
            <?php 
            $getCategories=getCat();
            foreach($getCategories as $getcat){
              echo '<li class="nav-item">
                <a class="nav-link " aria-current="page" href="categories.php?pageid='.$getcat['id'].'&pagename='.str_replace(' ','-',$getcat['name']) .'">' 
                . $getcat['name'] .
                '</a>
              </li>';
            }
            ?>


            </ul>

        </div>

        <div class="float-end ms-5 mx-0">
        <a href="login.php " >
        <span class="float-end">Login/SignUp </span>
      </a>
    </div>

    </div>
</nav> -->

