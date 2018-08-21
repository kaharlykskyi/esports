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


    $('.conteiner_filed').find('').on('change',function(),{

    })
});