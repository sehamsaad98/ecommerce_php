<?php
ob_start();
session_start();
$pageTitle = 'Create New Item';
include "init.php";
if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $formError = array();
        $name      = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS) ;
        $desc      = filter_var( $_POST['description']);
        $country   = filter_var($_POST['country'], FILTER_SANITIZE_EMAIL);
        $price     = filter_var( $_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $status    = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $cat       = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $member    = $_SESSION['uid'];
        if(strlen($name)< 4 ){
            $formError[]='Item name can\'t be less than 4 Characters'; 
        }
        if(strlen($desc)< 10 ){
            $formError[]='Item description  can\'t be less than 10 Characters'; 
        }
        if(strlen($country)< 3 ){
            $formError[]='Item country must be at least 3 Characters'; 
        }
        if(empty($price) ){
            $formError[]='Item Price must be not empty '; 
        }
        if(empty($status) ){
            $formError[]='Item status must be not empty '; 
        }
        if(empty($cat) ){
            $formError[]='Item category must be not empty '; 
        }

        if (empty($formError)) {

            //insert info in db
            $stmt = $con->prepare("INSERT INTO 
                                      items (name, description , price , country_made, status , add_date ,cat_id, member_id) 
                                VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus, now() , :zcat, :zmember)");
            $stmt->execute(array(
                'zname'     => $name,
                'zdesc'     => $desc,
                'zprice'     => $price,
                'zcountry'     => $country,
                'zstatus'     => $status,
                'zcat'        => $cat,
                'zmember'    => $member
            ));
            //echo success message 
            if($stmt){
                echo 'item added ';
              }
        }
    }

?>
    <h1 class="text-center"><?php echo $pageTitle; ?></h1>
    <div class=" block">
        <div class="container">
            <div class="card">
                <div class="new-ad card-header  ">
                    <h5><?php echo $pageTitle; ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="form-horizontal ">
                                <!-- start Name input -->
                                <div class="mb-3  row p-0">
                                    <label class="col-sm-3  col-form-label ">Name</label>
                                    <div class="col-sm-10 col-md-9  ">
                                        <input type="text" class="form-control form-control-lg live-name " name="name" placeholder="Name Of Item">

                                    </div>
                                </div>
                                <!-- end Name input -->
                                <!-- start Description input -->
                                <div class="mb-3  row p-0">
                    
                                    <label class="col-sm-3  col-form-label ">Description</label>
                                    <div class="ol-sm-10 col-md-9  ">
                                        <input type="text" class="form-control form-control-lg live-desc" name="description" placeholder="Description Of Item">
                                    </div>
                                </div>
                                <!-- end Description input -->
                                <!-- start Price input -->
                                <div class="mb-3  row p-0">
                                    <label class="col-sm-3 col-form-label ">Price</label>
                                    <div class="col-sm-10 col-md-9  ">
                                        <input type="text" class="form-control form-control-lg live-price " name="price" placeholder="Name Of Item">
                                    </div>
                                </div>
                                <!-- end Price input -->
                                <!-- start Country input -->
                                <div class="mb-3  row p-0">
                                    <label class="col-sm-3  col-form-label ">Country</label>
                                    <div class="col-sm-10 col-md-9  ">
                                        <input type="text" class="form-control form-control-lg " name="country" placeholder="Country Of made">
                                    </div>
                                </div>
                                <!-- end Country input -->
                                <div class="mb-3  row p-0">
                                    <label class="col-sm-3 col-form-label ">Status</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select name="status" class="form-control form-control-lg ">
                                            <option value="0">...</option>
                                            <option value="1">New</option>
                                            <option value="2">Like New</option>
                                            <option value="3">Used</option>
                                            <option value="4">Very Old</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Status Field -->

                                <!--  start Categories input -->
                                <div class="mb-3  row p-0 ">
                                    <label class="col-sm-3  col-form-label ">Categories</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select name="category" class="form-control form-control-lg ">
                                            <option value="0">...</option>
                                            <?php $stmt2 = $con->prepare('SELECT * FROM categories');
                                            $stmt2->execute();
                                            $cats = $stmt2->fetchAll();
                                            foreach ($cats as $cat) {
                                                echo "<option value='" . $cat['id'] . " '> " . $cat['name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End mCategories input-->
                                <!-- start submit input -->
                                <div class="mb-3  row">
                                    <div class=" offset-sm-3 col-sm-10">
                                        <input type="submit" value="Add item" class="btn btn-danger btn-lg ">
                                    </div>
                                </div>
                                <!-- ens submit input -->
                            </form>
                        </div>

                        <div class="col-md-4 mt-0">
                            <div class="col  ">
                                <div class="card live-preview item-box ">
                                    <span class="price-tag">0</span>
                                    <span class="favorit "><i class="fa-regular fa-heart"></i> </span>
                                    <img src="sss02.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Title</h5>
                                        <p class="card-text p1 p-0 m-0">Description<span class=""></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- start looping through errors  -->
                   <?php 
                   if(!empty($formError)){
                    foreach($formError as $error){
                        echo '<div class="alert alert-danger text-center fw-bold">' . $error .'</div>';
                    }
                   }
                   ?>
                <!-- start looping through errors  -->

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