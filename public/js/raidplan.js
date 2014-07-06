/**
 * Raidplan.js Version Beta 0.1
 * create by Christian Meissner
 *
 */

$( document ).ready(function() {

    /**
     * Ajax login funktionalität
     */
    $.ajax({
        url: "/ajaxlogin"
    }).done(function( msg ) {
        if ($("#loginformbar").length > 0) {
            $("#loginformbar").detach();
            $('#mainnavbar #nav').append(msg);
        }
        else{
            $('#mainnavbar #nav').append(msg);
        }
        $('#loginbtn').click(function(){
            var dataarray = new Object();
            dataarray['user'] = $("#loginuser").val();
            dataarray['passwd'] = $("#loginpasswd").val();
            $.ajax({
                type: "POST",
                url: "/ajaxlogin",
                data: dataarray
            }).done(function( msg ) {
                if ($("#loginformbar").length > 0) {
                    $("#loginformbar").detach();
                    $('#mainnavbar #nav').append(msg);
                }
                else{
                    $('#mainnavbar #nav').append(msg);
                }

            });
        });
    });


    /**
     * -------------------------------------------------------------
     * Onchanges und onclicks
     * -----------------------------------------------------------
     */

    /**
     * onclicks für die roleselektoren auf add und editpage
     */
    $("#partyassembler .roleselection a").each(function(){
        $( this ).click(function() {
            var choosedroleelement = "#choosedrole_"+$(this).data("for");
            setRoleElement($(choosedroleelement),$(this));
            putDataToForm();
        });
    });


    /**
     * Onchanges für verschiedene input felder. wichtig damit das datenarray zum verschicken immer aktuell ist
     */
    $(".eventaddform input").each(function(){
        $( this ).change(function() {
            putDataToForm();
        });
    });

    /**
     * separater onchange fürs dropdown weil es kein input ist
     */
    $("#eventdaten #pre_activityid").change(function(){
        putDataToForm();
    });

    /**
     * spezieller onchange für den datepicker
     */
    $(".eventaddform #pre_date").datepicker()
        .on("changeDate", function(ev){
            putDataToForm();
            $(this).datepicker("hide");
        });

    /**
     * onchange für das beschreibungsfeld weil textarea
     */
    $("#preevent #pre_beschreibung").change(function(){
        putDataToForm();
    });

    /**
     * onclick für den speichernbutton bei add und edit page
     */
    $("#eventspeichern").click(function(){
        console.log("clicked");
        $.ajax({
            type: "POST",
            url: "/saveevent",
            data: putDataToForm()
        })
            .done(function( msg ) {
                $("body").append('<div id="raidplan-overlay"></div>');
                $("body").append(msg);
                $("#raidplan-overlay").fadeIn();
                $(".raidplan-msg-box").fadeIn();
                $(".raidplan-msg-box").css("top",screen.height/2-$("#raidplan-msg").outerHeight()/2);
                $(".raidplan-msg-box").css("left",screen.width/2-$("#raidplan-msg").outerWidth()/2);
                function redirect () {
                    window.location.href = "/events";
                }
                window.setTimeout(redirect, 5000);
            });
    });

    /**
     *onlick für den editieren button auf der view page
     */
    $('#loadedit').click(function(){
        $.ajax({
            type: "POST",
            url: "/ajaxedit",
            data: loadeventforedit()
        })
        .done(function( msg ) {
                $('#eventcontainer').html("");
                $('#eventcontainer').html(msg);
        });
    });

    $('#deleteevent').click(function(){
        var eventid = $(".eventviewform").data('eventid');
        $.ajax({
            type: "POST",
            url: "/ajaxdeleteevent/"+eventid,
        })
            .done(function( msg ) {
                function redirect () {
                    window.location.href = "/events";
                }
                window.setTimeout(redirect, 500);
            });
    });
    /**
     * -----------------------------------------------------------------------------------
     *
     */


    /**
     * ----------------------------------------------------------------------
     * Diverse Data Helper und datensammelfunktionen für die formulare etc
     *
     */

    /**
     * bereitet den post für das laden der editpage via ajax vor
     * @returns {Object}
     */
    function loadeventforedit(){
        var eventid = $(".eventviewform").data('eventid');
        var returnarray = new Object();
        returnarray['eventid'] = eventid;
        return returnarray;
    }

    /**
     * verteilt beim laden der editpage die Spieler auf die richtigen plätze wie sie im eventdatensatz stehen
     */
    $( "#partyassembler .invited .empty").each(function(){
        if (isFilled($(this))) {
            var playerid = $(this).data('filled');
            var playerelement = '#playerlist #'+playerid;
            var playerforspot = $(playerelement);

            $(this).removeClass("ui-droppable");
            $(this).removeClass("empty");
            $(this).addClass("playerspot");
            $(this).html("");
            $(this).data('filled',null);

            $(this).append(playerforspot);
            playerforspot.data("spot",$(this).attr("id"));
            playerforspot.addClass("ui-draggable");
            addPlayerSpotDeleteButton(splitid($(this).attr("id")));
        }
    });

    /**
     * definiert dropables für die drag and dropfunktionen wenn man spieler auf plätze zieht
     * das dropcallback übernimmt auch gleich das aktualisieren des datenarrays und der einzelnen sich verschiebenen elemente
     *
     */
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
            putDataToForm();
        }
    });

    /**
     * ändert ein role "dropdown" wenn man eine auswahl getätigt hat.
     * @param element
     * @param roleelement
     */
    function setRoleElement(element, roleelement){
        var pfeilspan = "&nbsp;<span class=\"caret\"></span>";
        element.data("roleid", getRole(roleelement));
        element.html(roleelement.html()+pfeilspan);
    }

    /**
     * holt das html5 data attribut roleid des angegebenen elements
     * das element muss das ergebnis aus $(elementid) sein
     * @param element
     * @returns {*}
     */
    function getRole(element) {
        return element.data("roleid");
    }

    /**
     * prüft ob das angegebene element das dataattribut "player" besitzt
     * @param spotelement
     * @returns {boolean}
     */
    function hasPlayer(spotelement){
        if (spotelement.data("player")) {
            return true;
        }
        return false;
    }

    /**
     * prüft ob das angegebene element das dataattribut "filled" besitzt
     *
     */
    function isFilled(spotelement){
        if (spotelement.data("filled")) {
            return true;
        }
        return false;
    }

    function hasSpot(playerelement){
        if (playerelement.data("spot")) {
            return true;
        }
        return false;
    }

    function setPlayer(spotelement, value) {
        spotelement.data("player", value);
    }

    function getPlayer(spotelement) {
        return spotelement.data("player");
    }

    function setSpot(playerelement, value) {
        playerelement.data("spot", value);
    }

    function getSpot(playerelement) {
        return playerelement.data("player");
    }


    /**
     * fügt der angegebenen Zeile des partassemblers einen "löschen" button hinzu
     * @param spotid
     */
    function addPlayerSpotDeleteButton(spotid) {
        var buttonid = "#buttons_"+spotid;
        $(buttonid).removeClass("empty");
        $(buttonid).addClass("button");
        $(buttonid).html('<button class="delete" id="delbutton_'+spotid+'"><span class="glyphicon glyphicon-remove"><i class="red"></i></span></button>');
        $(buttonid+" #delbutton_"+spotid).click(function(){
            deletePlayerFromSpot(spotid);
            deletePlayerSpotButtons(spotid);
        });
    }

    /**
     * Löscht den Löschenbutton einer zeile im partyassembler
     * @param spotid
     */
    function deletePlayerSpotButtons(spotid) {
        var buttonid = "#buttons_"+spotid;
        $(buttonid).addClass("empty");
        $(buttonid).html('');
    }

    /**
     * löscht einen Spieler einer zeile im partyassembler
     * @param spotid
     */
    function deletePlayerFromSpot(spotid) {
        var slotelementid = ".invited #invited_"+spotid;
        var playerelementid = ".invited #invited_"+spotid+" .player";
        resetPlayer($(playerelementid));
        $(slotelementid).removeClass("playerspot");
        $(slotelementid).addClass("empty");
        $(slotelementid).addClass("ui-droppable");
        $(slotelementid).html('');
    }

    /**
     * fügt den Spieler wieder in die partyliste ein
     * @param playerelement
     */
    function resetPlayer(playerelement) {
        $("#playerlist").append(playerelement);
    }

    /**
     * sammelt alle formulare und fürg sie in ein array  ein und gibt es zurück.
     * Dieses array geht dann via ajax z.B. an die speichern funktion
     * @returns {Object}
     */
    function putDataToForm(){
        var hiddenformelements = new Object();
        var formData = assembleData();
        $("#eventdaten form#event input").each(function(){
            hiddenformelements[$(this).attr("id")] = processDataForForm(formData[$(this).attr("id")]);
        });
        return hiddenformelements;
    }

    /**
     * baut daten von den formularen de edit und add page zusammen
     * @returns {Object}
     */
    function assembleData(){
        var partyData = new Object();
        partyData['invited'] = new Object();
        partyData['invited']['roles'] = grabRolelistData();
        partyData['invited']['players'] = grabPlayerlistData();
        var preFormData = grabEventFormData();
        for (var i in preFormData) {
            partyData[i] = preFormData[i];
        }
        partyData = processDateTime(partyData);
        return partyData;
    }

    /**
     * erstellt einen immer gültigen zeitstempel
     * wird kein datum gesetzt fügt die funktion das heutige ein.
     * wird keine uhrzeit gesetzt fügt die funktion jetzt ein.
     * @param partyData
     * @returns {*}
     */
    function processDateTime(partyData){

        if (typeof(partyData['date']) !== 'undefined' && partyData['date'] != '') {
            if (typeof(partyData['time']) !== 'undefined' && partyData['time'] != '') {
                partyData['datetime'] = partyData['date']+' '+partyData['time'];
            }
            else {
                var now = new Date();
                partyData['datetime'] = partyData['date']+' '+formatTime(now);
            }
        }
        else {
            if (typeof(partyData['time']) !== 'undefined' && partyData['time'] != '') {
                var now = new Date();
                partyData['datetime'] = formatDate(now)+' '+partyData['time'];
            }
            else {
                var now = new Date();
                partyData['datetime'] = formatDate(now)+' '+formatTime(now);
            }
        }
        return partyData;

    }

    /**
     * formatiert das datum
     * @param d
     * @returns {string}
     */
    function formatDate(d) {
        var dd = d.getDate()
        if ( dd < 10 ) dd = '0' + dd
        var mm = d.getMonth()+1
        if ( mm < 10 ) mm = '0' + mm
        var yyyy = d.getFullYear()
        return yyyy+'-'+mm+'-'+dd
    }

    /**
     * formatiert die Zeit
     * @param t
     * @returns {string}
     */
    function formatTime(t){
        var hh = t.getHours();
        if ( hh < 10 ) hh = '0' + hh;
        var mm = t.getMinutes();
        if ( mm < 10 ) mm = '0' + mm;
        return hh+':'+mm;
    }


    /**
     * bringt json und normale stringdaten in die gleiche form
     * @param data
     * @returns {*}
     */
    function processDataForForm(data) {
        if (typeof data == 'object') {
            return objectToJson(data);
        }
        else if (typeof data == 'array') {

        }
        else {
            return data;
        }
    }

    /**
     * wandelt ein objekt in einen jsonstring um
     * @param object
     * @returns {*}
     */
    function objectToJson(object) {
        return JSON.stringify(object);
    }


    /**
     * holt die daten des eventforms ansich
     * @returns {Object}
     */
    function grabEventFormData(){
        var preFormData = new Object();
        $(".eventaddform #preevent input").each(function(){
                preFormData[splitid($(this).attr("id"))] = $(this).val();
        });
        $(".eventaddform #preevent textarea").each(function(){
            preFormData[splitid($(this).attr("id"))] = $(this).val();
        });
        $("#eventdaten #pre_activityid").each(function(){
            preFormData[splitid($(this).attr("id"))] = $(this).val();
        });

        return preFormData;
    }

    /**
     * holt die daten der role auswahl
     * @returns {Object}
     */
    function grabRolelistData(){
        var roleData = new Object();
        $(".roleselection .roleselect .btn-group button").each(function(){
            var numericid = splitid($(this).attr("id"));
            roleData[numericid] = new Object();
            roleData[numericid]["role"] = getRole($(this));
        });
        return roleData;
    }

    /**
     * holt die daten für die verteilten spieler
     * @returns {Object}
     */
    function grabPlayerlistData(){
        var playerData = new Object();
        $(".invited div.empty").each(function(){
            var numericid = splitid($(this).attr("id"));
            playerData[numericid] = new Object();
            playerData[numericid]["player"] = 999;
            playerData[numericid]["role"] = 999;
        });
        $(".invited div.playerspot").each(function(){
            var numericid = splitid($(this).attr("id"));
            playerData[numericid] = new Object();
            playerData[numericid]["player"] = splitid($(this).find(".player").attr("id"));
            playerData[numericid]["role"] = $(this).find(".player").data("playerrole");
        });
        return playerData;
    }

    /**
     * teilt einen string per "_" seperator und liefert teil 2 zurück
     * wird z.B. zur ermittlung des numerischen teils von "player_1" benutzt
     * @param idstring
     * @returns {*}
     */
    function splitid(idstring){
        var idsplit = idstring.split("_");
        return idsplit[1];
    }
});

