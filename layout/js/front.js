
$(function(){
 "use strict";


// //dashboard
$('.toggle-info').click(function(){
    $(this).toggleClass('selected').parent().next('.list-group').fadeToggle(200);
    if ($(this).hasClass('selected')){
        $(this).html('<i class="fa-sharp fa-solid fa-minus fa-lg"></i>');
    }else{
        $(this).html('<i class="fa-sharp fa-solid fa-plus fa-lg"></i>');

    }
});


 //add asterisk on required field 
 $('input').each(function(){
    if($(this).attr('required')=== 'required'){
      $(this).after ('<span class="asterisk">  *</span>')
    }
 })



// conformation message on button
 $('.confirm').click(function(){
        return confirm('are you sure');
});

// $('.live-name').keyup(function () {
// // $($(this).data('class')).text($(this).val());
// $('.live-preview h5').text($(this).val());

// });





  function liveWrite(input, output, sign = '') {
        $(input).keyup(function() {
            $(output).text(sign + $(this).val())
        })
    }
    liveWrite('.live-name', '.live-preview h5');
    liveWrite('.live-desc', '.live-preview   .p1 ');
    liveWrite('.live-price', '.live-preview .price-tag', '$');



});