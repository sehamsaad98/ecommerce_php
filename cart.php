<?php
ob_start();
session_start();
$pageTitle = 'cart';



if (isset($_SESSION['user'])) {
    include 'init.php';        
  
  $cartitems=  getAll( '*','cart' , '','' ,'id' );

?>
<div class="container">
 <center><h1 class="fw-bold mt-3">  Your Cart </h1></center>
    <?php
 
        // echo "<pre>";
        // print_r($row) ;
        // echo "</pre>";
        echo"
        
        <main>
            <table class='table mt-4'>
                <thead >
                    <tr>
                        <th scope='col'> product name</th>
                        <th scope='col'>product price</th>
                        <th scope='col'>delete product</th>

                    </tr>
                </thead>
                <tbody>";
                foreach($cartitems as $item){
                  echo "  <tr>
                        <td>$item[name]</td>
                        <td>$item[price]</td>
                        <td><a href='del_cart.php? id=$item[id]'  class='btn btn-danger'>delete</a> </td>

                    </tr>";
                }

               echo" </tbody>
            </table>
        </main>";
    

    
    ?>
    <center>
        <a href="index.php">الرجوع الى صفحة المنتجات</a>
    </center></div>
<?php
         
  include $tpl.'footer.php';
}

  



 ob_end_flush();
