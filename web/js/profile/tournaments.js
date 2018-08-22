$(document).ready(function () {

    $('.format_campions').on('click', function(event){
        let elementJq = $(this);
        let id = elementJq.attr('data-farmat');

        if(id == 0){
            $('#match_schedule').slideUp();
            $('#elimination').slideToggle();
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
        pashk.find('.close_stream').on('click',function(event){
            $(event.target).parents('.plashka_stream').remove();
        });
        pashk.find('input').focus(function(event){
            $(event.target).css("border-color","transparent");
        });
        

        $('#conteiner_stream').append(pashk);
    });

    $('.formbtn' ).on('click',function(event){
       let inputs = $('#conteiner_stream').find('input');
       inputs.each(function (indx, element) {
            if($(element).val() == "") {
                $(element).css("border-color","red");
                event.preventDefault();
            }
        });
            
        
    }); 

});