$(document).ready(function () {

    $('.delete').on('click',function(event){
         event.preventDefault();
        if (confirm("Send request to remove the team ?")) {
            const id = $(event.target).attr('data-modeel-id');
            sendMessage(id,event.target);
        } 
    });
    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    }


    function sendMessage (id,btn) {
        const fdata = FSsrf();
        fdata.append('id',id);
        let statechange = function() {
            if(this.readyState == 4) {
                let event = JSON.parse(this.responseText);
                if (event.del) {
                    setTimeout(function(){
                        $(btn).parent(".conteiner_btn").html('<p>Delete request sent</p>');
                }, 1000);
                  
                }    
            }
            if(this.readyState == 1) {
                load_img(btn);
            }
        };
        
        const xml = new XMLHttpRequest();
        
        xml.onreadystatechange = statechange;
        xml.open('POST','/ajax/delite-team',true);
        xml.send(fdata); 
    }

    function load_img(btn){
        $(btn).html('<img style="height: 20px;" src="/images/profile/load.gif">');
    }

});