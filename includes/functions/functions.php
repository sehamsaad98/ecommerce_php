<?php
// user function page start

/*
** Get Categories  Function 
**Function Tp Get  Categories From Database 
*/
function getCat( ){
    global $con ;
    $getCat = $con->prepare("SELECT * FROM categories  ORDER BY id ASC  ");
    $getCat->execute();
    $cats= $getCat->fetchAll();
    return $cats ;
}




/*
** Get Items  Function 
**Function Tp Get  Items From Database 
*/
function getItems($where ,$value ){
    global $con ;
    $getItems = $con->prepare("SELECT * FROM items WHERE $where =?  ORDER BY id ASC  ");
    $getItems->execute(array($value));
    $items= $getItems->fetchAll();
    return $items ;
}

/*
** Check if user is not Active 
**Function To Check The Regsatus Of The User
*/
function checkUserStatus($user){
    global $con;
            $stmtx=$con->prepare("SELECT 
               username , regStatus 
            FROM 
                users 
            WHERE 
                username= ? 
            AND 
            regStatus = 0 ");
     $stmtx->execute(array($user));

     // count rows
    $status= $stmtx->rowCount();
    return $status;

}
// user function page end
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
