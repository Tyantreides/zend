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
        }
    });
    function getPlayerSpotDeleteButton(spotid) {

    }
    $( "#partyassembler .empty" ).on("drop", function(event,ui){
        //ui.draggable.addClass("disabled");
        //ui.draggable.draggable("disable");
    });

//WLTODO funktion zum löschen der Player von Spots zurück in die Playerliste implementieren
//WLTODO Formularübertrag implementieren
});

