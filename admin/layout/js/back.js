// $(document).ready(function() {
//     $(".dropdown-toggle").dropdown();
// }
$(function(){
 "use strict";

//dashboard
$('.toggle-info').click(function(){
    $(this).toggleClass('selected').parent().next('.list-group').fadeToggle(200);
    if ($(this).hasClass('selected')){
        $(this).html('<i class="fa-sharp fa-solid fa-minus fa-lg"></i>');
    }else{
        $(this).html('<i class="fa-sharp fa-solid fa-plus fa-lg"></i>');

    }
});


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

// category view options

$('.cat h3').click(function () {

    $(this).next('.full-view').fadeToggle(200);

});

$('.option span').click(function(){
   $(this).addClass('active').siblings('span').removeClass('active');
   if($(this).data('view')==='full'){
    $('.cat .full-view').fadeIn(200);
   }else{
    $('.cat .full-view').fadeOut(200);
   }
});
// show delete button on child cats 
$('.child-link').hover(function(){
    $(this).find('.show-delete').fadeIn();
},function(){
    $(this).find('.show-delete').fadeOut();

 });
});