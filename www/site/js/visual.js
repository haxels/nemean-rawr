/**
 * Created with JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.07.12
 * Time: 10:39
 * To change this template use File | Settings | File Templates.
 */

var seatID;

$(document).ready(function(){

    $("#registerBtn").click(function(){
        showForm("#qRegister");
        return false;
    });
    
    $(".headerpart-1").click(function(){
        showForm("#gMap");
        return false;
    });
    
    function showForm(divID)
    {
        var visible = $(divID).is(":visible");
        $(".formBox").children().slideUp();
        $(".X").fadeOut(10);
        
        if(!visible) {
            
            $(divID).slideDown();
            $(".X").fadeIn(10);
        }
    }

    $("#loginBoxForm").submit(function(){
        console.log("Submitted!");
        var urlen = "";
        $.post(urlen, $("#loginBoxForm").serialize(), function(response){
            console.log("før obj!");
            var obj = $.parseJSON(response);
            console.log("Etter OBJ!");
            if (!obj.success)
            {
                console.log("Success, NNAAAT!");
                $("#loginBox").fadeOut(500);
                notify(obj.error)
            }
            else
            {
                console.log("Success!");
                $("#loginBox").slideUp(500);
                $(".X").slideUp(500);
                $(".lBtn").html('<div>' + obj.name + '</div>');
                $(".lBtn").attr('href', '?mAct=logout');
                $(".lBtn").attr('id', 'logout-link');
                //location.href='index.php';
            }
        });
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
                $("#qRegister").slideUp();
                $(".X").slideUp();
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
        return false;
    });

    $(".X").click(function(){
        $(this).fadeOut(10);
        $(".formBox").children().slideUp();
        
        return false;
    });

    $("#forgotPswBtn").click(function(){
        showForm("#forgotPsw");
       // $("#loginBox").fadeOut(function(){
        //    $("#forgotPsw").fadeIn();
        //});

        return false;
    });

    $("#login-link").click(function(){
        showForm("#loginBox");
        return false;
    });

    $(".crewApply").click(function()
    {
      $("#applicationForm").fadeIn();
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
        
    $(".reserveFormBtn").click(function(event){
        console.log("Seatpå");
        //var psw = this.elements[0].value;
        //var seatID
        //var data = {'psw' : psw, 'seatID' : seatID};
        var urlen = '?m=reservations&aAct=JSONreserveSeat';
        seatID = this.title;
        $.post(urlen, $("#f" + seatID).serialize(), function(response){
            var obj = $.parseJSON(response);

            if (obj.success)
            {
                $("#a"+seatID).attr('class', 'mapCurrentUser');
                var elm = $("#removeRsv");
                elm.find('h2').html('Plass '+seatID);
                elm.find('form').attr("id", "f"+seatID);
                elm.find('input[name="seatID"]').attr("value", seatID);
                elm.find('input[name="submit_remove"]').attr("id", seatID);
                $("#a"+seatID).find('span').html(elm.html());
                //location.href = "?pID=24&m=reservations";
                //.html('<form id="f'+seatID+'" class="removeRsvForm" action="" method="POST"><button class="removeRsvBtn" id="'+seatID+'">Slett reservasjon</button>');
                //$("#reserveSeat").fadeOut(500);
                //$("#reserveSeatForm")[0].reset();
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
        console.log('haptidu');
        //var psw = this.elements[0].value;
        //var data = {'psw' : psw, 'seatID' : seatID};
        var urlen = '?m=reservations&aAct=JSONremoveReservation';
        seatID = this.title;
        $.post(urlen, $("#f"+seatID).serialize(), function(response){
            var obj = $.parseJSON(response);
            if (obj.success)
            {
                $("#a"+seatID).attr('class', 'mapAvailable');
                var elm = $("#reserveSeat");
                elm.find('h2').html('Plass '+seatID);
                elm.find('form').attr("id", "f"+seatID);
                elm.find('input[name="seatID"]').attr("value", seatID);
                elm.find('input[name="submit_reserve"]').attr("id", seatID);
                $("#a"+seatID).find('span').html(elm.html());
                //location.href = "?pID=24&m=reservations";
                
                //$("#removeRsv").fadeOut(500);
               // $("#removeRsvForm")[0].reset();
                notify('Reservasjon fjernet');
            }
            else
            {
               //$("#removeRsv").fadeOut(500);
                notify(obj.error);
            }
        });
        return false;
    });

    function notify(msg)
    {
        $("#notifyMsg").html(msg);
        $("#notify").fadeIn(500);
    }

    $(".mapAvailable, .mapCurrentUser").click(function(){
        return false;
    });
    
     function resetAllForms()
    {
        $("#removeRsvForm").reset();
        $("#reserveSeatForm").reset();
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

    $('[data-update]').each(function() {
        var self = $(this);
        var target = self.data('update');
        var refreshId =  setInterval(function() { self.load(target); }, self.data('refresh-interval'));
    });

});