 
$(document).ready(function(){
    let responsPokimon;
    let arryPokemons = [];
    let selectedPokemons = {};
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
                arryPokemons[objectP.id] = objectP;
            }
        }
        contentWrite(arryPokemons);
    }

    function contentWrite (data) {
        
        let container = $('.container_pokemons');
        let count = data.length - 1;
        if (count > 20) {
            count = 20;
        }
        let a = 0;
        for (let i in data) {
            if (count == a) { return; }
            a++;
            let block = `<div class="block_pokemon" data-pokimon="${data[i].id}" >
                         <img src='/images/game/${data[i].icons['.']}.png'  >${data[i].name}</div>`;
            block = $(block).on('click',clickBlock);
            container.append(block);
        }
    }

    function clickBlock() {

        let index = $(this).data('pokimon');
        if (typeof arryPokemons[index] !== "undefined") {
            if (typeof selectedPokemons[index] == "undefined" && Object.keys(selectedPokemons).length<6) {
                selectedPokemons[arryPokemons[index].id] = arryPokemons[index];
                contentWriteSelected(arryPokemons[index]);
                if (Object.keys(selectedPokemons).length == 6) {
                    $('.block_form').slideDown();
                }
            }
        }
    }

    function contentWriteSelected (data) {
        
        let container = $('.container_selected');
        let block = `<div class="block_pokemon" data-pokimon="${data.id}" >
                    <img src='/images/game/${data.icons['.']}.png'  >${data.name}</div>`;
        let span_rem = `<span class="glyphicon glyphicon-remove"
                        style='color:#cc4040;top: 3px;margin-left:5px;'></span>`;
        span_rem = $(span_rem).on('click',dellBlock);
        block = $(block).append(span_rem);
        container.append(block);
    }

    function dellBlock() {
        let block = $(this).parent('.block_pokemon');
        let id = block.data('pokimon');
        block.remove();
        delete selectedPokemons[id];
        $('.block_form').slideUp();
    }

    $('.btn-save').on('click',function(event) {
        let json,arry_pok;
       if (Object.keys(selectedPokemons).length != 6) {
            event.preventDefault();
            return false;
        }
        json = JSON.stringify(selectedPokemons);
        $('.input_class_cards').val(json);
        console.log(json);
        return true;
        event.preventDefault();
        
    });
    
});
