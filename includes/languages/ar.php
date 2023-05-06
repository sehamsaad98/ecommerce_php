<?php
function lang($phrase){
    static $lang=array(
   'message'=>'مرحبا',
   'admin'=>'لوحة التحكم'

    );
    return $lang[$phrase];
}


?>