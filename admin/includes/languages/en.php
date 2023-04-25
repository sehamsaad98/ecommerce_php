<?php 
function lang($phrase){
    static $lang=array(
        // home page
       'message'     =>'welcome',
       'admin'       =>'administrator',
        // home page

        // dashboard phrases

        'home_admin'  =>'Home',
        'Categories'  =>'Categories',
        'Edit_Profile'=>'Edit Profile',
        'Settings'    =>'Settings',
        'Items'       =>'Items',
        'Members'     =>'Members',
        'statistics'  =>'statistics',
        'Logs'        =>'Logs',
        'Logout'        =>'Logout',



    );
    return $lang[$phrase];
}


?>