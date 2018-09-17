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


$(document).ready( function() {
    if($("span").is("#down-text")) {
        if($('#content_text_forum').height()>170){
            let span = $("#down-text");
            span.show();
            $.toggleState_icon = 0;
            $("#down-text").on('click',function(){
            $('.detail').toggleClass('detail_down');
                if ($.toggleState_icon) {
                    span.removeClass('glyphicon-chevron-up');
                    span.addClass('glyphicon-chevron-down');
                    $.toggleState_icon =0;
                } else {
                    span.addClass('glyphicon-chevron-up');
                    span.removeClass('glyphicon-chevron-down');
                    $.toggleState_icon =1;
                }  
            });
        }
    }

});