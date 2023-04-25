<?php
/*
==============================================
==categories
==you can add|edit|delete members here
==============================================
*/

session_start();
$pageTitle = 'categories';
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
    if ($do == 'manage') {//manage pag categories
        $sort= 'ASC';
        $sort_array = array("ASC" , "DESC");
        if(isset($_GET['sort'])&& in_array($_GET['sort'], $sort_array)){
            $sort =$_GET['sort'] ;
        }
     $stmt2 =$con->prepare("SELECT * FROM categories ORDER BY ordering $sort");
     $stmt2->execute();
     $cats=$stmt2->fetchAll();?>
     <h1 class="text-center"> Manage Categories</h1>
     <div class="container categories">
     <div class="card">
                    <div class="card-header">
                    Manage Categories
                    <div class="ordering float-end">
                        Ordering : 
                        <a class="<?php if($sort=='ASC'){echo 'active';}?>" href="?sort=ASC">ASC</a> |
                        <a class="<?php if($sort=='DESC'){echo 'active';}?>"href="?sort=DESC">DESC</a>
                    </div>
                    </div>
                   
                    <div class="card-body"><?php foreach ($cats as $category) {
                        echo "<div class='cat'>";
                           echo"<div class='hidden-buttons'>";
                           echo "<a href='categories.php?do=edit&catid=".$category['id']."' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                           echo "<a href='' class='btn btn-sm btn-danger'><i class='fa fa-close'></i> Delete</a>";

                           echo "</div>";
                            echo "<h3>". $category['name'] ."</h3> ";
                            echo "<p>"; if ($category['description']==''){
                                echo "this description is empty";
                            }else{
                               echo $category['description'];
                            } echo "</p>" ;

                            if ($category['visibility'] ==1){ echo "<span class='visibility comon-span'> Hidden</span> ";}
                            if ($category['allow_comment'] ==1){ echo "<span class='comment comon-span'> Comment Disabled </span> ";}
                            if ($category['allow_ads'] ==1){ echo "<span class='ads comon-span'> Advertise Disabled </span> ";}
                          echo"</div>";
                          echo"<hr>";
                        }
                        ?></div>
                </div>
     </div>
     <?php     
    }elseif($do == 'add'){ ?>
       
      <!--  add Categories page  -->
      <h1 class="text-center"> add new Category</h1>
            <div class="container contform ">
                <form action="categories.php?do=insert" method="POST" class="form-horizontal ">
                    <!-- start Name input -->
                    <div class="mb-3  row p-0">
                        <label for="inputPassword" class="col-sm-1  col-form-label " autocomplete="off" >Name</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="name"  required="required" placeholder="Name Of Category" >
                        </div>
                    </div>
                     <!-- ens Name input -->
                    <!-- start description input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Description</label>
                        <div class="col-sm-10 col-md-5 password" >
                         <input type="text" class="form-control form-control-lg " name="description"    placeholder=" Dscribe the category" >

                        </div>
                    </div>
                     <!-- end description input -->
                    <!-- start ordering input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Ordering</label>
                        <div class="col-sm-10 col-md-5 ">
                            <input type="text" class="form-control form-control-lg " name="ordering" placeholder="Number To Arrange The Categories"  >
                        </div>
                    </div>
                     <!-- ens ordering input -->
                    <!-- start visible input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Full name</label>
                        <div class="col-sm-10 col-md-5 ">
                            <div>
                                <input id="visibity-yes" type="radio" name="visibilty" value="0" checked >
                                <label for="visibity-yes">Yes</label>
                            </div>
                            <div>
                                <input id="visibity-no" type="radio" name="visibilty" value="1" >
                                <label for="visibity-no">No</label>
                            </div>
                        </div>
                    </div>
                     <!-- ens visible input -->
                     <!-- start commentig input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-5 ">
                            <div>
                                <input id="comment-yes" type="radio" name="commenting" value="0" checked >
                                <label for="comment-yes">Yes</label>
                            </div>
                            <div>
                                <input id="comment-no" type="radio" name="commenting" value="1" >
                                <label for="comment-no">No</label>
                            </div>
                        </div>
                    </div>
                     <!-- ens commenting input -->
                     <!-- start Adds input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Allow Adds</label>
                        <div class="col-sm-10 col-md-5 ">
                            <div>
                                <input id="adds-yes" type="radio" name="adds" value="0" checked >
                                <label for="adds-yes">Yes</label>
                            </div>
                            <div>
                                <input id="adds-no" type="radio" name="adds" value="1" >
                                <label for="adds-no">No</label>
                            </div>
                        </div>
                    </div>
                     <!-- ens Adds input -->
                    <!-- start submit input -->
                    <div class="mb-3  row">
                        <div class=" offset-sm-1 col-sm-10">
                            <input type="submit"  value="Add Category" class="btn btn-danger btn-lg " placeholder=""  required="required">
                        </div>
                    </div>
                     <!-- ens submit input -->
                </form>
            </div>
    <?php        
    }elseif($do == 'insert'){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            echo '<h1 class="text-center"> Insert  Category</h1>';
            echo '<div class="container">';

            // get variables from the form (from ths name of the input )
            $name= $_POST['name'];
            $desc=$_POST['description'];           
            $order= $_POST['ordering'];
            $visible= $_POST['visibilty'];
            $comment= $_POST['commenting'];
            $ads= $_POST['adds'];

    
            // if there is no error proceed the insert operation
            // insert into db 
            
            //Check if Category is Exist In Database
                $check=checkItem("name", "categories", $name);
                if($check == 1 ){
                    $theMsg= "<div class='alert alert-danger'>sorry this Category is exist </div>";
                    redirectFunction($theMsg , 'back' );
                    
                }else{
               //insert info in db
               $stmt=$con->prepare("INSERT INTO 
                                          categories (name, description , ordering , visibility,allow_comment, allow_ads) 
                                    VALUES (:zname , :zdesc , :zorder , :zvisible ,:zcomment, :zads)");
                $stmt->execute(array(
                    'zname'   => $name,
                    'zdesc'   => $desc,
                    'zorder'  =>$order,
                    'zvisible'=>$visible,
                    'zcomment'=> $comment,
                    'zads'    =>$ads
                ));
               //echo success message 
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record insert</div>';
                redirectFunction($theMsg , 'back' );
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
        // using short if condion to chick if categoryId  is numeric and get the integer value of it 
        $catid=isset($_GET['catid'])&& is_numeric($_GET['catid']) ? intval($_GET['catid']):0;
       
       // select all data from db using this  id
       $stmt=$con->prepare("SELECT  *  FROM   categories WHERE  id= ? ");
       //    execute data 
       $stmt->execute(array($catid));
       // do fetch for data
       $cat=$stmt->fetch();
       // count rows
       $count= $stmt->rowCount();        
       // if there is such id show this form 
       if ( $count >  0){?>
         
        <!-- echo 'welcom this is edit page your id =' . $_GET['userid']; -->
        <h1 class="text-center"> Edit Category</h1>
            <div class="container contform ">
                <form action="categories.php?do=update" method="POST" class="form-horizontal ">
                <input type="hidden" value="<?php echo $catid?>" name="catid">

                    <!-- start Name input -->
                    <div class="mb-3  row p-0">
                        <label for="inputPassword" class="col-sm-1  col-form-label " autocomplete="off" >Name</label>
                        <div class="col-sm-10 col-md-5  ">
                            <input type="text" class="form-control form-control-lg " name="name"  required="required" placeholder="Name Of Category" value="<?php echo $cat['name']?>" >
                        </div>
                    </div>
                     <!-- ens Name input -->
                    <!-- start description input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Description</label>
                        <div class="col-sm-10 col-md-5 password" >
                         <input type="text" class="form-control form-control-lg " name="description"    placeholder=" Dscribe the category"  value="<?php echo $cat['description']?>">

                        </div>
                    </div>
                     <!-- end description input -->
                    <!-- start ordering input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Ordering</label>
                        <div class="col-sm-10 col-md-5 ">
                            <input type="text" class="form-control form-control-lg " name="ordering" placeholder="Number To Arrange The Categories"  value="<?php echo $cat['ordering']?>">
                        </div>
                    </div>
                     <!-- ens ordering input -->
                    <!-- start visible input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Full name</label>
                        <div class="col-sm-10 col-md-5 ">
                            <div>
                                <input id="visibity-yes" type="radio" name="visibilty" value="0" <?php if($cat['visibility']==0){ echo "checked";} ?> >
                                <label for="visibity-yes">Yes</label>
                            </div>
                            <div>
                                <input id="visibity-no" type="radio" name="visibilty" value="1" <?php if($cat['visibility']==1){echo "checked";}  ?> >
                                <label for="visibity-no">No</label>
                            </div>
                        </div>
                    </div>
                     <!-- ens visible input -->
                     <!-- start commentig input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-5 ">
                            <div>
                                <input id="comment-yes" type="radio" name="commenting" value="0" <?php if($cat['allow_comment']==0){ echo "checked";} ?> >
                                <label for="comment-yes">Yes</label>
                            </div>
                            <div>
                                <input id="comment-no" type="radio" name="commenting" value="1" <?php if($cat['allow_comment']==1){ echo "checked";} ?> >
                                <label for="comment-no">No</label>
                            </div>
                        </div>
                    </div>
                     <!-- ens commenting input -->
                     <!-- start Adds input -->
                    <div class="mb-3  row">
                        <label for="inputPassword" class="col-sm-1  col-form-label">Allow Adds</label>
                        <div class="col-sm-10 col-md-5 ">
                            <div>
                                <input id="adds-yes" type="radio" name="adds" value="0" <?php if($cat['allow_ads']==0){ echo "checked";} ?> >
                                <label for="adds-yes">Yes</label>
                            </div>
                            <div>
                                <input id="adds-no" type="radio" name="adds" value="1" <?php if($cat['allow_ads']==1){ echo "checked";} ?>>
                                <label for="adds-no">No</label>
                            </div>
                        </div>
                    </div>
                     <!-- ens Adds input -->
                    <!-- start submit input -->
                    <div class="mb-3  row">
                        <div class=" offset-sm-1 col-sm-10">
                            <input type="submit"  value="Update" class="btn btn-danger btn-lg " placeholder=""  required="required">
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
    }elseif($do == 'update'){ 
        echo '<h1 class="text-center"> update  Categories</h1>';
        echo '<div class="container">';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // get variables from the form (from ths name of the input )

            $id= $_POST['catid'];    
            $name= $_POST['name'];
            $desc=$_POST['description'];           
            $order= $_POST['ordering'];
            $visible= $_POST['visibilty'];
            $comment= $_POST['commenting'];
            $ads= $_POST['adds'];
            // short if (condition ? true : false)
            $stmt = $con->prepare("UPDATE
                                         categories 
                                   SET 
                                         name = ? ,
                                         description = ? , 
                                         ordering = ? , 
                                         visibility = ?  , 
                                         allow_comment=? , 
                                         allow_ads=?
                                         
                                  WHERE 
                                         id = ?");
                $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $id));
               //echo success message 
               $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() .'   ' .'record updated</div>';
                redirectFunction($theMsg , 'back' , 4 );
       
        }else{
            $theMsg= '<div class ="alert alert-danger">sorry you cant prows this page directly</div>';

            redirectFunction($theMsg );
        }
        echo '</div>';
     
     
    }elseif($do=='Delete'){

   
}
               // end manage page
    include $tpl . 'footer.php';
} else {
    header('location:index.php');
    exit();
}
