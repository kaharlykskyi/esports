$(document).ready(function () {

    $('.format_campions').on('click', function(event){
        let elementJq = $(this);
        let id = elementJq.attr('data-farmat');

        if(id == 0){
            $('#elimination').slideToggle();
            return;
        }
        if(id != 0){
            $('.format_campions').removeClass('active_campions');
            elementJq.addClass('active_campions');
           $('.radiolist_elimination').find('label').eq(id-1).click();
          //$('.radiolist_elimination').find('input[type=radio]')
        }
    });

});