$(document).ready(function() {
    let objectData;
    function searchMix (data) {
        $.ajax({
            type: "GET",
            url: 'https://raider.io/api/v1/characters/profile',
            data:data,
            success: function(event){
                objectData = event;
                infoPersonaWrite(objectData);
                if (objectData.hasOwnProperty('name')) {
                    $('.block_forms').show();
                }
            }
        });
    }

    $('.btn-detals').on('click',function(){
        $('.block_forms').hide();
        $('.content_profile').find('ul').html('');
        objectData = {};
        let region = $('.string-region').find('option:selected').val().trim();
        let realm = $('.string-realm').val().trim();
        let name = $('.string-name').val().trim();
        let fields = $('.string-fields').val().trim();

        if ((region != '')&&(realm != '')&&(name != '')) {
            var data = {
                region:region,//'eu', 
                realm:realm,//'sanguino', 
                name:name//'phoebina'
               // fields://'mythic_plus_best_runs'
            };
        } else {
            return false;
        }

        if (fields != '') {
            data.fields = fields;
        }
        searchMix(data);
    });

    function infoPersonaWrite (object) {
        let content = $('.content_profile').find('ul');

        let html =`
                <li class="avatar" ><img src="${object.thumbnail_url}" ></li>
                <li><b>Name:</b> ${object.name}</li>
                <li><b>Race:</b> ${object.race}</li>
                <li><b>Class:</b> ${object.class}</li>
                <li><b>Gender:</b> ${object.gender}</li>
                <li><b>Faction:</b> ${object.faction}</li>
                <li><b>Region:</b> ${object.region}</li>
                <li><b>Realm:</b> ${object.realm}</li>
                <li><b>Profile Url:</b> <a href="${object.profile_url}">${object.profile_url}</a></li>`;
        content.html(html);
    }

    $('.btn-save').on('click',function(){
        json = JSON.stringify(objectData);
        $('.input_class_detalis').val(json);
    });




});