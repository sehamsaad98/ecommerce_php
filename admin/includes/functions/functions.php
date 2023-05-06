<?php
// title fuction that echo tha page title in case the page has $pageTitle variable 
// else echo a defult title for the page 
function getTitle(){
    global$pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo'defult';
    }
}
/**
 **********************
 **Redirect fuction (this function accept parameters )
 ** the message = echo theMsg [error | success | warning]
 ** url = the link you want to redirect to 
 **$seconds = number of seconds before redirecting
 */
function redirectFunction($theMsg ,$url = null, $seconds = 3){
   if ($url === null){
    $url ='index.php';
    $link = 'Homepage';
   }else{
    // by useing short if 
    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){

        $url = $_SERVER['HTTP_REFERER'];
        $link = 'Previous Page  ' ;
    }else{
        $url= 'index.php';
        $link = 'Homepage';
    }
   
   }
    echo  $theMsg;
    echo "<div class='alert alert-info'>You Will Redirected to $link After $seconds seconds .</div>";

    header("Refresh:$seconds;url=$url");
    exit;
}
/*
 **function to check items in db (function accept parameters)
 **$select = the item to select (Example : user , Item , Category)
 **$from = the table To Select (Example : users , Items , Categories)
 **$value = the Value Of Select 
 */
function checkItem($select , $from , $value){
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount(); 
    return $count;
}
/*
**Count The Number of Items Function 
**Function To Count The Number Of Items
**$item= item to count 
**$table = the table to choose 
*/
function countItmes($item ,$table){
    global $con;
    $stmt2= $con->prepare("SELECT COUNT($item) FROM $table ");
    $stmt2->execute();
    return $stmt2->fetchColumn() ;


}
/*
**Get latest Records Function 
**Function Tp Get Latest Items From Database [Users , Items , Comments]
**$Select = Field to Select 
**$table = The table To choose From
**$limit = Numbers Of Records To Get 
*/
function getLatest($select , $table , $order, $limit= 5 ){
    global $con ;
    $getStmt = $con->prepare("SELECT $select FROM $table  ORDER BY $order DESC  LIMIT $limit ");
    $getStmt->execute();
    $rows= $getStmt->fetchAll();
    return $rows ;
}