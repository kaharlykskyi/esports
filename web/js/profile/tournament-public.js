$(document).ready(function(){
    $('.my-tabs').ready(function () {
        ////Javascript to enable link to tab
        let url = document.location.toString();
        if (url.match('#')) {
            $('.champ-nav-list a[href="#' + url.split('#')[1] + '"]').tab('show');
        } 

        let arr = document.location.href.split('/');
        arr = arr[arr.length-1];
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
        $('.system_select').append(`<div class="system_select_message">With the selected format, each player will have ${i} decks, and will be able to ban a deck of the opponent.</div>`);
    });

///////////////////////////////WOW//////////////////////////////////////////
    $('.select_format').find('.options').find('li').on('click',function() {
        let value = $(this).text();
        firstPVP(value);
    });

    function firstPVP(value) {
       if (value == 'PvP') {
            $('.hidden_select1').show();
            $('.terrain').show();
            $('.select_dungeon').remove();
        }
        if (value == 'PvE') {
            $('.hidden_select2').hide();
            $('.hidden_select1').hide();
            $('.terrain').hide();
            let val = $('.sistem_wow').find('option:selected').val();
            if (val == 'Bo1') {
                andeground(2);
            }
            if (val == 'Bo3') {
                andeground(3);
            }
            if (val == 'Bo5') {
                andeground(4);
            }
        } 
    }

    firstPVP($('.select_format').find('option:selected').val());

    $('.terrain').find('.options').find('li').on('click',function() {
        let value = $(this).text();
        let hidden_select1 = $('.hidden_select1');
        let hidden_select2 = $('.hidden_select2');
        if (value == 'Arena') {
            hidden_select2.hide();
            hidden_select2.find('select').prop("disabled", true);
            hidden_select1.show();
            hidden_select1.find('select').prop("disabled", false);
        }
        if (value == 'Battleground') {
            hidden_select1.hide();
            hidden_select1.find('select').prop("disabled", true);
            hidden_select2.show();
            hidden_select2.find('select').prop("disabled", false);
        }
    });

    $('.sistem_wow').find('.options').find('li').on('click',function() {
        let value = $(this).text();
        let val_format = $('.select_format').find('option:selected').val();
        if (val_format == 'PvE') {
            $('.select_dungeon').remove();
            if (value == 'Bo1') {
                andeground(2);
            }
            if (value == 'Bo3') {
                andeground(3);
            }
            if (value == 'Bo5') {
                andeground(4);
            }
        }


    });

    function andeground(int) {
        let html = $('<div  class="conteiner_filed select_dungeon" ><label >Dungeon</label></div>');

        let select = `<select class="form-control" name="Data[dungeon][]" >
            <option value="Freehold" >Freehold</option>
            <option value="Waycrest Manor" >Waycrest Manor</option>
            <option value="Shrine of the Storm" >Shrine of the Storm</option>
            <option value="Temple of Sethraliss" >Temple of Sethraliss</option>
            <option value="Atal'Dazar" >Atal'Dazar</option>
            <option value="Kings' Rest" >Kings' Rest</option>
            <option value="Tol Dagor" >Tol Dagor</option>
            <option value="Siege of Boralus" >Siege of Boralus</option>
            <option value="The Underrot" >The Underrot</option>
            </select>`;

        for (var i = 0; i < int; i++) {
           html.append(select);
        } 
        $('.castom_seting').append(html);
    }







    //$('.select_format').find('select').attr('name', '');

    // let input_num  = $('.hidden_num').find('input');
    // let select_hidden  = $('.nidden_select').find('select');

    // if(input_num.val() == '') {
    //     input_num.attr('name', '');
    //     $('.hidden_num').hide();
    // }

    // let i = $('.nidden_select option').attr("selected");
    // if (typeof i === typeof undefined || i === false) {
    //     select_hidden.attr('name', '');
    //     $('.nidden_select').hide();
    // }


});


