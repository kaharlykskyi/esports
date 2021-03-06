$(document).ready(function(){

    $('.s_layouts_snapWrapper').addClass('s_layouts_snapWrapper_add');
    $.myVarContainer = {};

    $('#search-bar').on('click',function(){

        $('.s_layouts_snapWrapper').addClass('visible-search');
        $('body').attr('style','overflow: hidden;');
        $('.wrap_search_fon').addClass('wrap_blur');
    });

    $('.s_layouts_snapClose').on('click',function(){

        $('.s_layouts_snapWrapper').removeClass('visible-search');
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
                    addContentTturnaments($.myVarContainer.contentSearch.tournaments);
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
                if (this.status ==200) {
                    let response = JSON.parse(this.responseText);
                    $.myVarContainer.contentSearch = response;
                    setTimeout(function(){
                        if (response.not) {
                            message($.language_n18.sorry);
                        } else {
                            //console.log(response);
                            addcontent(response); 
                        }
                    }, 1000);
                }
                if (this.status != 200) {
                    message("Error Server");
                }
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
        addContentTturnaments(response.tournaments);
    }


    function addContentUser(users) {
        $.each(users ,function (indx, element) {
            let teamsl = '';
            $(element.teams).each(function (indx, element) {
                teamsl +=` <a href="/teams/${element.slug}">${element.name}</a>`;
            });
            if (!element.logo) {
                element.logo = '/images/profile/user_man.jpg';
            }
            let content = `<div class="col-sm-6 col-md-4">
                           <div class="blok_search_username">
                           <div class="col-xs-4 img_cont_search clearfix">
                            <a href="/user/public/${element.id}">
                            <img src="${element.logo}" alt="logo"></a></div>
                            <div class="col-xs-8">
                            <p class="username"><a href="/user/public/${element.id}">
                            ${element.name}</a></p>
                            <p>${$.language_n18.registration}: ${element.created_at}</p>
                            <p>${$.language_n18.teams}:</p><p class="list_teams">${teamsl}</p>
                            </div></div></div>`;
            $('.container_search_modal').append(content);
        });      
    }

    function addContentTeams(teams) {
        $(teams).each( function (indx, element) {
            let date = new Date(element.created_at*1000);
            let month = date.getMonth();
            if(month < 10){
                month ='0'+ month;
            }
            let day = date.getDate();
            if(day < 10){
                day ='0'+ day;
            }
            let content = `<div class="col-sm-6 col-md-4">
                            <div class="blok_search_teams">
                            <div class="col-xs-4 img_cont_search clearfix">
                            <a href="/teams/${element.slug}"><img src="${element.logo}" ></a>
                            </div><div class="col-xs-8">
                            <p class="teams"><a href="/teams/${element.slug}">${element.name}</a></p>
                            <p>${$.language_n18.registration} : ${date.getFullYear()}-${month}-${day}</p>
                            <p>${$.language_n18.game}: ${element.g_name}</p>
                            <p class="list_teams">${$.language_n18.members} ${element.c_user}</p>
                            </div></div></div>`;
            $('.container_search_modal').append(content);
        });      
    }

    function addContentTturnaments (tournaments) {
        //console.log(tournaments);
        $(tournaments).each( function (indx, element) {
            let format ="";
            switch (element.format) {
                case '1':
                format = "Cup (Single elimination)";
                break;
                case '2':
                format = "Cup (Duble elimination)";
                break;
                case '3':
                format = "League (Regular)";
                break;
                case '4':
                format = "League (Regular + Playoff)";
                break;
                case '5':
                format = "League (Group + Playoff)";
                break;           
            }
            let content = `<div class="col-sm-6 col-md-4">
                            <div class="blok_search_teams tournaments_block">
                            <div class="col-xs-4 img_cont_search clearfix">
                            <a href="/toutnaments/public/${element.id}"><img src="/images/profile/images.png" alt=""></a>
                            </div><div class="col-xs-8">
                            <p class="tournaments"><a href="/tournaments/public/${element.id}">${element.name}</a></p>
                            <p>${$.language_n18.game}: ${element.g_name}</p>
                            <p>${$.language_n18.start}: ${element.start_date.substr(0, 10)}</p>
                            <p>${$.language_n18.teams}: ${element.c_teams}</p>
                            <p>Format: ${format}</p></div></div></div>`;

            $('.container_search_modal').append(content);
        });      
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

        if(element.tournaments.length != 0){
            activ = 3;
            menu.find('.tournaments_snapTab').show();
        }

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