$( document ).ready(function() {

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







    //AddEvent Form Functions
    $("#partyassembler .roleselection a").each(function(){
        $( this ).click(function() {
            //alert( "click" );
            var choosedroleelement = "#choosedrole_"+$(this).data("for");
            //var pfeilspan = "&nbsp;<span class=\"caret\"></span>";
            setRoleElement($(choosedroleelement),$(this));
            //$(choosedroleelement).data("roleid", $(this).data("roleid"));
            //$(choosedroleelement).html($(this).html()+pfeilspan);
            putDataToForm();
        });
    });


    $(".eventaddform input").each(function(){
        $( this ).change(function() {
            //alert( "change" );
            putDataToForm();
        });
    });

    $("#eventdaten #pre_activityid").change(function(){
        putDataToForm();
    });

    $(".eventaddform #pre_date").datepicker()
        .on("changeDate", function(ev){
            putDataToForm();
            $(this).datepicker("hide");
        });
    //WLTODO Position Timepicker anpassen
    //WLTODO Formularüberträge implementieren

    $("#preevent #pre_beschreibung").change(function(){
        putDataToForm();
    });

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
            putDataToForm();
        }
    });

    function setRoleElement(element, roleelement){
        var pfeilspan = "&nbsp;<span class=\"caret\"></span>";
        element.data("roleid", getRole(roleelement));
        element.html(roleelement.html()+pfeilspan);
    }

    function getRole(element) {
        return element.data("roleid");
    }

    function fillSpot(){

    }

    function emptySpot(){

    }

    function switchPlayerSpots() {

    }

    function switchPlayer() {

    }

    function hasPlayer(spotelement){
        if (spotelement.data("player")) {
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

    function addPlayerSpotDeleteButton(spotid) {
        var buttonid = "#buttons_"+spotid;
        $(buttonid).removeClass("empty");
        $(buttonid).addClass("button");
        $(buttonid).html('<button class="delete" id="delbutton_'+spotid+'"><span class="glyphicon glyphicon-remove"><i class="red"></i></span></button>');
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

    function addPlayerToSpot(playerelement, spotid){

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
        var hiddenformelements = new Object();
        var formData = assembleData();
        $("#eventdaten form#event input").each(function(){
            console.log($(this).attr("id"));
            console.log(formData[$(this).attr("id")]);
            hiddenformelements[$(this).attr("id")] = processDataForForm(formData[$(this).attr("id")]);
        });

        console.log(hiddenformelements);
        return hiddenformelements;
    }

    function assembleData(){
        var partyData = new Object();
        partyData['invited'] = new Object();
        partyData['invited']['roles'] = grabRolelistData();
        partyData['invited']['players'] = grabPlayerlistData();
        var preFormData = grabEventFormData();
//        preFormData.forEach(function(entry) {
//            console.log(entry);
//        });
        for (var i in preFormData) {
            partyData[i] = preFormData[i];
        }
        partyData = processDateTime(partyData);
        console.log('assembledata->partydata'+partyData);
        return partyData;
    }

    function processDateTime(partyData){

        if (typeof(partyData['date']) !== 'undefined' && partyData['date'] != '') {
            if (typeof(partyData['time']) !== 'undefined' && partyData['time'] != '') {
                partyData['datetime'] = partyData['date']+' '+partyData['time'];
            }
            else {
                var now = new Date();
                //now.format("HH:MM");
                partyData['datetime'] = partyData['date']+' '+formatTime(now);
            }
        }
        else {
            if (typeof(partyData['time']) !== 'undefined' && partyData['time'] != '') {
                var now = new Date();
                //now.format("yyyy-mm-dd");
                partyData['datetime'] = formatDate(now)+' '+partyData['time'];
            }
            else {
                var now = new Date();
                //now.format("yyyy-mm-dd HH:MM");
                partyData['datetime'] = formatDate(now)+' '+formatTime(now);
            }
        }
        return partyData;

    }

    function formatDate(d) {
        var dd = d.getDate()
        if ( dd < 10 ) dd = '0' + dd
        var mm = d.getMonth()+1
        if ( mm < 10 ) mm = '0' + mm
        var yyyy = d.getFullYear()
        //if ( yy < 10 ) yy = '0' + yy
        return yyyy+'-'+mm+'-'+dd
    }

    function formatTime(t){
        var hh = t.getHours();
        if ( hh < 10 ) hh = '0' + hh;
        var mm = t.getMinutes();
        if ( mm < 10 ) mm = '0' + mm;
        return hh+':'+mm;
    }


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

    function objectToJson(object) {
        return JSON.stringify(object);
    }



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

    function grabRolelistData(){
        var roleData = new Object();
        $(".roleselection .roleselect .btn-group button").each(function(){
            var numericid = splitid($(this).attr("id"));
            roleData[numericid] = new Object();
            roleData[numericid]["role"] = getRole($(this));
        });
        return roleData;
    }

    function grabPlayerlistData(){
        var playerData = new Object();
        $(".invited div.empty").each(function(){
            //console.log($(this));
//            var idsplit = $(this).attr("id").split("_");
//            var numericid = idsplit[1];
            var numericid = splitid($(this).attr("id"));
            playerData[numericid] = new Object();
            playerData[numericid]["player"] = 999;
            playerData[numericid]["role"] = 999;
        });
        $(".invited div.playerspot").each(function(){
            //console.log($(this));
//            var idsplit = $(this).attr("id").split("_");
//            var numericid = idsplit[1];
            var numericid = splitid($(this).attr("id"));
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

