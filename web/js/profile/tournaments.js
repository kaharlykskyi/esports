$(document).ready(function () {

    $('.format_campions').on('click', function(event){
        let elementJq = $(this);
        let id = elementJq.attr('data-farmat');

        if(id == 'c'){
            $('#match_schedule').slideUp();
            $('#elimination').slideDown();
            $('.radiolist_elimination').find('input').prop('checked', false);
            $('.format_campions').removeClass('active_campions');

            return;
        }

        if(id == 'l'){

            $('#elimination').slideUp();
            $('#match_schedule').slideDown();
            $('.format_campions').removeClass('active_campions');
            $('.default').addClass('active_campions');
            $('.radiolist_elimination').find('label').eq(2).click();
            return;
        }

        if(id != 0){
            $('.format_campions').removeClass('active_campions');
            elementJq.addClass('active_campions');
           $('.radiolist_elimination').find('label').eq(id-1).click();
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

    $('.game' ).on('click',function(){
        $('.game' ).removeClass("actives");
        $(this).addClass("actives");
        $('.erroe-massage').hide();
    });

    $('.formbtn' ).on('click',function(event){
        if (!$('.input_radio_games').filter(":checked").length) {
            event.preventDefault();
            $('.erroe-massage').show();
        } 
    }); 

});