$(document).ready(function(){
    if ($.matchDate) {
        let date = $.matchDate;
        let timerId = setInterval(function() { 
            date--;
            if (date<0) {
                clearInterval(timerId);
            }
            showdate(date);
        }, 1000);

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