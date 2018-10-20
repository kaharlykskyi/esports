
$(document).ready(function(){
    let responsPokimon;
    let arryPokemons = [];
    function searchMix () {
        let statechange = function() {
            if(this.readyState == 4) {
                let json = JSON.parse(this.responseText);
                responsPokimon = json.index.pokemon;
            }
        };
        const xml = new XMLHttpRequest();
        xml.open('GET','/js/profile/icons-index.json',true);
        xml.onreadystatechange = statechange;
        xml.send(); 
    }
    searchMix();

    $('.find-pokemon').on('click',function () {
        $('.container_pokemons').html('');
        $('.block_form').slideUp();
        arryPokemons = [];
        const data = $('.pokemon-input').val();
        if (data.trim() == '') return;
        searchMass(data);
    });

    function searchMass (data) {
        data = data.toLowerCase();
        
        for (let key in responsPokimon) {
            if(key.indexOf(data) + 1) {
                let objectP = responsPokimon[key];
                objectP.name = key;
                arryPokemons.push(objectP);
            }
        }
        contentWrite(arryPokemons);
    }

    function contentWrite (data) {
        
        let container = $('.container_pokemons');
        let i = data.length - 1;
        if (i > 20) {
            i = 20;
        }
        for ( i ;i >= 0; i--) {
            let block = `<div class="block_pokemon" data-pokimon="${i}" >
                        <img src='/images/game/${data[i].icons['.']}.png'  >${data[i].name}</div>`;
            block = $(block).on('click',clickBlock);
            container.append(block);
        }
    }

    function clickBlock() {
        $('.block_card_active').removeClass('block_card_active');
        $(this).addClass('block_card_active');
        $('.block_form').slideDown();
    }

    $('.btn-save').on('click',function(event) {
        let json,index;
        index = $('.block_card_active').data('pokimon');
        if (typeof arryPokemons[index] !== "undefined") {
            json = JSON.stringify(arryPokemons[index]);
            $('.input_class_cards').val(json);
            return true;
        }
        event.preventDefault();
    });
    
});
