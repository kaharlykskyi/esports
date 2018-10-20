
$(document).ready( function() {
      
    let doubleEliminationData;

    if (typeof $.comandTeams != "undefined") {
       doubleEliminationData = {
        teams : $.comandTeams.teams,
        results : $.comandTeams.results
      };
    } else {
        doubleEliminationData = {};
    }

    function render_fn(container, data, score, state) {
        let name;
        if(null  != data && data.hasOwnProperty('name')){
           // name = data.name;
            name = '<img class="grid_logo" src="'+data.logo+'" /> ';
            name +=  data.name;

        } else {
            name = 'BYE';
        }
        container.append(name);
    }


    if ($.tournament_duble) {
        $.dataObj = {
        teamWidth: 120,
        init:doubleEliminationData,
        skipSecondaryFinal: true,
        skipConsolationRound: true,
            centerConnectors: true,
            decorator: {
                edit: function edit_fn(){} , 
                render: render_fn
            }
        };
    } else {
        $.dataObj = {
        teamWidth: 120,
        init:doubleEliminationData,
         //skipSecondaryFinal: true,
        skipConsolationRound: true,
            centerConnectors: true,
            decorator: {
                edit: function edit_fn(){} , 
                render: render_fn
            }
        };
    }

        
    $('#minimal').bracket($.dataObj);
});