$(document).ready( function() {

    $('#search_mod').on('click',function(){
        const data = $('.modal_search').val();
        if (data.trim() == '') return;
        contentClear();
        searchMix(data);
        
    });

    function searchMix (data) {
        const fdata = FSsrf();
        fdata.append('search',data);
        fdata.append('flag',window.data_flag);
        fdata.append('tournament_id',window.data_tournament_id);
        let statechange = function() {
            if(this.readyState == 4) {
                let response = JSON.parse(this.responseText);
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
        xml.open('POST','/ajax/get-teams-players',true);
        xml.onreadystatechange = statechange;
        xml.send(fdata); 
    }


    function contentAdd (response) {
        contentClear();
        contentAddUsers(response.users);
        contentAddTeams(response.teams);
    }

    function contentAddUsers (users) {
        
        $(users).each(function(indx, element){
            let html = `<div class="col-md-12 plashka_user" >
                        <div class="row">
                        <div class="col-sm-2 col-xs-6" style="text-align:center;height:100%;" >
                        <div class="img_logo_modal">
                        <img src="/images/profile/images.png" alt="">
                        </div>
                        </div>
                        <div class="col-sm-6 col-xs-6" >
                        <p>${element.name} @${element.username}</p>
                        </div>
                        <div class="col-sm-4 col-xs-12 box" >
                        <button  class="btn invite_btn" onclick="data_game_sendMess(this)" data-id-user="${element.id}">Invite to the tournament</button>
                        </div>
                        </div>
                        </div>`;
          $('#content_modal').append(html);
        });
    }

    function contentAddTeams (teams) {
        $(teams).each(function(indx, element){
            let html = `<div class="col-md-12 plashka_user plashka_team" style="text-align:center;height:100%;">
                        <div class="row">
                        <div class="col-sm-2 col-xs-6" >
                        <div class="img_logo_modal">
                        <img src="${element.logo}" alt=""></div></div>
                        <div class="col-sm-6 col-xs-6" >
                        <p style="font-size:15px;font-weight:bold;">${element.name}</p>
                        <p>${element.g_name}</p>
                        <p>${Number(element.c_user)} member(s)</p>
                        </div>
                        <div class="col-sm-4 col-xs-12 box" >
                        <button  class="btn invite_btn" onclick="data_game_sendMess(this)" data-id-team="${element.id}" data-id-user="${element.capitan}">Invite to the tournament</button>
                        </div></div></div>`;
          $('#content_modal').append(html);
        });
    }


    window.data_game_sendMess = function (btn) {

        let button = $(btn);
        button.attr("disabled",true);
        let id = button.attr('data-id-user');
        if(typeof button.attr('data-id-team') == "undefined"){
            sendXmlHttp(button,id);
        } else {
            sendXmlHttp(button,id,button.attr('data-id-team'));
        }
    }

    function sendXmlHttp (button,user_id,team_id = false) {
        const fdata = FSsrf();
        fdata.append('user_id',user_id);
        if (team_id) {
            fdata.append('team_id',team_id);
        }
        fdata.append('tournament_id',window.data_tournament_id);

        let statechange = function() {
            if(this.readyState == 4) {
                let response = JSON.parse(this.responseText);
                if (response.sent) {
                    button.parent(".box").html('<p class="sent" >Sent</p>');
                }
            } else {

                button.html('<img style="height: 20px;" src="/images/profile/load.gif">');
            }
        };

        const xml = new XMLHttpRequest();
        xml.onreadystatechange = statechange;
        xml.open('POST','/ajax/invite-tournament',true);
        xml.send(fdata); 
    }

    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    }

    function message (message){
        contentClear();
        let html = `<p style="font-size:19px;" class="modal_message" >${message}</p>`;
        $('#content_modal').append(html);
    }

    function load_img () {
        message ('<img src="/images/profile/load.gif">');
    } 

    function contentClear () {
        $('#content_modal').empty();
    }

    $('#myModal1').on('shown.bs.modal', function (e) {
        window.data_flag = $(e.relatedTarget).attr('data-flag');
        window.data_tournament_id = $(e.relatedTarget).attr('data-tournament-id');
    });

    $('#myModal1').on('hidden.bs.modal',function (e) {
        contentClear();
        $('.modal_search').val('');
    });
});


$(document).ready( function() {                                                                                                                                                                         
    if (!$('#tournamentgrid').hasClass('active')) {

        $('#tournamentgrid').addClass('active');
        $('#tournamentgrid').attr('style','opacity: 0;');
        setTimeout(function(){
            $('#tournamentgrid').removeClass('active');
            $('#tournamentgrid').attr('style','opacity: 1;');
        }, 4000);
    }

    $('.glyphicon-fullscreen').on('click',function(){
        $('.container_iframes').addClass('full-screen');
        $('.glyphicon-resize-small').show();
        $('.glyphicon-fullscreen').hide();
    });
    $('.glyphicon-resize-small').on('click',function(){
        $('.container_iframes').removeClass('full-screen');
        $('.glyphicon-resize-small').hide();
        $('.glyphicon-fullscreen').show();
    });
});



 


