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
        $(".terrain").find('.trigger').html('Arena');
       if (value == 'PvP') {
            $('.hidden_select1').find('select').prop("disabled", false);
            $('.hidden_select1').show();
            $('.terrain').find('select').prop("disabled", false);
            $('.terrain').show();
            $('.select_dungeon').remove();
        }
        if (value == 'PvE') {
            
            $('.hidden_select2').hide();
            $('.hidden_select1').hide();
            $('.hidden_select1').find('select').prop("disabled", true);
            $('.hidden_select2').find('select').prop("disabled", true);
            $('.terrain').find('select').prop("disabled", true);
            $('.terrain').hide();

            if ($.wowData.hasOwnProperty('dungeon')) {
                if (Array.isArray($.wowData.dungeon)) {
                    andeground(0,$.wowData.dungeon);
                    $.wowData = false;
                } 
            } else {
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

    function andeground(int,selected = false) {
        let html = $('<div  class="conteiner_filed select_dungeon" ><label >Dungeon</label></div>');
        let arry_dungeon = ["Freehold","Waycrest Manor","Shrine of the Storm",
                            "Temple of Sethraliss","Atal'Dazar","Kings' Rest",
                            "Tol Dagor","Siege of Boralus","The Underrot"];
        if (!selected) {
            for (var i = 0; i < int; i++) {
                let select = $('<select class="form-control" name="Data[dungeon][]" ></select>');
                let option = '';

                for (var a = arry_dungeon.length - 1; a >= 0; a--) {
                    option += `<option value="${arry_dungeon[a]}" >${arry_dungeon[a]}</option>`
                }
                select.append(option);
                html.append(select);
            } 
        } else if (Array.isArray(selected)) {
                for (var i = 0; i < selected.length; i++) {
                let select = $('<select class="form-control" name="Data[dungeon][]" ></select>');
                let option = '';
                    for (var a = arry_dungeon.length - 1; a >= 0; a--) {
                        let vstavka = '';
                        if (selected[i] == arry_dungeon[a]) {
                            vstavka = 'selected';
                        }
                        option += `<option value="${arry_dungeon[a]}" ${vstavka} >${arry_dungeon[a]}</option>`
                    }
                select.append(option);
                html.append(select);
            }
        }
        $('.castom_seting').append(html);
    }

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

    $('.champ-nav-list a').on('shown.bs.tab', function (e) {

        if($(e.target).attr('class')=='tournamentgrid') {
            let container_iframe = $('#container_iframe');
            if (!container_iframe.hasClass("newsIframe")) {
                let html_ifreme = `<iframe src ="${container_iframe.data('href')}" id="ifrem_cup" ></iframe>`;
                container_iframe.append(html_ifreme);
                container_iframe.append('<img src="/images/profile/load.gif" class="download_iframe" >')
                container_iframe.attr('style','opacity: 5;');
                setTimeout( function() {
                   $('.download_iframe').remove();
                   container_iframe.attr('style','opacity: 1;');
                },2000);
                container_iframe.addClass("newsIframe");
            }
        }

    });
});

$(document).ready( function() { 

    $('.resurses-btn-show').on('click',function(e){
        e.preventDefault();
        let container = $(this).parent('.resurses-user-container').find('.resurses-user-game');
        $(this).find('span').toggleClass('glyphicon-chevron-down');
        container.slideToggle();
    });

});


$(document).ready( function() { 
    $('.overwatch-rating  select option').map(function(index, elem){
        let srav = 500+$.ratingData;
        let newelem = $(elem);
        if (newelem.val() > srav) {
            newelem.remove();
        }

    });
     $('.overwatch-rating  select').trigger('update.fs');
    //.prop('disabled', true );
    if ($('.is-overwatch').is(':checked')) {
        $('.overwatch-rating').slideDown();
        $('.overwatch-rating  select').prop('disabled', false );
    } else {
        $('.overwatch-rating').slideUp();
        $('.overwatch-rating  select').prop('disabled', true );
    }


    $('.is-overwatch').on('click', function(e) {
        if ($(e.target).is(':checked')) {
            $('.overwatch-rating').slideDown();
            $('.overwatch-rating  select').prop('disabled', false );
        } else {
            $('.overwatch-rating').slideUp();
            $('.overwatch-rating  select').prop('disabled', true );
        }
    });

    $('.btn-link-buf').on('click',function(e){
        
        let range = document.createRange();
        range.selectNode(document.getElementById('link-tournaments')); 
        window.getSelection().addRange(range); 
        try { 
            document.execCommand('copy'); 
        } catch(err) { 
            console.log('Can`t copy, boss'); 
        } 
        window.getSelection().removeAllRanges();

    });

});



 


