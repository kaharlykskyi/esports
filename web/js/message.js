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

});