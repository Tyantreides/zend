$( document ).ready(function() {
    //AddEvent Form Functions
    $("#partyassembler a").each(function(){
        $( this ).click(function() {
            //alert( "click" );
            var choosedroleelement = "#choosedrole_"+$(this).data("for");
            var pfeilspan = "&nbsp;<span class=\"caret\"></span>";
            $(choosedroleelement).data("roleid", $(this).data("roleid"));
            $(choosedroleelement).html($(this).html()+pfeilspan);
        });
    });
    $( "#partyassembler .invited .empty" ).droppable({
        accept: ".player.ui-draggable",
        hoverClass: "empty-hover",
        drop: function( event, ui ) {
            if (ui.draggable.data("spot")) {
                if ($(this).data("player")) {
                    var newspotid = "#"+ui.draggable.data("spot");
                    $(this).find(".player").data("spot",ui.draggable.data("spot"));
                    $(newspotid).append($(this).find(".player"));
                    //$(this).find(".player").remove();
                }
                else{
                    var fromelementid = "#"+ui.draggable.data("spot");
                    var fromid = fromelementid.split("_");
                    deletePlayerSpotButtons(fromid[1]);
                    $(fromelementid).removeClass("playerspot");
                    $(fromelementid).addClass("empty");
                    $(fromelementid).addClass("ui-droppable");
                    $(fromelementid).data("player",false);
                }

            }
            //$( this ).find( ".placeholder" ).remove();
            //ui.draggable.html().appendTo( this );
            $(this).removeClass("ui-droppable");
            $(this).removeClass("empty");
            $(this).addClass("playerspot");
            $(this).html("");
            ui.draggable.data("spot",$(this).attr("id"));
            $(this).data("player",ui.draggable.attr("id"));
            $(this).append(ui.draggable);
            var idtext = $(this).attr("id");
            var idteile = idtext.split("_");
            ui.draggable.zIndex(100-idteile[1]);
            addPlayerSpotDeleteButton(idteile[1]);
            grabPlayerlistData();
        }
    });
    function addPlayerSpotDeleteButton(spotid) {
        var buttonid = "#buttons_"+spotid;
        $(buttonid).removeClass("empty");
        $(buttonid).addClass("button");
        $(buttonid).html('<button class="delete" id="delbutton_'+spotid+'"></button>');
        //var deletebuttonelement =
        $(buttonid+" #delbutton_"+spotid).click(function(){
            //$(this).remove();
            deletePlayerFromSpot(spotid);
            deletePlayerSpotButtons(spotid);
        });
    }

    function deletePlayerSpotButtons(spotid) {
        var buttonid = "#buttons_"+spotid;
        $(buttonid).addClass("empty");
        $(buttonid).html('');
    }

    function deletePlayerFromSpot(spotid) {
        var slotelementid = ".invited #invited_"+spotid;
        var playerelementid = ".invited #invited_"+spotid+" .player";
        resetPlayer($(playerelementid));
        $(slotelementid).removeClass("playerspot");
        $(slotelementid).addClass("empty");
        $(slotelementid).addClass("ui-droppable");
        $(slotelementid).html('');
    }

    function resetPlayer(playerelement) {
        $("#playerlist").append(playerelement);
    }
    $( "#partyassembler .empty" ).on("drop", function(event,ui){
        //ui.draggable.addClass("disabled");
        //ui.draggable.draggable("disable");
    });

    function putDataToForm(){

    }

    function assembleData(){

    }

    function grabRolelistData(){

    }

    function grabPlayerlistData(){
        var playerData = new Object();
        $(".invited div.empty").each(function(){
            //console.log($(this));
            var idsplit = $(this).attr("id").split("_");
            var numericid = idsplit[1];
            playerData[numericid] = new Object();
            playerData[numericid]["player"] = 999;
            playerData[numericid]["role"] = 999;
        });
        $(".invited div.playerspot").each(function(){
            //console.log($(this));
            var idsplit = $(this).attr("id").split("_");
            var numericid = idsplit[1];
            playerData[numericid] = new Object();
            playerData[numericid]["player"] = splitid($(this).find(".player").attr("id"));
            playerData[numericid]["role"] = $(this).find(".player").data("playerrole");
        });
        return playerData;
    }

    function splitid(idstring){
        var idsplit = idstring.split("_");
        return idsplit[1];
    }

//WLTODO Formularübertrag implementieren
});

