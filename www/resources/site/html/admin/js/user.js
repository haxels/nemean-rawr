
$(document).ready(function() {


    var users;
   // getUsers();

    $(document).keyup(function(e){
        if(e.keyCode === 27){
            $('.adminPopup').fadeOut(500);
            removeMask();
        }
    });

    $("#p").dataTable({
        "bProccessing"  : true,
        "bServerSide"   : false,
        "iDisplayLength": 10,
        "bLengthChange" : false,
        "fnDrawCallback": function() {
            // Bind onclick on buttons
            paymentButtonClickEvent('.pay-btn', 1);
            paymentButtonClickEvent('.unpay-btn', 0);
            deleteButtonClickEvent('.delete-btn');
            activateButtonClickEvent('.activate-btn');
            viewUserButtonClickEvent();
        }
    });



/*
    function getUsers()
    {
        $.get('?m=users&aAct=JSONgetUsers', function(response){
            var obj = $.parseJSON(response);
            var tmp = [];
            for (i = 0; i < obj.users.length; i++)
            {
                tmp[i] = obj.users[i];
            }
            users = tmp;

            $('.userSearch').autocomplete({
                minLength: 0,
                source: users,
                focus: function (event, ui) {
                    $(".userSearch").val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    $(".userSearch").val(ui.item.label);
                    $(".userSearch-id").val(ui.item.value);
                    //$(".userSearch-description").html(ui.items.desc);
                    return false;
                }
            })
                .data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li>").data( "ui-autocomplete-item", item )
                    .append("<a>" + item.label + "</a>")
                    .appendTo(ul);
            };
        });
    }
*/

    /**
     * Click function for all buttons with popups
     * Id of the popup is found in buttons href-tag
     */
    $(".btn-popup").click(function(){
        var id = $(this).attr('id');
        var cb = function()
        {
            $("#id").val(id);
        }
        N.popup($(this).attr('href'), cb);
        return false;
    });

    $(".chkUpdate").change(function(){
        console.log('Chkbox clicked');
        var name = $(this).attr('name');
        var value = $(this).attr('value');
        var user_id = $(this).attr('id');
        var chked = $(this).is(':checked');
        var selector = $(this);
        N.post({"chked" : chked, "value" : value, "user_id" : user_id}, '?m=users&aAct=JSONupdateRole', selector, '');
        return false;
    });

    $("#viewMapBtn").click(function(){
        viewMap();
        return false;
    });



    $("#regGuestForm").submit(function(){
        var urlen = '?m=reservations&aAct=JSONregisterGuest';
        N.submit("#regGuestForm", urlen, "#regGuest", null);
        return false;
    });

    $("#regReservationForm").submit(function(){
        var urlen = '?m=reservations&aAct=JSONaddReservation';
        N.submit("#regReservationForm", urlen, "#regReservation", null);
        return false;
    });

    $("#addUserForm").submit(function(){
        var urlen = '?m=users&aAct=JSONaddUser';
        N.submit("#addUserForm", urlen, "#addUser", null);
        return false;
    });



    function payment(userID, type, elem)
    {
        var urlen = '?m=reservations&aAct=JSONpay';
        var data = {'user_id' : userID, 'type' : type};
        N.post(data, urlen, elem, "deleteRow");
    }

    function delReservation(id, elem)
    {
        var urlen = '?m=reservations&aAct=JSONremoveReservation';
        var data = {'seat_id' : id};
        N.post(data, urlen, elem, "deleteRow");
    }

    ///////////////////////////////////////////////////////////////////////////





    function viewUserButtonClickEvent()
    {
        $('.user-btn').click( function(){

            var type = (this.id).substr(0,1);
            var userID = (this.id).substr(1);
            switch(type){

                case 'v':
                    getUser(userID);
                    $('#viewUser').fadeIn(500);
                    addMask();
                    break;

                case 'd':

                    break;

            }
        });
    }



    function activateReservation(id, elem)
    {
        var urlen = '?m=reservations&aAct=JSONactivateReservation';
        var data = {'user_id' : id};
        N.post(data, urlen, id, "deleteRow");
    }

    function deleteButtonClickEvent(btnType)
    {
        $('.delete-btn').click(function() {
            var id = (this.id);
            var elem = $(this).closest('tr');
            var name = $(this).closest('td').attr('id');
            function yes() {delReservation(id, elem)};
            function no() {};
            confirmDialog('Kansellering av reservasjon', 'Du er i ferd med å kansellere <b>'+name+
                          '</b> sin reservasjon. Ønsker du å fullføre denne handlingen?', yes, no);
            event.preventDefault();
        });
    }

    function activateButtonClickEvent(btnType)
    {
        $('.activate-btn').click(function() {
            var id = (this.id);
            var elem = $(this).closest('tr');
            var name = $(this).closest('td').attr('id');
            function yes() {activateReservation(id, elem)};
            function no() {};
            confirmDialog('Aktivering av reservasjon', 'Du er i ferd med å aktivere <b>'+name+
                          '</b> sin reservasjon. Ønsker du å fullføre denne handlingen?', yes, no);
            event.preventDefault();
        });
    }

    function paymentButtonClickEvent(btnType, paymentType, title, msg)
    {
        $(btnType).click(function(){
           var userID = this.id;
            var elem = $(this).closest('tr');
            var name = $(this).closest('td').attr('id');
            function yes() {payment(userID, paymentType, elem)};
            function no() {};
            if (paymentType)
            {
                confirmDialog('Registrere betaling', 'Du er i ferd med å registrere <b>'+name+
                              '</b> som betalt. Ønsker du å fullføre denne handlingen?', yes, no);
            }
            else
            {
                confirmDialog('Registrere som ikke betalt', 'Du er i ferd med å registrere <b>'+name+
                              '</b> som <b>ikke</b> betalt. Ønsker du å fullføre denne handlingen?', yes, no);
            }
            event.preventDefault();
        });
    }





    $(".settings-btn").click(function(){
       getSettings($(this).attr('href'));
        $("#rsvSettings").fadeIn(500);
        addMask();
        return false;
    });






// Nemean.js
    function addMask()
    {
        $("body").append('<div id="overlay"></div>');
        $("#overlay").fadeIn(300);
    }

    function getUser(userID)
    {
        $("#responseHolder").html('');
        var urlen = "?m=users&aAct=JgetUser&uID="+userID;
        $.get(urlen, function(response){
            $("#responseHolder").html(response);
            $(".chkUpdate").change(function(){
                var name = $(this).attr('name');
                var value = $(this).attr('value');
                var user_id = $(this).attr('id');
                var chked = $(this).attr('checked');
                var selector = $(this);
                N.post({"chked" : name, "value" : value, "user_id" : user_id}, '?m=users&aAct=JSONupdateRole', selector, '');
                return false;
            });
        });
    }


    // Nemean.js
    function getSettings(module)
    {
        $("#settings").html('');
        var urlen = "?m="+module+"&aAct=JSONgetSettings";
        $.get(urlen, function(response){
            $("#settings").html(response);

            $("#settingsForm").submit(function(){
                var urlen = '?m=settings&aAct=JSONupdateSettings';
                $.post(urlen, $(this).serialize(), function(response){
                    var obj = $.parseJSON(response);
                    if (obj.success)
                    {
                        $('#settingsForm').fadeOut(500);
                        removeMask();
                    }
                    else
                    {
                        $('#settingsForm').fadeOut(500);
                        removeMask();
                    }
                    notify(obj.msg);
                });
                return false;
            });
        });

    }
// Nemean.js
    function confirmDialog(title, msg, callbackYes, callbackNo)
    {
        var retVal = false;
        $.confirm({
            'title'     : title,
            'message'   : msg,
            'buttons'   : {
                'Ja'    : {
                    'class'     : 'blue',
                    'action'    : callbackYes
                },
                'Nei'   : {
                    'class'     : 'gray',
                    'action'    : callbackNo
                }
            }
        });
        return retVal;
    }
// Nemean.js
    function notify(msg)
    {
        $("#notifyMsg").html(msg);
        $("#notify").fadeIn(500).fadeOut(10000);
    }

    $(".x").click(function(){
        $(".x").closest('div').fadeOut(300, function(){
            $("#overlay").fadeOut(200);
            resetForms();
        });
        return false;
    });

    function resetForms(){
        $("form").each(function(){
            this.reset();
        });
    }

});