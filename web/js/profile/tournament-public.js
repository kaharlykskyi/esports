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
        $('.system_select').append(`<div class="system_select_message">With the selected format, each player will have ${i} decks, and will be able to ban a deck of the opponent.</div>`);
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

    if(input_num.val() == ''){
        input_num.attr('name', '');
        $('.hidden_num').hide();
    }

    let i = $('.nidden_select option').attr("selected");
    if (typeof i === typeof undefined || i === false) {
        select_hidden.attr('name', '');
        $('.nidden_select').hide();
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
                                <div class="col-xs-2" >
                                    <div class="img_logo_modal">
                                        <img src="/images/profile/images.png" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6" >
                                    <p>${element.name} @${element.username}</p>
                                </div>
                                <div class="col-xs-4 box" >
                                    <button  class="btn invite_btn" onclick="data_game_sendMess(this)" data-id-user="${element.id}">Invite to the tournament</button>
                                </div>
                            </div>
                        </div>`;
          $('#content_modal').append(html);
        });
    }

    function contentAddTeams (teams) {
        $(teams).each(function(indx, element){
            let html = `<div class="col-md-12 plashka_user plashka_team" >
                            <div class="row">
                                <div class="col-xs-2" >
                                    <div class="img_logo_modal">
                                        <img src="${element.logo}" alt="">
                                    </div>
                                </div>
                                <div class="col-xs-6" >
                                    <p style="font-size:15px;font-weight:bold;">${element.name}</p>
                                    <p>${element.g_name}</p>
                                    <p>${Number(element.c_user)} member(s)</p>
                                </div>
                                <div class="col-xs-4 box" >
                                    <button  class="btn invite_btn" onclick="data_game_sendMess(this)" data-id-team="${element.id}" data-id-user="${element.capitan}">Invite to the tournament</button>
                                </div>
                            </div>
                        </div>`;
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



//$(document).ready( function() {

//     let response = Object.create($.comandTeams);
//     let label = $('.jQBracket').find('.int1').find('.label');


//     $('#btn_randomset').on('click',function (e) {
//         label.each(function(index,element){
//             $(element).html($.comandTeams[index].name);
//         });
//     });

//     $('#myModal2').on('shown.bs.modal', function (e) {
//         window.data_int = $(e.relatedTarget).attr('data-int');
//         $.each(response,function(index, value){
//             let btn = $(`<button class="btn team_name" data-geme-id="${index}" >${value.name}</button>`);
//             btn.on('click',function(e){
//                 let id = $(e.target).attr('data-geme-id');
//                 $('#myModal2').modal('toggle');
//                 label.eq(window.data_int).html(response[id].name);
//                 response.splice(id, 1);

//             });
//             $("#content_get_team").append(btn);

//         });
       
//     });

//     $('#myModal2').on('hidden.bs.modal',function (e) {
//         $('#content_get_team').empty();
//     });
// //////////////////////////////////////////////////////////
//     label.each(function(index,element){
//         $(element).html(`<a href="#myModal2" class="btn btn-teams" data-toggle="modal" data-int="${index}" >+</a>`);
//     });


 
$(document).ready( function() {






var doubleEliminationData = {
    teams : $.comandTeams,
      // ["Team 1", "Team 2"],  first matchup 
      // ["Team 3", "Team 4"]  /* second matchup */
    
    results : [
      //[[1,2], [3,4]],       /* first round */
      //[[4,6], [2,1]]        /* second round */
   ],
  };
 


var acData = ["kr:MC", "ca:HuK", "se:Naniwa", "pe:Fenix",
              "us:IdrA", "tw:Sen", "fi:Naama"];
$(function() {
    $('#minimal').bracket({
      init: doubleEliminationData,
      save: function(e){console.log(e);},
      //decorator: { edit: acEditFn,render: acRenderFn}
  });
});



});
