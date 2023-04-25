<?php
// data source name
$dsn='mysql:host=localhost;dbname=shop';
$user='root';
$password = "";
$option=array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8',
);



try{
    $con=new PDO($dsn, $user , $password ,$option);
    // $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'your are connected to database';
}
catch(PDOException $e) {
    echo'failed to connect' . $e->getMessage();

}



?>