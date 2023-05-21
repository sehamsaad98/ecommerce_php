
<?php
ob_start();
session_start();
$pageTitle = 'cart';



if (isset($_SESSION['user'])) {
    include 'init.php';        
        if(isset($_POST['addtocart'])){
        $NAME=$_POST['name'];
        $PRICE=$_POST['price'];

        echo $PRICE;
        $stmt=$con->prepare("INSERT INTO cart (name,price)  VALUES (:zname , :zprice) ");
        $stmt->execute(array(
            'zname'   => $NAME,
            'zprice'   => $PRICE,
        ));
        header('location:cart.php');
        }
}
 include $tpl.'footer.php';
 ob_end_flush();

