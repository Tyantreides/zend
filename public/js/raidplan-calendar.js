$(document).ready(function() {



    $.ajax({
        type: "POST",
        url: "/ajaxgetevents",
        data: { datefrom: getBeginOfMonth(), dateto: getEndOfMonth() }
    })
        .done(function( msg ) {
            var obj = jQuery.parseJSON(msg);
            //alert( obj.name === "John" );
            $('#calendar').fullCalendar(obj);
            //$('#debug').html(msg);


        });

    function getBeginOfMonth(){
        var now = new Date();
        var rawdate = new Date(now.getFullYear(),now.getMonth(),1);
        return formatDate(rawdate);
    }

    function getEndOfMonth(){
        var now = new Date();
        var rawdate = new Date(now.getFullYear(),now.getMonth()+1,0);
        return formatDate(rawdate);
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

/**
    $('#calendar').fullCalendar({
        lang: 'de',
        theme: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2014-06-12',
        editable: true,
        events: [
            {
                title: 'All Day Event',
                start: '2014-06-01'
            },
            {
                title: 'Long Event',
                start: '2014-06-07',
                end: '2014-06-10'
            },
            {
                title: 'Long Event2',
                start: '2014-06-07',
                end: '2014-06-10'
            },
            {
                title: 'Long Event3',
                start: '2014-06-07',
                end: '2014-06-10'
            },
            {
                title: 'Long Event4',
                start: '2014-06-07',
                end: '2014-06-10T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2014-06-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2014-06-16T16:00:00'
            },
            {
                title: 'Meeting',
                start: '2014-06-12T10:30:00',
                end: '2014-06-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2014-06-12T12:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2014-06-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2014-06-28'
            }
        ]
    });
    */
});