$(document).ready(function() {
    if ($.matchDate) {
        let date = $.matchDate;
        if (date>0) {

            let timerId = setInterval(function() { 
                date--;
                if (date<1) {
                    clearInterval(timerId);
                }
                showdate(date);
            }, 1000);
        }
    }

    function showdate (date) {
        let h,m,s,newdate;
        h = Math.trunc(date/3600);
        newdate = date-h*3600;
        m = Math.trunc(newdate/60);
        s = newdate-m*60;
        $('.digit_h').html(h);
        $('.digit_m').html(m);
        $('.digit_s').html(s);
    }
});

$(document).ready(function() {
    $('.input_round_match').find('input').keyup(function() {
        let cont_input = $(this).parent('.input_round_match');
        let input = cont_input.find('input');
        if ((input.eq(0).val().length > 0)&&(input.eq(1).val().length > 0)) {
            $('.seve_tur_btn').show();
        }
    });
});


$(document).ready(function() {

    function FSsrf () {
        const fdata = new FormData();
        const csrfParam = $('meta[name="csrf-param"]').attr("content");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        fdata.append(csrfParam,csrfToken); 
        return fdata;
    } 

    function banClass (data,img) {
        const fdata = FSsrf();
        fdata.append('user_match',data[0]);
        fdata.append('user',data[1]);
        fdata.append('cart_class',data[2]);
        let statechange = function() {
            if(this.readyState == 4) {
                let e = JSON.parse(this.responseText);
                if (e.result) {
                    $('.rival').removeClass('activiti_ban');
                    img.addClass('activiti_ban');
                }
            }
        };
        
        const xml = new XMLHttpRequest();
        xml.open('POST','/matches/ban',true);
        xml.onreadystatechange = statechange;
        xml.send(fdata); 
    }


    $('.rival').on('click',function(){
        let result = confirm('To ban the deck of the enemy');
        if (result) {
            let img = $(this);
            let arry_data = img.data('data');
            if (arry_data.length = 3) {
                banClass(arry_data,img);
            } else return false;
        }

    });
});