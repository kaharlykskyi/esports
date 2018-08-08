$(document).ready(function () {
    $('#search_mod').on('click',function(){
        const data = $('.modal_search').val();
        if (data.trim() == '') return;
        contentClear();
        searchuser(data);
        $('.modal_search').val('');
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
                let result = this.responseText;
                if (result.length == 2) {
                    message('No results found');
                    return;
                }
                    console.log(result.length);
                    console.log(result);
                    let e = JSON.parse(this.responseText);
                    load_img();
                    setTimeout('setTime(obj)', 1000);
                    //contentAdd(e);
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
            let html = `<div class="col-md-12 plashka_user" >
                        <div class="row">
                            <div class="col-md-3 " >
                                <div class="img_logo_modal">
                                    <img src="/images/profile/images.png" alt="">
                                </div>
                            </div>
                            <div class="col-md-5 " >
                                <p>${element.name}</p>
                            </div>
                            <div class="col-md-4 " >
                                <button class="btn  invite_btn" data-id-user="${element.id}">Invite to the team</button>
                            </div>
                        </div>
                    </div>`;
          $('#content_modal').append(html);
          $('.invite_btn').on( function(){

          });
        });
    }

    function message (message){
        let html = `<p style="font-size:19px;" class="modal_message" >${message}</p>`;
        $('#content_modal').append(html);
    }


    function load_img () {
        message ('<img src="/images/profile/load.gif">');
    } 
    

    
    $('#myModal1').on('shown.bs.modal', function (e) {
        window.data_game_id = $(e.relatedTarget).attr('data-game-id');
    })

});

