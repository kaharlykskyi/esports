$(document).ready(function () {
    $('#search_mod').on('click',function(){
        const data = $('.modal_search').val();
        if (data.trim() == '') return;
        contentClear();
        searchuser(data);
        //$('.modal_search').val('');
    });

    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    }

    function searchuser (data) {
        const fdata = FSsrf();
        fdata.append('search',data);
        fdata.append('team',window.data_game_id);
        let statechange = function() {
            if(this.readyState == 4) {
                let e = JSON.parse(this.responseText);
                setTimeout(function(){
                    if (e.not) {
                        message('No results found');
                    } else {
                        contentAdd(e);
                    }
                }, 1000);
            }
            if(this.readyState == 2) {
                load_img();
            }
        };
        
        const xml = new XMLHttpRequest();
        xml.open('POST','/ajax/get-users',true);
        xml.onreadystatechange = statechange;
        xml.send(fdata); 
    }

    function contentClear () {
        $('#content_modal').empty();
    }

    function contentAdd (e) {
        contentClear();
        $(e).each(function(indx, element){
            let box = `<button  class="btn invite_btn" onclick="data_game_sendMess(this)" data-id-user="${element.id}">Invite to the team</button>`;
            if (element.hasOwnProperty('status')) {
                if (element.status == 1) {
                     box = `<p class="sent" >Sent</p>`;
                }
                if (element.status == 3) {
                     box = `<p class="declined">Declined</p>`;
                }
            }
            let html = `<div class="col-md-12 plashka_user" >
                            <div class="row">
                                <div class="col-xs-2" >
                                    <div class="img_logo_modal">
                                        <img src="/images/profile/images.png" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6" >
                                    <p>${element.name} @${element.username}</p>
                                </div>
                                <div class="col-xs-4 box" >
                                    ${box}
                                </div>
                            </div>
                        </div>`;
          $('#content_modal').append(html);
        });
    }

    window.data_game_sendMess = function (btn) {
        let button = $(btn);
        let id = button.attr('data-id-user');
        
        sendXmlHttp(id);
        button.parent(".box").append('<p class="sent" >Sent</p>');
        button.hide();
    };

    function sendXmlHttp (data) {
        const fdata = FSsrf();
        fdata.append('id_user',data);
        fdata.append('id_team',window.data_game_id);
        const xml = new XMLHttpRequest();
        xml.open('POST','/ajax/sent-users',true);
        xml.send(fdata); 
    }

    function message (message){
        contentClear();
        let html = `<p style="font-size:19px;" class="modal_message" >${message}</p>`;
        $('#content_modal').append(html);
    }

    function load_img () {
        message ('<img src="/images/profile/load.gif">');
    } 
    
    $('#myModal1').on('hidden.bs.modal',function (e) {
        contentClear();
        $('.modal_search').val('');
    });
    
    $('#myModal1').on('shown.bs.modal', function (e) {
        window.data_game_id = $(e.relatedTarget).attr('data-game-id');
    });

    $('.my-tabs').ready(function () {
        ////Javascript to enable link to tab
        let url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
        } 
        window.history.pushState(null, null, 'profile');
    });

    $('.game' ).on('click',function(){
        $('.game' ).removeClass("actives");
        $(this).addClass("actives");
    });

});

$(document).ready(function () {

    $('.filter_modal_link').on('click',function(event){
        event.preventDefault();
        $('.filter_modal_content').slideToggle();
    });

    $('#search_mod_team_btn').on('click',function(e){
        const qualit = $('.team_quality').find('.options').find('.selected').attr('data-raw-value');
        const game = $('.team_game').find('.options').find('.selected').attr('data-raw-value');
        const search = $('.modal_search_team').val();
        if (search.trim() == '') return;
        contentClear();
        searcTeams(search,game,qualit);
        //$('.modal_search_team').val('');

    });

    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    }

    function contentClear () {
        $('#content_teams_modal_team').empty();
    }

    function searcTeams(search,game,qualit){
        const fdata = FSsrf();
        fdata.append('search',search);
        fdata.append('game',game);
        fdata.append('qualit',qualit);
        const statechange = function() {
            if(this.readyState == 4) {
                let response = JSON.parse(this.responseText);
                console.log(response);
                setTimeout(function(){
                    if (response.not) {
                        message('No results found');
                    } else {
                        contentAdd(response);
                    }
                }, 1000);
            }
            if(this.readyState == 2) {
                load_img();
            }
        };
        const xml = new XMLHttpRequest();
        xml.open('POST','/ajax/get-teams',true);
        xml.onreadystatechange = statechange;
        xml.send(fdata);
    }

    function load_img () {
        message ('<img src="/images/profile/load.gif">');
    } 

    function message (message){
        contentClear();
        let html = `<p style="font-size:19px;" class="modal_message" >${message}</p>`;
        $('#content_teams_modal_team').append(html);
    }

    function contentAdd (e) {
        contentClear();
        $.each(e,function(indx, element){
            let html = `<div class="col-xs-12 col-md-10 col-md-offset-1 plashka_teams clearfix " >
                                <div class="col-xs-3 block_logo" >
                                    <div class="img_logo_modal_team">
                                        <img src="${element.logo}" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-6" >
                                    <p class="p_name" >${element.name}</p>
                                    <p class="p_gname" >${element.g_name}</p>
                                    <p class="p_user" >${element.c_user} member(s)</p>
                                </div>
                                <div class="col-xs-4 col-md-3 box" >
                                    <p>Participtes in</p>
                                    <p><a href="/tournaments/public/${element.turid}">${element.turname}</a></p>
                                    <p>Position: 3</p>
                                </div>
                        </div>`;
          $('#content_teams_modal_team').append(html);
        });
    }
    $('#myModal2').on('hidden.bs.modal',function (e) {
        contentClear();
        $('.modal_search_team').val('');
    });
});

