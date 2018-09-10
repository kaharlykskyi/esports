$(document).ready( function() {
    if($("button").is("#text_forum")) {
        $("#text_forum").on('click',function(){
            $('.text_forum_form').slideToggle();
        });
    }
});