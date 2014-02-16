/**
 * Created with JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.07.12
 * Time: 10:39
 * To change this template use File | Settings | File Templates.
 */

var seatID,
    liveMode = false,
    liveModeId = 0,
    gMapLoaded = false;

$(document).ready(function() {
    Nemean.order(jQuery);
    $(".rslides").responsiveSlides({
  auto: true,             // Boolean: Animate automatically, true or false
  speed: 500,            // Integer: Speed of the transition, in milliseconds
  timeout: 9000,          // Integer: Time between slide transitions, in milliseconds
  pager: true,           // Boolean: Show pager, true or false
  nav: true,             // Boolean: Show navigation, true or false
  random: false,          // Boolean: Randomize the order of the slides, true or false
  pause: false,           // Boolean: Pause on hover, true or false
  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
  prevText: "Forrige",   // String: Text for the "previous" button
  nextText: "Neste",       // String: Text for the "next" button
  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
  navContainer: "#naver",       // Selector: Where controls should be appended to, default is after the 'ul'
  manualControls: "#naver",     // Selector: Declare custom pager navigation
  namespace: "rslides",   // String: Change the default namespace used
  before: function(){},   // Function: Before callback
  after: function(){}     // Function: After callback
});

    $("#order-btn").click(function() {
        showForm("#orderForm");
        return false;
    });

    $(".headerpart-1").click(function() {
        if (!gMapLoaded) {
            $("#gMap").load("gMap.php", function(){
                showForm("#gMap")
            });
            gMapLoaded = true;
        }
        else {
            showForm("#gMap");
        }
        return false;
    });

    function showForm(divID) {
        var visible = $(divID).is(":visible");
        $(".formBox").children().slideUp();
        $(".X").fadeOut(10);

        if (!visible) {

            $(divID).slideDown();
            $(".X").fadeIn(10);
        }
    }



    $("#order").submit(function() {
        var urlen = "index.php?m=kiosk&aAct=putOrder";
        $.post(urlen, $("#order").serialize(), function(response) {
            var obj = $.parseJSON(response);
            console.log(obj);
            if(obj.success) {
               // $("#orderForm").load(url);
                notify('Børger bestilt! Ordrenummer: ' + obj.order_id);
                $("#orderForm").slideUp();
                Nemean.order.reset();
                return false;
            }
            else {
                notify("Bestillingen har dessverre forlatt vår verden. Vi føler med deg... RIP.");
                $("#orderForm").slideUp();
                return false;
            }
        });
        return false;
    });

    $("#loginBoxForm").submit(function() {
        var urlen = "";
        $.post(urlen, $("#loginBoxForm").serialize(), function(response) {
            console.log("før obj!");
            var obj = $.parseJSON(response);
            console.log("Etter OBJ!");
            if (!obj.success) {
                console.log("Success, NNAAAT!");
                $("#loginBox").fadeOut(500);
                notify(obj.error);
            } else {
                console.log("Success!");
                $("#loginBox").slideUp(500);
                $(".X").slideUp(500);
                $(".lBtn").html('<div>Logg ut</div>');
                $(".lBtn").attr('href', '?mAct=logout');
                $(".lBtn").attr('id', 'logout-link');
                $(".headerpart-2").find('h3').html("" + obj.name);
                $(".headerpart-2").addClass("disabled");
                $(".headerpart-2, .lBtn").off('click');
                $(".headerpart-2").click(function() {
                    return false;
                });
                updateGUI();
            }
        });
        return false;
    })

    $("#regEmail").keyup(function(event) {

        var email = this.value;

        if (email.length > 5) {
            var urlen = "?m=users&aAct=JSONcheckEmail";
            var data = {
                "email" : email
            };
            $.post(urlen, data, function(response) {
                var obj = $.parseJSON(response);
                if (obj.legal) {
                    $("#regEmail").css('border-color', 'green');
                    $("#regEmail").css('border-width', '2px');
                } else {
                    $("#regEmail").css('border-color', 'red');
                    $("#regEmail").css('border-width', '2px');
                }
            });

        }

        if (email.length == 0) {
            $("#regEmail").css('border-color', 'red');
            $("#regEmail").css('border-width', '2px');
        }
    });

    $("#quickRegForm").submit(function() {

        $("input").closest('li').find('span').hide();

        var urlen = "?m=users&aAct=JSONquickReg";
        $.post(urlen, $("#quickRegForm").serialize(), function(response) {
            var obj = $.parseJSON(String(response));
            if (obj.success) {
                $("#qRegister").slideUp();
                $(".X").slideUp();
                notify("Du er nå registrert, aktiveringsmail er på tur til din innbox!");
            } else {
                if (obj.ex) {
                    notify(obj.ex);
                }

                if (obj.errors.firstname) {
                    $("input[name=firstname]").closest('li').find('span').attr('title', obj.errors.firstname).show();
                }

                if (obj.errors.lastname) {
                    $("input[name=lastname]").closest('li').find('span').attr('title', obj.errors.lastname).show();
                }

                if (obj.errors.email) {
                    $("input[name=email]").closest('li').find('span').attr('title', obj.errors.email).show();
                }
                if (obj.errors.password) {
                    $("input[name=password]").closest('li').find('span').attr('title', obj.errors.password).show();
                }

                if (obj.errors.birthdate) {
                    $("input[name=birthdate]").closest('li').find('span').attr('title', obj.errors.birthdate).show();
                }

                if (obj.errors.telephone) {
                    $("input[name=telephone]").closest('li').find('span').attr('title', obj.errors.telephone).show();
                }

                if (obj.errors.zipcode) {
                    $("input[name=zipcode]").closest('li').find('span').attr('title', obj.errors.zipcode).show();
                }

                if (obj.errors.streetadress) {
                    $("input[name=streetadress]").closest('li').find('span').attr('title', obj.errors.streetadress).show();
                }

                if (obj.errors.acceptTerms) {
                    $("input[name=acceptTerms]").closest('li').find('span').attr('title', obj.errors.acceptTerms).show();
                }
            }
        });
        return false;
    });

    $("#notifyClose").click(function() {
        $("#notify").fadeOut();
        return false;
    });

    $(".X").click(function() {
        $(this).fadeOut(10);
        $(".formBox").children().slideUp();

        return false;
    });

    $("#forgotPswBtn").click(function() {
        showForm("#forgotPsw");
        // $("#loginBox").fadeOut(function(){
        //    $("#forgotPsw").fadeIn();
        //});

        return false;
    });

    $("#login-link").click(function() {
        showForm("#loginBox");
        return false;
    });

    $(".applytocrew").click(function() {
        showForm("#applicationForm");
        return false;
    });

    $("#application").submit(function() {
        $("input").closest('li').find('span').hide();
        var urlen = "?m=users&aAct=JSONcrewApplication";
        $.post(urlen, $("#application").serialize(), function(response) {

            var obj = $.parseJSON(response);
            if (obj.success) {
                $("#applicationForm").fadeOut();
                notify(obj.msg);
            } else {
                if (obj.errors.firstname) {
                    $("input[name=firstname]").closest('li').find('span').attr('title', obj.errors.firstname).show();
                    notify(obj.errors.firstname);
                }

                if (obj.errors.lastname) {
                    $("input[name=lastname]").closest('li').find('span').attr('title', obj.errors.lastname).show();
                    notify(obj.errors.lastname);
                }

                if (obj.errors.email) {
                    $("input[name=email]").closest('li').find('span').attr('title', obj.errors.email).show();
                    notify(obj.errors.email);
                }
                if (obj.errors.byear) {
                    $("input[name=byear]").closest('li').find('span').attr('title', obj.errors.byear).show();
                    notify(obj.errors.byear);
                }

                if (obj.errors.what) {
                    $("input[name=what]").closest('li').find('span').attr('title', obj.errors.what).show();
                    notify(obj.errors.what);
                }

                if (obj.errors.why) {
                    $("input[name=why]").closest('li').find('span').attr('title', obj.errors.why).show();
                    notify(obj.errors.why);
                }
            }
            //notify(obj.msg);
        });
        return false;
    });

    $("#forgotPswForm").submit(function() {
        var email = this.elements[0].value;
        if (email != '') {
            var urlen = "?m=users&aAct=JSONforgot";
            $.post(urlen, $("#forgotPswForm").serialize(), function(response) {
                var obj = $.parseJSON(response);
                if (obj.success) {
                    $("#forgotPsw").fadeOut();
                }
                notify(obj.msg);
            });
        } else {
            notify('Du må skrive inn en e-postadresse');
        }
        return false;
    });

    // For registrering av foresatt fjern kommentering under
    //$("#completereg").submit(function(){
    //  var urlen = "?m=users&aAct=JSONcompleteReg";
    //  $.post(urlen, $("#cRegForm").serialize(), function(response){
    //    var obj = $.parseJSON(response);
    //    if (obj.success)
    //    {
    //        $("#completereg").fadeOut(500);
    //        notify('Foresatt lag til, e-post på tur.');
    //    }
    //     else
    //      {
    //           notify('Noe gikk galt.');
    //        }
    //    });
    //    return false;
    //});

    //$(".cRegBtn").click(function(){
    //    eventReserveSeatClick(this.id);
    //});

    //$("#cRegForm").submit(function(){
    //    var urlen = "?m=users&aAct=JSONcompleteReg";
    //    $.post(urlen, $("#cRegForm").serialize(), function(response){
    //        var obj = $.parseJSON(response);
    //        if (obj.success)
    //        {
    //            $("#completereg").fadeOut();
    //        }
    //        notify(obj.msg);
    //    });
    //    return false;
    //});

    $("body").on("submit", ".reserveSeatForm", function(event) {
        seatID = this.title;
        $("#f" + seatID).find("input[type='password']").addClass("loading");
        var urlen = '?m=reservations&aAct=JSONreserveSeat';
        $.post(urlen, $("#f" + seatID).serialize(), function(response) {
            var obj = $.parseJSON(response);
            if (obj.success) {
                $("#a" + seatID).attr('class', 'mapCurrentUser');
                updateGUI();
                notify('Du er nå plassert.');
            } else {
                $("#reserveSeat").fadeOut(500);
                notify(obj.error);
            }
        });
        event.preventDefault();
    });

    $("body").on("submit", ".removeRsvForm", function(event) {
        seatID = this.title;
        $("#f" + seatID).find("input[type='password']").addClass("loading");
        var urlen = '?m=reservations&aAct=JSONremoveReservation';
        $.post(urlen, $("#f" + seatID).serialize(), function(response) {
            var obj = $.parseJSON(response);
            if (obj.success) {
                $("#a" + seatID).attr('class', 'mapAvailable');
                updateGUI();
                notify('Reservasjon fjernet');
            } else {
                notify(obj.error);
            }
        });
        event.preventDefault();
    });

    function notify(msg) {
        $("#notify").find('h3').html('Hei!');
        $("#notify").find('p').html(msg);
        $("#notify").fadeIn(500);
    }


    $("body").on("click", "#liveModeOnBtn", function() {
        $('[data-update]').each(function() {
            alert('Live mode on');
            var self = $(this);
            var target = self.data('update');
            liveModeId = setInterval(function() {
                self.load(target);
            }, self.data('refresh-interval'));
            liveMode = true;
        });
    });

    $("body").on("click", "#liveModeOffBtn", function() {
        alert('Live mode off');
        window.clearInterval(liveModeId);
        liveMode = false;
    });

    $(".message").click(function(){
        $(".message").fadeOut(500);
    });

    function updateGUI() {
        $('[data-update]').each(function() {
            var self = $(this);
            var target = self.data('update');
            self.load(target);
        });
    }


    $("body").on("click", ".mapAvailable, .mapCurrentUser", function() {
        event.preventDefault();
    });
}); 