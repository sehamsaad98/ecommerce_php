<?php
/*
==============================================
==items
==you can add|edit|delete items here
==============================================
*/

session_start();
$pageTitle = 'Items';
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
    if ($do == 'manage') { //manage pag categories

        $stmt = $con->prepare("SELECT
                               items.* ,categories.name AS catogry_name ,users.username As Username
                          FROM 
                               items
                          INNER JOIN 
                               categories 
                          ON 
                               categories.id = items.cat_id
                          INNER JOIN 
                               users 
                          ON 
                               users.id = items.member_id  
                          ORDER BY 
                                id DESC ");
        // excute the statement
        $stmt->execute();
        // assign to variabels
        $items = $stmt->fetchAll();
       if(!empty($items)){

?>
        <h1 class="text-center"> Manage Items</h1>
        <div class="container ">
            <div class="table-responsive">
                <table class="table table-bordered main-table text-center ">
                    <tr class="">
                        <td>#ID</td>
                        <td>Image</td>
                        <td>name</td>
                        <td>Description</td>
                        <td> Price</td>
                        <td>Adding date </td>
                        <td>Category </td>
                        <td> Username </td>
                        <td>Control </td>


                        
                    </tr> 
                    <?php foreach ($items as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['id'] . "</td>";
                        echo"<td><img src='images/items/ " . $item['image'] . "' style='width:80px;height:50px;'> </a></td>";
                        echo "<td>" . $item['name'] . "</td>";
                        echo "<td>" . $item['description'] . "</td>";
                        echo "<td>" . $item['price'] . "</td>";
                        echo "<td>" . $item['add_date'] . "</td>";
                        echo "<td>" . $item['catogry_name'] . "</td>";
                        echo "<td>" . $item['Username'] . "</td>";
                        echo "<td> 
                             <a href='items.php?do=edit&item_id=" . $item['id'] . "' class='btn btn-success'><i class='fa fa-edit '></i>Edit</a>
                             <a href='items.php?do=Delete&item_id=" . $item['id'] . "' class='btn btn-danger confirm'><i class='fa fa-close '></i>Delete</a>";
                        if ($item['approve'] == 0) {
                            echo "<a href='items.php?do=Approve&item_id=" . $item['id'] . "' class='btn btn-info activate '><i class='fa-solid fa-check'></i>
                                Approve</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    } ?>

                </table>
            </div>

            <a href='items.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i> add Item </a>
        </div>
    
        <?php }else{
                    echo "<div class='container'>";
                    echo "<div class='alert alert-info fw-bold text-center'>There Is No  Record To Show  </div>";
                    echo "<a href='items.php?do=add' class='btn btn-primary'><i class='fa fa-plus'></i> Add Items </a>";
                    echo "</div>";
                 }  ?>  
        <!-- end manage page design -->
    <?php

    } elseif ($do == 'add') {
    ?>

        <!--  add Items page  -->
        <h1 class="text-center"> Add New Item</h1>
        <div class="container contform ">
            <form action="items.php?do=insert" method="POST" class="form-horizontal " enctype="multipart/form-data">
                <!-- start Name input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Name</label>
                    <div class="col-sm-10 col-md-5  ">
                        <input type="text" class="form-control form-control-lg " name="name" placeholder="Name Of Item">
                    </div>
                </div>
                <!-- end Name input -->
                <!-- start Description input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Description</label>
                    <div class="col-sm-10 col-md-5  ">
                        <input type="text" class="form-control form-control-lg " name="description" placeholder="Description Of Item">
                    </div>
                </div>
                <!-- end Description input -->
                <!-- start Price input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Price</label>
                    <div class="col-sm-10 col-md-5  ">
                        <input type="text" class="form-control form-control-lg " name="price" placeholder="Name Of Item">
                    </div>
                </div>
                <!-- end Price input -->
                <!-- start Country input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Country</label>
                    <div class="col-sm-10 col-md-5  ">
                        <input type="text" class="form-control form-control-lg " name="country" placeholder="Country Of made">
                    </div>
                </div>
                <!-- end Country input -->
                <!-- start item image  input -->
                   <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Item Image</label>
                        <div class="col-sm-10 col-md-5 ">
                            <input type="file" class="form-control form-control-lg " name="image" placeholder=" Choose your image "  >
                        </div>
                    </div>
                <!-- end item image  input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Status</label>
                    <div class="col-sm-10 col-md-5">
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

                <!--  start members input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Member</label>
                    <div class="col-sm-10 col-md-5">
                        <select name="member" class="form-control form-control-lg ">
                            <option value="0">...</option>
                            <?php
                            $allUsers = getAll("*" , "users" , "" , "" ,"id" );
                            foreach ($allUsers as $user) {
                                echo "<option value='" . $user['id'] . " '> " . $user['username'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- End members Field -->
                <!--  start Categories input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Categories</label>
                    <div class="col-sm-10 col-md-5">
                        <select name="category" class="form-control form-control-lg ">
                            <option value="0">...</option>
                            <?php 
                            $allcats = getAll("*" , "categories" , "where parent= 0" , "" ,"id" );
                            foreach ($allcats as $cat) {
                                echo '<hr class>';
                                echo "<option value='" . $cat['id'] . " '> " . $cat['name'] . "</option>";
                                $childcat = getAll("*" , "categories" , "where parent= {$cat['id']}" , "" ,"id" );
                                foreach($childcat as $child){
                                    echo "<option value='" . $child['id'] . " '> ----" . $child['name'] .' is  '.$cat['name']. "'s child</option>";
                                    echo '<hr>';
                                }

                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- End mCategories input-->
                <!-- start Tags input -->
                <div class="mb-3  row p-0">
                    <label class="col-sm-1  col-form-label ">Tags</label>
                    <div class="col-sm-10 col-md-5  ">
                        <input type="text" class="form-control form-control-lg " name="tags" placeholder="separate tags with comma (,)">
                    </div>
                </div>
                <!-- end Tags input -->
                <!-- start submit input -->
                <div class="mb-3  row">
                    <div class=" offset-sm-1 col-sm-10">
                        <input type="submit" value="Add item" class="btn btn-danger btn-lg ">
                    </div>
                </div>
                <!-- ens submit input -->
            </form>
        </div>
        <?php

    } elseif ($do == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<h1 class="text-center"> Insert  Items</h1>';
            echo '<div class="container">';
            //uploade variables
            $imageName=$_FILES['image']['name'];
            $imageSize=$_FILES['image']['size'];
            $imageType=$_FILES['image']['type'];
            $imageTmp= $_FILES['image']['tmp_name'];
            $imageAllowedExtentions=array("jpeg" , "jpg" , "gif" ,"png" );
            // to get image extention using explode
            $typ =explode('.', $imageName);
            $endOfimagename= end($typ);
            $imageExtention = strtolower($endOfimagename);


            // get variables from the form 
            $name    = $_POST['name'];
            $desc    = $_POST['description'];
            $price   = $_POST['price'];
            $country = $_POST['country'];
            $status  = $_POST['status'];
            $cat     = $_POST['category'];
            $member  = $_POST['member'];
            $tags    = $_POST['tags'];



            // validate the form
            $formerror = array();
            if (empty($name)) {
                $formerror[] = "sorry  name con't be <strong>empty</strong>";
            }
            if (empty($desc)) {
                $formerror[] = "sorry description con't be <strong>empty</strong>";
            }
            if (empty($price)) {
                $formerror[] = " sorry price con't be <strong>empty</strong> ";
            }

            if (empty($country)) {
                $formerror[] = "sorry  country con't be <strong>empty</strong>";
            }
            if ($status == 0) {
                $formerror[] = "You Must Choose the <strong>Status</strong>";
            }
            if ($cat == 0) {
                $formerror[] = "You Must Choose the <strong>Category</strong>";
            }
            if ($member == 0) {
                $formerror[] = "You Must Choose the <strong>Member</strong>";
            }
            if( empty($imageName) ){
                $formerror[]= " sorry image can't be <strong>empty </strong>";
            }
            if( !empty($imageName) && ! in_array($imageExtention ,$imageAllowedExtentions)){
                $formerror[]= " sorry this Extention is not  <strong>Allowed </strong>";
            }
            if( $imageSize >4194304){
                $formerror[]= " sorry image can't be more than <strong>4 MB</strong>";
            }
            foreach ($formerror as $error) {
                echo "<div class='alert alert-danger'>" .  $error  . "</div>";
            }
            // if there is no error proceed the insert operation
            // insert into db 
            if (empty($formerror)) {
                $image = rand(0, 10000000000) . '_' . $imageName;
                move_uploaded_file($imageTmp , "images\items\\ ". $image) ;  
                //insert info in db
                $stmt = $con->prepare("INSERT INTO 
                                          items (name, description , price , country_made, status , add_date ,cat_id, member_id , tags ,image) 
                                    VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus, now() , :zcat, :zmember, :ztags ,:zimage)");
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $desc,
                    'zprice'     => $price,
                    'zcountry'     => $country,
                    'zstatus'     => $status,
                    'zcat'        => $cat,
                    'zmember'    => $member,
                    'ztags'    => $tags,
                    'zimage'=> $image

                ));
                //echo success message 
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

                redirectFunction($theMsg, 'back');
            }
        } else {
            echo "<div class='container'>";
            $theMsg = '<div class ="alert alert-danger ">sorry you cant prows this page directly</div>';
            redirectFunction($theMsg);
            echo "</div>";
        }
        echo '</div>';
    } elseif ($do == 'edit') {
        //edit page 
        // using short if condion to chick if userid  is numeric and get the integer value of it 
        $item_id = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;

        // select all data from db using this  id
        $stmt = $con->prepare("SELECT  *  FROM   items WHERE  id= ? ");
        //    execute data 
        $stmt->execute(array($item_id));
        // do fetch for data
        $item = $stmt->fetch();
        // count rows
        $count = $stmt->rowCount();
        // if there is such id show this form 
        if ($count >  0) { ?>
            <!--  edit Items page  -->
            <h1 class="text-center"> Edit Item</h1>
            <div class="container contform ">
                <form action="items.php?do=update" method="POST" class="form-horizontal " enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $item_id ?>" name="item_id">

                    <!-- start Name input -->
                    <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Name</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="name" placeholder="Name Of Item" value="<?php echo $item['name'] ?>">
                        </div>
                    </div>
                    <!-- end Name input -->
                    <!-- start Description input -->
                    <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Description</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="description" placeholder="Description Of Item" value="<?php echo $item['description'] ?>">
                        </div>
                    </div>
                    <!-- end Description input -->
                    <!-- start Price input -->
                    <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Price</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="price" placeholder="Name Of Item" value="<?php echo $item['price'] ?>">
                        </div>
                    </div>
                    <!-- end Price input -->
                    <!-- start Country input -->
                    <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Country</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="country" placeholder="Country Of made" value="<?php echo $item['country_made'] ?>">
                        </div>
                    </div>
                    <!-- end Country input -->
                    <!-- start item image  input -->
                    <div class="mb-3  row">
                            <label for="inputPassword" class="col-sm-1  col-form-label">Item Image</label>
                            <div class="col-sm-10 col-md-5 ">
                              <input type="hidden" name="old_image" value="<?php echo $item['image'] ?>">
                                <input type="file" class="form-control form-control-lg " name="image"  value="<?php echo $item['image'] ?>" > <span name="image" value="<? echo $item['image']?>">
                            </div>
                        </div>
                    <!-- end item image  input -->
                        <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Status</label>
                        <div class="col-sm-10 col-md-5">
                            <select name="status" class="form-control form-control-lg ">
                                <option value="1" <?php if ($item['status'] == 1) {
                                                        echo 'selected';
                                                    } ?>>New</option>
                                <option value="2" <?php if ($item['status'] == 2) {
                                                        echo 'selected';
                                                    } ?>>Like New</option>
                                <option value="3" <?php if ($item['status'] == 3) {
                                                        echo 'selected';
                                                    } ?>>Used</option>
                                <option value="4" <?php if ($item['status'] == 4) {
                                                        echo 'selected';
                                                    } ?>>Very Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!--  start members input -->
                    <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Member</label>
                        <div class="col-sm-10 col-md-5">
                            <select name="member" class="form-control form-control-lg ">
                                <?php
                            $allUsers = getAll("*" , "users" , "" , "" ,"id" );
                                foreach ($allUsers as $user) {
                                    echo "<option value='" . $user['id'] . " '";
                                    if ($item['member_id'] == $user['id']) {
                                        echo 'selected';
                                    }
                                    echo "> " . $user['username'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End members Field -->
                    <!--  start Categories input -->
                    <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Categories</label>
                        <div class="col-sm-10 col-md-5">
                            <select name="category" class="form-control form-control-lg ">
                                <?php 
                                $allcats = getAll("*" , "categories" , "where parent= 0" , "" ,"id" );
                                foreach ($allcats as $cat) {
                                    echo "<option value='" . $cat['id'] . " '";
                                    if ($item['cat_id'] == $cat['id']) {
                                        echo 'selected';
                                    }
                                    echo " > " . $cat['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End mCategories input-->
                    <!-- start Tags input -->
                    <div class="mb-3  row p-0">
                        <label class="col-sm-1  col-form-label ">Tags</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="tags" placeholder="separate tags with comma (,)"  value="<?php echo $item['tags'] ?> ">
                        </div>
                    </div>
                    <!-- end Tags input -->
                    <!-- start submit input -->
                    <div class="mb-3  row">
                        <div class=" offset-sm-1 col-sm-10">
                            <input type="submit" value="Edit item" class="btn btn-danger btn-lg ">
                        </div>
                    </div>
                    <!-- ens submit input -->
                </form>


                <?php
                // Select All Comments 
                $stmt = $con->prepare("SELECT 
                            comments.*  ,users.username As Username 
                         FROM 
                            comments                      
                         INNER JOIN 
                            users 
                         ON 
                            users.id = comments.user_id; 
                        WHERE
                            item_id =? ");
                // excute the statement
                $stmt->execute(array($item_id));

                // assign to variabels
                $comments = $stmt->fetchAll();
                // print_r($comments);
                if (! empty($comments)) {
                ?>
                <h1 class="text-center"> Manage [<?php echo $item['name']?>] Comments</h1>
                <div class="container ">
                    <div class="table-responsive">
                        <table class="table table-bordered main-table text-center ">
                            <tr class="">
                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>Control</td>

                            </tr>
                            <?php foreach ($comments as $comment) {
                                echo "<tr>";
                                echo "<td>" . $comment['comment'] . "</td>";
                                echo "<td>" . $comment['Username'] . "</td>";
                                echo "<td>" . $comment['added_date'] . "</td>";
                                echo "<td> 
                            <a href='comments.php?do=edit&comid=" . $comment['c_id'] . "' class='btn btn-success'><i class='fa fa-edit '></i>Edit</a>
                            <a href='comments.php?do=Delete&comid=" . $comment['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close '></i>Delete</a>";
                                if ($comment['status'] == 0) {
                                    echo "<a href='comments.php?do=Approve&comid=" . $comment['c_id'] . "' class='btn btn-info activate '><i class='fa-solid fa-check'></i>
                               Approve</a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            } ?>

                        </table>
                    </div>
                <?php } ?>

            </div>
<?php
            //    if there is such id show error
        } else {
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-danger">there is no such id</div>';
            redirectFunction($theMsg);
            echo '</div>';
        }
    } elseif ($do == 'update') {
        echo '<h1 class="text-center"> update  Items</h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //uploade variables
            $old_image =$_POST['old_image'];

            $imageName=$_FILES['image']['name'];
            $imageSize=$_FILES['image']['size'];
            $imageType=$_FILES['image']['type'];
            $imageTmp= $_FILES['image']['tmp_name'];
            $imageAllowedExtentions=array("jpeg" , "jpg" , "gif" ,"png" );
            // to get image extention using explode
            $typ =explode('.', $imageName);
            $endOfimagename= end($typ);
            $imageExtention = strtolower($endOfimagename);

            $id = $_POST['item_id'];
            $name    = $_POST['name'];
            $desc    = $_POST['description'];
            $price   = $_POST['price'];
            $country = $_POST['country'];
            $status  = $_POST['status'];
            $cat      = $_POST['category'];
            $member  = $_POST['member'];
            $tag    = $_POST['tags'];
            
            // validate the form
            $formerror = array();
            if (empty($name)) {
                $formerror[] = "sorry  name con't be <strong>empty</strong>";
            }
            if (empty($desc)) {
                $formerror[] = "sorry description con't be <strong>empty</strong>";
            }
            if (empty($price)) {
                $formerror[] = " sorry price con't be <strong>empty</strong> ";
            }

            if (empty($country)) {
                $formerror[] = "sorry  country con't be <strong>empty</strong>";
            }
            if ($status == 0) {
                $formerror[] = "You Must Choose the <strong>Status</strong>";
            }
            if ($cat == 0) {
                $formerror[] = "You Must Choose the <strong>Category</strong>";
            }
            if ($member == 0) {
                $formerror[] = "You Must Choose the <strong>Member</strong>";
            }

            if( !empty($imageName) && ! in_array($imageExtention ,$imageAllowedExtentions)){
                $formerror[]= " sorry this Extention is not  <strong>Allowed </strong>";
            }
            if( $imageSize >4194304){
                $formerror[]= " sorry image can't be more than <strong>4 MB</strong>";
            }
            foreach ($formerror as $error) {
                echo "<div class='alert alert-danger'>" .  $error  . "</div>";
            }
            // if there is no error proceed the insert operation
            // insert into db 
            if (empty($formerror)) {
                if(empty($imageName)){
                    $image=$old_image ;
                }else
                {
                $image = rand(0, 10000000000) . '_' . $imageName;
                move_uploaded_file($imageTmp , "images\items\\ ". $image) ;
                } 
                //insert info in db
                $stmt = $con->prepare("UPDATE items SET name = ? ,description = ? , price  = ? , country_made=? , status=? , cat_id=? , member_id = ? ,tags = ?,image=? WHERE id = ?");
                $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member,$tag, $image, $id  ));
                //echo success message 
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

                redirectFunction($theMsg, 'back');
            }
        } else {
            $theMsg = '<div class ="alert alert-danger">sorry you cant prows this page directly</div>';

            redirectFunction($theMsg);
        }
        echo '</div>';
    } elseif ($do == 'Delete') {
        // delete Item page 
        // using short if condion to chick if userid  is numeric and get the integer value of it 
        echo '<h1 class="text-center"> Delete  items</h1>';
        echo '<div class="container">';
        $item_id = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;

        // select all data from db using this  id
        //  $stmt=$con->prepare("SELECT  *  FROM   users WHERE  id= ? ");
        $check = checkItem('id', 'items', $item_id);
        // if there is such id show this form 
        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM items WHERE id =:zitem");

            $stmt->bindParam(":zitem", $item_id);
            $stmt->execute();
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . '   ' . 'record Deleted</div>';
            redirectFunction($theMsg, 'back');
        } else {
            $theMsg = "<div class = 'alert alert-danger'>This Id Is Not Exist</div>";
            redirectFunction($theMsg);
        }
        echo '</div>';
    } elseif ($do == 'Approve') {
        // Approve Item page 
        // using short if condion to chick if item_id  is numeric and get the integer value of it 
        echo '<h1 class="text-center"> Approve Items</h1>';
        echo '<div class="container">';
        $item_id = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
        // select all data from db using this  item_id
        $check = checkItem('id', 'items', $item_id);
        // if there is such id show this form 
        if ($check > 0) {
            $stmt = $con->prepare("UPDATE items SET approve = 1 WHERE id = ? ");
            $stmt->execute(array($item_id));
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . '   ' . 'record Activated</div>';
            redirectFunction($theMsg, 'back');
        } else {
            $theMsg = "<div class = 'alert alert-danger'>This Id Is Not Exist</div>";
            redirectFunction($theMsg);
        }
        echo '</div>';
    }
    // end manage page
    include $tpl . 'footer.php';
} else {
    header('location:index.php');
    exit();
}

?>