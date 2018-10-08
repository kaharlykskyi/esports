$(document).ready(function() {

    function searchMix () {
        let statechange = function() {
            if(this.readyState == 4) {
                responsBase = JSON.parse(this.responseText);
            }
        };
        const xml = new XMLHttpRequest();
        xml.open('GET','https://api.hearthstonejson.com/v1/latest/enUS/cards.collectible.json',true);
        xml.onreadystatechange = statechange;
        xml.send(); 
    }


    

});