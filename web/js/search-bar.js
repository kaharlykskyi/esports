$(document).ready(function(){
    $.myVarContainer = {};


    $('#search-bar').on('click',function(){

        //$('.s_layouts_snapWrapper').show();
        $('.s_layouts_snapWrapper').addClass('visible-search');
        $('body').attr('style','overflow: hidden;');
        $('.wrap_search_fon').addClass('wrap_blur');
    });

    $('.s_layouts_snapClose').on('click',function(){


        $('.s_layouts_snapWrapper').removeClass('visible-search');
        //$('.s_layouts_snapWrapper').hide();
        $('body').attr('style','overflow: auto;');
        $('.wrap_search_fon').removeClass('wrap_blur');




        menuSerchHide();
        contentClear();
        messageClean();
        $('.s_layouts_snapInput').val('');
    });


    $('.s_layouts_snapTab').on('click',function(event){

        let elementJQry = $(event.target);
        $('.s_layouts_snapHeaderWrapper').find('.s_layouts_snapTab').removeClass('active');
        elementJQry.addClass('active');
        console.log(elementJQry.attr('data-search-menu'));
        let i = elementJQry.attr('data-search-menu');
        contentClear();
        load_imgShow();
        setTimeout(function(){
            load_imgHiden();
            switch (i) {
                case '0':
                    addcontent($.myVarContainer.contentSearch);
                    break;
                case '1':
                    addContentUser($.myVarContainer.contentSearch.users);
                    break;
                case '2':
                    addContentTeams($.myVarContainer.contentSearch.teams);
                    break;
                case '3':
                    alert( 'Перебор' );
                    break;
            }
        },500);
    })


    $('.s_layouts_snapInput').keypress(function(eventObject){
        
        clearTimeout($.myVarContainer.tamerIntervalMy);
        $.myVarContainer.tamerIntervalMy = setTimeout(function(){
                let input = $(eventObject.target).val();
                contentClear ();
                searcTeams(input);          
        }, 1000);

    });


    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    }


    function searcTeams(input){
        const fdata = FSsrf();
        fdata.append('input',input);
        const statechange = function() {
            if(this.readyState == 4) {
                let response = JSON.parse(this.responseText);
                $.myVarContainer.contentSearch = response;
                setTimeout(function(){
                    if (response.not) {
                        message("Sorry, we can't find what you're looking for. Give it another whirl.");
                    } else {
                        //console.log(response);
                        addcontent(response); 
                    }
                }, 1000);
            }
            if(this.readyState == 1) {
                menuSerchHide();
                load_imgShow();
            }
        };
        const xml = new XMLHttpRequest();
        xml.onreadystatechange = statechange;
        xml.open('POST','/ajax/search-bar',true);
        xml.send(fdata);
    }

    function addcontent (response) {
        contentClear();
        load_imgHiden();
        menuSerchShow(response);
        addContentUser(response.users);
        addContentTeams(response.teams);
    }


    function addContentUser(users) {
        $.each(users ,function (indx, element) {
            console.log(element);
            let teamsl = '';
            $(element.teams).each(function (indx, element) {
                teamsl +=` <a href="/teams/public/${element.id}">${element.name}</a>`;
            });

            let content = `<div class="col-sm-6 col-md-4">
                                        <div class="blok_search_username">
                                            <div class="col-xs-4 img_cont_search clearfix">
                                                <img src="/images/profile/images.png" alt="">
                                            </div>
                                            <div class="col-xs-8">
                                                <p class="username">${element.name}</p>
                                                <p>Registration date : ${element.created_at}</p>
                                                <p>Teams:</p>
                                                <p class="list_teams">${teamsl}</p>
                                            </div>
                                        </div>
                                    </div>`;
            $('.container_search_modal').append(content);
        });      
    }

    function addContentTeams(teams) {
        $(teams).each( function (indx, element) {
            let date = new Date(element.created_at*1000);
            let month = date.getMonth();
            if(date.getMonth()<10){
                month ='0'+ date.getMonth();
            }
            let content = `<div class="col-sm-6 col-md-4">
                                        <div class="blok_search_teams">
                                            <div class="col-xs-4 img_cont_search clearfix">
                                                <a href="/teams/public/${element.id}"><img src="${element.logo}" ></a>
                                            </div>
                                            <div class="col-xs-8">
                                                <p class="teams"><a href="/teams/public/${element.id}">${element.name}</a></p>
                                                <p>Registration date : ${date.getFullYear()}-${month}-${date.getDate()}</p>
                                                <p>Game: ${element.g_name}</p>
                                                <p class="list_teams">Members ${element.c_user}</p>
                                            </div>
                                        </div>
                                    </div>`;
            $('.container_search_modal').append(content);
        });      
    }

    function addContentToutnaments (toutnaments) {
        alert();

    }


    function contentClear () {
        $('.container_search_modal').empty();
    }

    function message (message){
        contentClear();
        load_imgHiden();
        $('.s_layouts_snapMessageWrapper').find('.message_search').html(message);
    }

    function messageClean(){
        $('.s_layouts_snapMessageWrapper').find('.message_search').empty();
    }

    function load_imgShow () {
        messageClean();
        $('.s_layouts_snapMessageWrapper').find('.img_downloder').show();
    } 

    function load_imgHiden () {
        $('.s_layouts_snapMessageWrapper').find('.img_downloder').hide();
    } 

    function menuSerchShow (element) {
        let activ;
        let menu = $('.s_layouts_snapHeaderWrapper');


        if(element.teams.length != 0){
            activ = 2;
            menu.find('.teams_snapTab').show();
        }

        if(element.users.length != 0){
            activ = 1;
            menu.find('.users_snapTab').show();
        }

        if((element.teams.length != 0) && (element.users.length != 0)){
            activ = 0;
            menu.find('.all_snapTab').show();
        }
        menu.find('.s_layouts_snapTab').removeClass('active');
        menu.find('.s_layouts_snapTab').eq(activ).addClass('active');
       
    }

    function menuSerchHide () {
        $('.s_layouts_snapHeaderWrapper').find('.s_layouts_snapTab').hide();
    }


});