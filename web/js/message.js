$(document).ready(function() {

    $('a[href="#activity"]').on('shown.bs.tab', function (e) {
        viewMessage();
    });

    $('.block-add-message').on('click',function(e){
        e.preventDefault();
        if( window.location.pathname == '/profile'){
            $('a[href="#activity"]').tab('show');
        } else {
            window.location = '/profile#activity';
        }

    });

    httpMessage();
    
    setInterval(httpMessage, 15000);

    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    }

    function viewMessage () {
        let fdata = FSsrf();
        $.fdata = fdata;
        let statechange = function() {
            if(this.readyState == 4) {
                if(this.status == 200) {
                    let type = this.getResponseHeader('Content-Type');
                    if (type.indexOf('application/json') + 1) {
                        let response = JSON.parse(this.responseText);
                        if(response.sent !== false ){
                            $('.block-add-message').empty();
                        }
                    }
                } else {
                    console.log( this.status + ': ' + this.statusText ); 
                }
            }
        };
        const xml = new XMLHttpRequest();
        xml.open('POST','/ajax/view-messages',true);
        xml.onreadystatechange = statechange;
        xml.send(fdata); 
    }

    function httpMessage () {
        let fdata = FSsrf();
        $.fdata = fdata;
        let statechange = function() {
            if(this.readyState == 4) {
                if(this.status == 200) {
                    let type = this.getResponseHeader('Content-Type');
                    if (type.indexOf('application/json') + 1) {
                        let response = JSON.parse(this.responseText);
                        if(response.sent !== false && Array.isArray(response)){
                            let count = response.length;
                            if(count > 0){
                                show_notification(count);
                            }
                        }
                    }
                } else {
                    console.log( this.status + ': ' + this.statusText ); 
                }
            }
        };
        const xml = new XMLHttpRequest();
        xml.open('POST','/ajax/check-new-messages',true);
        xml.onreadystatechange = statechange;
        xml.send(fdata); 
    }

    function show_notification(count) {
        let i_text = $(`<i class="badge">${count}</i>`);
        $('.block-add-message').empty();
        $('.block-add-message').append(i_text);
    }

///==============================================================================================//
    window.u3idmessage=0;


    function requestMessage () {
        let fdata = FSsrf();
        $.fdata = fdata;
        let statechange = function() {
            if(this.readyState == 4) {
                if(this.status == 200) {
                    let type = this.getResponseHeader('Content-Type');
                    if (type.indexOf('application/json') + 1) {
                        let response = JSON.parse(this.responseText);
                        wriretMessage (response);
                        console.log(response);
                    }
                } else {
                    console.log( this.status + ': ' + this.statusText ); 
                }
            }
        };
        const xml = new XMLHttpRequest();
        xml.open('POST','/ajax/get-messages',true);
        xml.onreadystatechange = statechange;
        xml.send(fdata); 
    }
    


    function wriretMessage (objMessage) {

        if (typeof objMessage === 'object') {
            if(Array.isArray(objMessage.teams)) {
                wriretTeam (objMessage.teams);
            }

            if(Array.isArray(objMessage.tournaments)) {
                wriretTourMathc(objMessage.tournaments)
            }

            if(Array.isArray(objMessage.matches)) {
                wriretTourMathc(objMessage.matches);
            }
        }

    }
    function schetId (id) {
        if (window.u3idmessage<id) {
            window.u3idmessage = id;
        }
    }

    function getDate(created_at) {
            let date = new Date(created_at*1000);
            let months = ['null','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            let month = months[date.getMonth()];

            let day = date.getDate();
            if(day < 10){
                day ='0'+ day;
            }
            return `CREATED ${day} OF ${month}, ${date.getFullYear()}`;
    }

    function wriretTeam (obj) { 
        let content = $('#teams-tab');
        $.map(obj,function (team, index) {
            let sender_ing = "/images/profile/user_man.jpg";            
            if(typeof team.senders === 'object') {
                if (team.senders.logo) {
                    sender_ing = team.senders.logo;
                }
            }

            let html = `<div class="item">
                        <div class="title-mes clearfix" >
                        <div class="avatar"><img src="${sender_ing}" alt="timeline-goal">
                        </div><div class="date-n">${getDate(team.created_at)}</div></div>
                        <div class="info"><div class="name">${team.title}</div>
                        <div>${team.text}</div>
                        </div></div>`;
            content.append(html);
        });

    }

    function wriretTourMathc (obj) {
        let content = $('#tournaments-tab');
        $.map(obj,function (tournament, index) {
            let html = `<div class="item">
                        <div class="title-mes clearfix" >
                        <div class="date-n">${getDate(tournament.created_at)}</div></div>
                        <div class="info"><div class="name">${tournament.title}</div>
                        <div>${tournament.text}</div>
                        </div></div>`;
            content.append(html);
        });

    }



    requestMessage();

});