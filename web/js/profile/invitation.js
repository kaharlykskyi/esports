$(document).ready(function(){
 //$.max_players;

 $('.input_checkbox').on('click',function(event){
        
     setTimeout(function() {
         if($.max_players == $('input:checkbox:checked').length){
             $("input:checkbox:not(:checked)").attr('disabled',true);
         } else{
             $("input:checkbox:not(:checked)").attr('disabled',false);
         }

         if ($.max_players == $('input:checkbox:checked').length) {
             $('.invitation_input_submit').slideDown();
         } else {
             $('.invitation_input_submit').slideUp();
         }
     },100);

 });

});