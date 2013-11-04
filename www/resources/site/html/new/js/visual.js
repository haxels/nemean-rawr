/**
 * Created with JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.07.12
 * Time: 10:39
 * To change this template use File | Settings | File Templates.
 */

var seatID;

$(document).ready(function(){

   // showFirstInfo();

    $("#registerBtn").click(function(){

        setCookie('firstTime', 't', 60*60*60*24*365);
        $("#firstTime").fadeOut(300);

        $("#loginBox").fadeOut(function(){
            $("#qRegister").fadeIn();
            addMask();
        });

        return false;
    });

    $("#loginBoxForm").submit(function(){
        var urlen = "";
        $.post(urlen, $("#loginBoxForm").serialize(), function(response){
            var obj = $.parseJSON(response);
            if (!obj.success)
            {
                $("#loginBox").fadeOut(500);
                notify(obj.error)
            }
            else
            {
                $("#loginBox").fadeOut(500);
                $("#loginBtn").html('<div>Logg ut</div>');
                $("#loginBtn").attr('href', '?mAct=logout');
                $("#loginBtn").attr('id', 'logoutBtn');
                location.href='index.php';
                removeMask();
            }
        });
        $(".loader").show();
        return false;
    })

    $("#regEmail").keyup(function(event) {

        var email = this.value;

        if (email.length > 5)
        {
            var urlen = "?m=users&aAct=JSONcheckEmail";
            var data = { "email" : email };
            $.post(urlen, data, function(response){
                var obj = $.parseJSON(response);
                if (obj.legal)
                {
                    $("#regEmail").css('border-color', 'green');
                    $("#regEmail").css('border-width', '2px');
                }
                else
                {
                    $("#regEmail").css('border-color', 'red');
                    $("#regEmail").css('border-width', '2px');
                }
            });

        }

        if (email.length == 0)
        {
            $("#regEmail").css('border-color', 'red');
            $("#regEmail").css('border-width', '2px');
        }
    });

    $("#quickRegForm").submit(function(){
		
        $("input").closest('li').find('span').hide();
		
        var urlen = "?m=users&aAct=JSONquickReg";
        $.post(urlen, $("#quickRegForm").serialize(), function(response){
            var obj = $.parseJSON(String(response));
            if (obj.success)
            {
                $("#qRegister").fadeOut();
                notify("Du er nå registrert, aktiveringsmail er på tur til din innbox!");
            }
            else
            {
                if (obj.ex)
                {
                    notify(obj.ex);
                }

                if (obj.errors.firstname)
                {
                    $("input[name=firstname]").closest('li').find('span').attr('title', obj.errors.firstname).show();
                }

                if (obj.errors.lastname)
                {
                    $("input[name=lastname]").closest('li').find('span').attr('title', obj.errors.lastname).show();
                }

                if (obj.errors.email)
                {
                    $("input[name=email]").closest('li').find('span').attr('title', obj.errors.email).show();
                }
                if (obj.errors.password)
                {
                    $("input[name=password]").closest('li').find('span').attr('title', obj.errors.password).show();
                }

                if (obj.errors.birthdate)
                {
                    $("input[name=birthdate]").closest('li').find('span').attr('title', obj.errors.birthdate).show();
                }

                if (obj.errors.telephone)
                {
                    $("input[name=telephone]").closest('li').find('span').attr('title', obj.errors.telephone).show();
                }

                if (obj.errors.zipcode)
                {
                    $("input[name=zipcode]").closest('li').find('span').attr('title', obj.errors.zipcode).show();
                }

                if (obj.errors.streetadress)
                {
                    $("input[name=streetadress]").closest('li').find('span').attr('title', obj.errors.streetadress).show();
                }

                if (obj.errors.acceptTerms)
                {
                    $("input[name=acceptTerms]").closest('li').find('span').attr('title', obj.errors.acceptTerms).show();
                }
            }
        });

        return false;
    });

    $("#notifyClose").click(function(){
        $("#notify").fadeOut();
        removeMask();
        return false;
    });

    $(".X").click(function(){
        $(".X").closest('div').fadeOut(300, function(){
            $("#overlay").remove();
            resetAllForms();
        });
        return false;
    });

    $("#forgotPswBtn").click(function(){

        $("#loginBox").fadeOut(function(){
            $("#forgotPsw").fadeIn();
            addMask();
        });

        return false;
    });

    $("#loginBtn").click(function(){
        $("#loginBox").fadeIn();
        addMask();
    });

    $(".crewApply").click(function()
    {

      $("#applicationForm").fadeIn();
        addMask();
        return false;
    });

    $("#application").submit(function()
    {
        $("input").closest('li').find('span').hide();
        var urlen = "?m=users&aAct=JSONcrewApplication";
        $.post(urlen, $("#application").serialize(), function(response){

            var obj = $.parseJSON(response);
            if (obj.success)
            {
                $("#applicationForm").fadeOut();
                removeMask();
            }
            else
            {
                if (obj.errors.firstname)
                {
                    $("input[name=firstname]").closest('li').find('span').attr('title', obj.errors.firstname).show();
                }

                if (obj.errors.lastname)
                {
                    $("input[name=lastname]").closest('li').find('span').attr('title', obj.errors.lastname).show();
                }

                if (obj.errors.email)
                {
                    $("input[name=email]").closest('li').find('span').attr('title', obj.errors.email).show();
                }
                if (obj.errors.byear)
                {
                    $("input[name=byear]").closest('li').find('span').attr('title', obj.errors.byear).show();
                }

                if (obj.errors.what)
                {
                    $("input[name=what]").closest('li').find('span').attr('title', obj.errors.what).show();
                }

                if (obj.errors.why)
                {
                    $("input[name=why]").closest('li').find('span').attr('title', obj.errors.why).show();
                }
            }
            notify(obj.msg);
        });

        return false;
    });

    $("#forgotPswForm").submit(function()
    {
        var email = this.elements[0].value;
        if (email != '')
        {
            var urlen = "?m=users&aAct=JSONforgot";
            $.post(urlen, $("#forgotPswForm").serialize(), function(response){
                var obj = $.parseJSON(response);
                if (obj.success)
                {
                    $("#forgotPsw").fadeOut();
                }
                notify(obj.msg);
            });
        }
        else
        {
            notify('Du må skrive inn en e-postadresse');
        }

        return false;
    });

    $("#forgotPswForm").submit(function()
    {
        var email = this.elements[0].value;
        if (email != '')
        {
            var urlen = "?m=users&aAct=JSONforgot";
            $.post(urlen, $("#forgotPswForm").serialize(), function(response){
                var obj = $.parseJSON(response);
                if (obj.success)
                {
                    $("#forgotPsw").fadeOut();
                }
                notify(obj.msg);
            });
        }
        else
        {
            notify('Du må skrive inn en e-postadresse');
        }

        return false;
    });

    $("#completereg").submit(function(){
        var urlen = "?m=users&aAct=JSONcompleteReg";
        $.post(urlen, $("#cRegForm").serialize(), function(response){
            var obj = $.parseJSON(response);
            if (obj.success)
            {
                $("#completereg").fadeOut(500);
                notify('Foresatt lag til, e-post på tur.');
            }
            else
            {
                notify('Noe gikk galt.');
            }
        });

        return false;
    });

    $("#reserveSeatForm").submit(function(){
        var psw = this.elements[0].value;
        var data = {'psw' : psw, 'seatID' : seatID};
        var urlen = '?m=reservations&aAct=JSONreserveSeat';
        $.post(urlen, data, function(response){
            var obj = $.parseJSON(response);

            if (obj.success)
            {
                $("#a"+seatID).attr('class', 'mapCurrentUser');
                $("#a"+seatID).find('p').html('<button class="removeRsvBtn" id="'+seatID+'">Slett reservasjon</button>');
                $("#"+seatID).on('click', function(){
                    eventRemoveRsvClick(seatID);
                    return false;
                });
                $("#reserveSeat").fadeOut(500);
                $("#reserveSeatForm")[0].reset();
                notify('Du er nå plassert.');
            }
            else
            {
                $("#reserveSeat").fadeOut(500);
                notify(obj.error);
            }
        });
        return false;
    });

    $(".cRegBtn").click(function(){
        eventReserveSeatClick(this.id);
    });

    $("#cRegForm").submit(function(){
        var urlen = "?m=users&aAct=JSONcompleteReg";
        $.post(urlen, $("#cRegForm").serialize(), function(response){
            var obj = $.parseJSON(response);
            if (obj.success)
            {
                $("#completereg").fadeOut();
            }
            notify(obj.msg);
        });
        return false;
    });

    $(".removeRsvBtn").click(function(){
        eventRemoveRsvClick(this.id);

        return false;
    });

    $("#removeRsvForm").submit(function(){
        var psw = this.elements[0].value;
        var data = {'psw' : psw, 'seatID' : seatID};
        var urlen = '?m=reservations&aAct=JSONremoveReservation';

        $.post(urlen, data, function(response){
            var obj = $.parseJSON(response);
            if (obj.success)
            {
                $("#a"+seatID).attr('class', 'mapAvailable');
                $("#a"+seatID).find('p').html('<button id="'+seatID+'" class="cRegBtn">Reserver</button>');
                $("#"+seatID).on('click', function(){
                    eventReserveSeatClick(seatID);
                    return false;
                });
                $("#removeRsv").fadeOut(500);
                $("#removeRsvForm")[0].reset();
                notify('Reservasjon fjernet');
            }
            else
            {
                $("#removeRsv").fadeOut(500);
                notify(obj.error);
            }
        });

        return false;
    });


    /*
    $(window).resize(function() {
        //showFirstInfo();
    });
    */


    function showFirstInfo()
    {
        if (!checkCookie())
        {
            var position = $("#loginBtn").offset();
            var width = $("#loginBtn").outerWidth();
            var css = {
                position: "absolute",
                top: position.top +"px",
                left: (position.left + width) + "px"
            };
            if ($("#firstTime").length == 0)
            {
                $("body").append("<div id='firstTime'><----- Registrer deg her</div>");
            }
            $("#firstTime").css(css);
        }
    }

    function notify(msg)
    {
        $("#notifyMsg").html(msg);
        $("#notify").fadeIn(500);
        addMask();
    }

    function addMask()
    {
        $("body").append('<div id="overlay"></div>');
        $("#overlay").fadeIn(300);
    }

    function removeMask(fade)
    {
        var time = 0;
        if (arguments.length == 1)
        {
            time = fade;
        }
        else
        {
            time = 300;
        }
        $("#overlay").fadeOut(time).remove();
    }


    $(".mapAvailable").click(function(){
        return false;
    });

    function eventRemoveRsvClick(btnid)
    {
        seatID = btnid;
        $("#removeRsvForm").find("h4").html('Plass ' + seatID);
        $("#removeRsv").fadeIn(500);
        addMask();
        return false;
    }

    function eventReserveSeatClick(btnid)
    {
        var urlen = "?m=users&aAct=JSONverifyAge";
        seatID = btnid;
        $.get(urlen, function(response){
            var obj = $.parseJSON(response);
            if (obj.success)
            {
                // Reserver
                $("#reserveSeat").fadeIn(500);
                $("#reserveSeatForm").find("h4").html('Plass ' + seatID);
                addMask();
            }
            else
            {
                // Not OK
                if (obj.msg)
                {
                    notify(obj.msg);
                }
                else
                {
                    $("#cRegSID").val(''+ seatID);
                    $("#completereg").fadeIn(500);
                    addMask();
                }
            }
        });
        return false;
    }

    function resetAllForms()
    {
        $("#removeRsvForm").reset();
        $("#reserveSeatForm").reset();
    }

    $.ajaxSetup({
        beforeSend:function(){
            // show gif here, eg:
            $(".loader").show();
        },
        complete:function(){
            // hide gif here, eg:
            $(".loader").hide();
        }
    });

    function checkCookie()
    {
        var fT = getCookie("firstTime");
        if (fT != null && fT != "")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function setCookie(c_name,value,exdays)
    {
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value;
    }

    function getCookie(c_name)
    {
        var i,x,y,ARRcookies=document.cookie.split(";");
        for (i=0;i<ARRcookies.length;i++)
        {
            x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
            y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
            x=x.replace(/^\s+|\s+$/g,"");
            if (x==c_name)
            {
                return unescape(y);
            }
        }
    }


    $("#terms").scroll(function(){

        var myDiv = $('#terms'),
            checkBox = $('#okTerms')
        if (myDiv.scrollTop() + myDiv.outerHeight() == (myDiv.get(0).scrollHeight))
        {
            checkBox.removeAttr('disabled');
        }
        else
        {
            
        }
        });

});