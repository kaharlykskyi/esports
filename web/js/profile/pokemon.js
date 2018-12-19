 
$(document).ready(function(){
    let responsPokimon;
    let arryPokemons = {};
    let strengPokemon = '';
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
        $('.container_selected').html('');
        $('.block_form').slideUp();
        $('.massage_pokemons').hide();
        arryPokemons = {};
        const data = $('.pokemon-input').val();
        if (data.trim() == '') return;
        splitStreng(data);
    });

    function splitStreng(data) {
       strengPokemon = data;
       let arryP = [];
       let reg = /[A-Z]+ ?-?[A-Z]+ @/ig;
       data = data.match(reg);
       if(!Array.isArray(data)){
            console.log(data);
            return false;
       }
        for (let i = data.length - 1; i >= 0; i--) {
           arryP[i] = data[i].replace(/@/gm,'').trim(' ').replace(' ','-');
        }

        if (arryP.length == 6) {
            for (let i = arryP.length - 1; i >= 0; i--) {
                searchMass(arryP[i]);
            }
        }
        if (Object.keys(arryPokemons).length == 6) {
            for (let i in arryPokemons) {
                contentWriteSelected(arryPokemons[i]);
            }
            $('.block_form').slideDown();
        } else {
            $('.massage_pokemons').show();
        }

    }

    function searchMass (data) {
        data = data.toLowerCase(); 
        for (let key in responsPokimon) {
            if(key == data) {
                let objectP = responsPokimon[key];
                objectP.name = key;
                arryPokemons[objectP.id] = objectP;
            }
        }
    }

    function contentWriteSelected (data) {

        let container = $('.container_selected');
        let block = `<div class="block_pokemon" data-pokimon="${data.id}" >
                     <img src='/images/game/${data.icons['.']}.png'  >${data.name}</div>`;
        container.append(block);
    }

    $('.btn-save').on('click',function(event) {
        let json,arry_pok = [];
       if (Object.keys(arryPokemons).length != 6) {
            event.preventDefault();
            return false;
        }
        arry_pok[0] = strengPokemon;
        arry_pok[1] = arryPokemons;
        json = JSON.stringify(arry_pok);
        $('.input_class_cards').val(json);
        return true;
        event.preventDefault();
        
    });
    
});
