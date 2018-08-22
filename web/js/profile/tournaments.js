$(document).ready(function () {

    $('.format_campions').on('click', function(event){
        let elementJq = $(this);
        let id = elementJq.attr('data-farmat');

        if(id == 0){
            $('#match_schedule').slideUp();
            $('#elimination').slideToggle();
            //$('.format_campions').removeClass('active_campions');

            return;
        }
        if(id != 0){
            $('.format_campions').removeClass('active_campions');
            elementJq.addClass('active_campions');
           $('.radiolist_elimination').find('label').eq(id-1).click();
          
        }

        if(id == 1){
            $('#elimination').slideUp();
            $('#match_schedule').slideDown();
        }
    });

    $('#stream_add').on('click', function(event){
        event.preventDefault();
        let pashk = $('#stream_zaotovka').find('.plashka_stream').clone();

        console.log($('#stream_zaotovka'));
        $('#conteiner_stream').append(pashk);



    });

});