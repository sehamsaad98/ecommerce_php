<?php
session_start();
// print_r($_SESSION);
if (isset($_SESSION['usersession'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';
    // start dashboard page \
    $theLatest = 5; // The Number Of The Latest Users 
    $latestUser = getLatest("*", "users", "id", $theLatest); //Latest Users Array 

?>
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">Total Members
                    <span><a href="members.php"><?php echo countItmes('id', 'users') ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">Pending Members
                    <span><a href="members.php?do=manage&page=pending">
                            <?php echo checkItem('regStatus', 'users', 0) ?>
                        </a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">Total Items
                    <span>200</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">Total Comments
                    <span>200</span>
                </div>
            </div>
        </div>
    </div>


    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-users"></i> Latest <?php echo $theLatest ?> Regested Users
                    </div>
                    <ul class="list-group list-group-flush latest-users ">
                        <?php
                        foreach ($latestUser as $user) {
                            echo " <li class='list-group-item'>" . $user['username'] ;
                            echo " <a href='members.php?do=edit&userid=". $user['id'] . "'>";
                             echo "<span class='btn btn-success float-end'>";
                             echo"<i class='fa fa-edit'></i>Edit ";
                             if($user['regStatus']== 0){
                                echo "<a href='members.php?do=Activate&userid=". $user['id']."' class='btn btn-info activate  float-end '><i class='fa-solid fa-play'></i>Activate</a>";
                              }
                             echo "</span> </a></li> ";
                        }
                        ?>
                    </ul>
                </div>   
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <?php $theLatest = 3; ?>
                    <div class="card-header">
                        <i class="fa fa-home"></i> Latest Items Added
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        foreach ($latestUser as $user) {
                            echo " <li class='list-group-item'>" . $user['username'] . "</li> ";
                        }
                        ?>
                    </ul>
                </div>
            </div>



        </div>
    </div>

<?php
    // end dashboard page 
    include $tpl . 'footer.php';
} else {

    header('location:index.php');
    exit();
}
