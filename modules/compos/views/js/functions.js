/**
 * Created with JetBrains PhpStorm.
 * User: Ragnar
 * Date: 19.10.12
 * Time: 20:08
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){


    /**
     * Button actions
     */
    $(".compoReg").click(function(){
        $("#addTeamDiv").fadeIn();
        addMask();
    })

    /**
     * Form actions
     */
    $("#addTeamForm").submit(function(){

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

});