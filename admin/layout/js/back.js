// $(document).ready(function() {
//     $(".dropdown-toggle").dropdown();
// }
$(function(){
 "use strict";




 //add asterisk on required field 
//  $('input') .each(function(){
//     if($(this).attr('required')=== 'required'){
//       $(this).after ('<span class="asterisk">  *</span>')
//     }
//  })





//convert password field to text field
var passfield = $('.pass');
$('.show-pass').hover(function(){
   passfield.attr('type','text');
},function(){
    passfield.attr('type','password');


});

// conformation message on button
    $('.confirm').click(function(){
        return confirm('are you sure');
    });
});