<?php
ob_start();
session_start();
$pageTitle = 'Profile';
include "init.php";
// if (isset($_SESSION['user'])) {
//     $getUser = $con->prepare('SELECT * FROM users WHERE username =?');
//     $getUser->execute(array($sessionUser));
//     $info = $getUser->fetch();
//     $userId =$info['id'];
	if (isset($_SESSION['user'])) {
		$getUser = $con->prepare("SELECT * FROM users WHERE username = ?");
		$getUser->execute(array($sessionUser));
        $info = $getUser->fetch();
        
        $userId = $info['id'];

?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="card">
                <div class="card-header  ">
                    <h5> My Information</h5>
                </div>
                <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fa-solid fa-unlock"></i>
                        <span>Name </span> : <?php echo $info['username']; ?>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-regular fa-envelope"></i>
                        <span>email </span>: <?php echo $info['email']; ?>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-regular fa-user"></i>
                        <span>full name </span>: <?php echo $info['fullname']; ?>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-regular fa-calendar-days"></i>
                        <span>reg </span>: <?php echo $info['date']; ?>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-tags"></i>
                        <span>Fav Category </span>: <?php echo $info['date']; ?>
                    </li>
                </ul>
                <a  href="editprofile.php?do=edit&userid=<?php echo $_SESSION['ID']?>" class="btn btn-default">Edit Information</a>

                 <div class="btn btn-default">Edit Information</div>           
            </div>

            </div>
        </div>
    </div>

    <div class="adv block">
        <div class="container">
            <div class=" card">
                <div class="my-adv card-header p-2">
                    My Advertisement
                </div>
                <div class="card-body">
                    <div class="row row-cols-md-4 row-cols-sm-2 ">

                        <?php
                        $myItems = getAll('*' , 'items' , "WHERE member_id = $userId" , '','id') ; 
                        if (!empty($myItems)) {
                            foreach ($myItems as $item) {
                                echo '<div class="col  ">';
                                echo ' <div class="card item-box ">';
                                if ($item['approve'] == 0) {
                                    echo '<span class=" approve-status" >Not Approved </span>';
                                }
                                echo '<span class="price-tag text-center">$' . $item['price'] . '</span>';
                                echo '<span class="favorit "><i class="fa-regular fa-heart"></i> </span>';
                                echo "<img  src='admin/images/items/ " . $item['image'] . "' class='card-img-top' style='height:350px;'> ";
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title"><a href="items.php?item_id=' . $item['id'] . '">' . $item['name'] . '</a></h5>';
                                echo '<p class="card-text p-0 m-0">' . $item['description'] .  '<span class="".</p>';
                                echo '<p class="date  card-text p-0 m-0"> ' . $item['add_date'] .  '<span class="".</p>';
                                echo '</div>';
                                echo '</div>';
                                echo ' </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger  fw-bold col-12 "> There Is No Items To Show <a href="newad.php " >Create New Ad </a>  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="my-comments block">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        Latest Comments
                    </div>
                    <div class="card-body">
                        <?php
                        $myComments= getAll('comment' ,'comments' , "WHERE user_id = $userId" , '' , 'c_id' );
                        if (!empty($myComments)) {
                            foreach ($myComments as $comment) {
                                echo "<p>" . $comment['comment'] . "</p>";
                            }
                        } else {
                            echo "there is no Comments to show";
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>


    <?php } else {
    header('location:login.php');
}
include $tpl . 'footer.php';
ob_end_flush();

    ?>