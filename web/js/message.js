$(document).ready(function() {

    window.u3created_message = 0;

    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    }

    function requestMessage () {
        let fdata = FSsrf();
        fdata.append('time', window.u3created_message);
        let statechange = function() {
            if(this.readyState == 4) {
                if(this.status == 200) {
                    let type = this.getResponseHeader('Content-Type');
                    if (type.indexOf('application/json') + 1) {
                        let response = JSON.parse(this.responseText);
                        wriretMessage (response);
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

    function viewMessage (id) {
        let fdata = FSsrf();
        fdata.append('id', id);
        const xml = new XMLHttpRequest();
        xml.open('POST','/ajax/view-messages',true);
        xml.send(fdata); 
    }



    function wriretMessage (objMessage) {

        if (typeof objMessage === 'object') {

            let allarry = [];
            if(Array.isArray(objMessage.teams)) {
               
                if (window.u3created_message) {
                    objMessage.teams.reverse();
                }
                wriretTeam (objMessage.teams);
                allarry = allarry.concat(objMessage.teams);
            }

            if(Array.isArray(objMessage.tournaments)) {
                if (window.u3created_message) {
                    objMessage.tournaments.reverse();
                }
                wriretTourMathc(objMessage.tournaments,$('#tournaments-tab'));
                allarry = allarry.concat(objMessage.tournaments);
            }

            if(Array.isArray(objMessage.matches)) {
                if (window.u3created_message) {
                    objMessage.matches.reverse();
                }
                wriretTourMathc(objMessage.matches,$('#matches-tab'));
                 allarry = allarry.concat(objMessage.matches);
            }

            $.map(allarry,function (alla, index) {
                schetСreated(alla.created_at);
            });   
        }
    }

    function schetСreated (created_at) {
        if (window.u3created_message < created_at) {
            window.u3created_message = created_at;
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

    function wriretTeam (obj, reverse) { 
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
            
            if (window.u3created_message) {
                content.prepend(html);
                
            } else {
                content.append(html);
               
            }

            if(!team.view_status) {
                let html = `<div class="info">
                         <div class="name">${team.title}</div>
                         <div>${team.text}</div>
                         </div>`;
                sentPushMs(html,team.id);
            }
        });
    }

    function wriretTourMathc (obj, content) {
        
        $.map(obj,function (tournament, index) {
            schetСreated(tournament.created_at);
            let html = `<div class="item">
                        <div class="title-mes clearfix" >
                        <div class="date-n">${getDate(tournament.created_at)}</div></div>
                        <div class="info"><div class="name">${tournament.title}</div>
                        <div>${tournament.text}</div>
                        </div></div>`;
            if (window.u3created_message) {
                content.prepend(html);
            } else {
                content.append(html);
            }
            
            if(!tournament.view_status) {
                let html = `<div class="info">
                         <div class="name">${tournament.title}</div>
                         <div>${tournament.text}</div>
                         </div>`;
                sentPushMs(html,tournament.id);
            }
        });
    }

    function sentPushMs(html,id) {
        new Noty({
            text: html,
            theme: 'relax',
            type: 'info',
            animation: {
                open: 'animated bounceInRight', 
                close: 'animated bounceOutRight' 
            },
            callbacks: {
                afterClose: function() {viewMessage (id)}
            }
        }).show();
    }
    requestMessage();
    setInterval(requestMessage, 10000);


});
