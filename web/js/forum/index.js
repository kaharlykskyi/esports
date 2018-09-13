$(document).ready( function() {
    if($("button").is("#text_forum")) {
        $("#text_forum").on('click',function(){
            $('.text_forum_form').slideToggle();
        });
    }
});

$(document).ready( function() {
    if($("button").is(".cahenge_date")) {
        $(".cahenge_date").on('click',function(){
            $('.cahenge_date_panel').slideToggle();
        });
    }
});