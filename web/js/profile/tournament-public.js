$(document).ready(function(){
	$('.my-tabs').ready(function () {
        ////Javascript to enable link to tab
        let url = document.location.toString();
        if (url.match('#')) {
            $('.champ-nav-list a[href="#' + url.split('#')[1] + '"]').tab('show');
        } 

        let arr = document.location.href.split('/');
        arr = arr[arr.length-1];
        //console.log(arr.split('#')[0]);
        window.history.pushState(null, null, arr.split('#')[0]);
    });


    $('.system_select').find('.options').find('li').on('click',function(){
        let value = $(this).text();
        let i ='';
        if (value == 'Bo1') {
            i = 2;
        }
        if (value == 'Bo3') {
            i = 3;
        }
        if (value == 'Bo5') {
            i = 4;
        }
         $('.system_select').find('.system_select_message').remove();
        $('.system_select').append(`<div class="system_select_message">*With the selected format, each player will have **${i}** decks, and will be able to ban a deck of the opponent.*</div>`);
    });

    $('.select_format').find('.options').find('li').on('click',function(){
        let value = $(this).text();
        if (value == 'PvP') {

           $('.hidden_num').hide();
           $('.hidden_num').find('input').attr('name', '');

           $('.nidden_select').show();
           $('.nidden_select').find('select').attr('name', 'Data[pvp]');
        }
        if (value == 'PvE') {

            $('.nidden_select').hide();
            $('.nidden_select').find('select').attr('name', '');

            $('.hidden_num').show();
            $('.hidden_num').find('input').attr('name', 'Data[mythical]');
        }
    });


    $('.select_format').find('select').attr('name', '');

    let input_num  = $('.hidden_num').find('input');
    let select_hidden  = $('.nidden_select').find('select');

    if(input_num.val().trim() == ''){
        input_num.attr('name', '');
        $('.hidden_num').hide();
    }

    let i = $('.nidden_select option').attr("selected");
    if (typeof i === typeof undefined || i === false) {
        select_hidden.attr('name', '');
        $('.nidden_select').hide();
    }

    

});