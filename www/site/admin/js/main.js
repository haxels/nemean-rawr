/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 14.04.12
 * Time: 00:49
 * To change this template use File | Settings | File Templates.
 */

var isShowing = false;
var isToggled = false;

$(document).ready(function() {


    $("#artImage").bind('click focusin', function() {
        $("#imagePicker").fadeIn(500);
        return false;
    });

    $("#artImage").focusout(function() {
        $("#imagePicker").fadeOut(500);
        return false;
    });

    $("#filterBtn").click(function(){
        if (isShowing == false)
        {
            $("#filters").fadeIn(500);
            isShowing = true;
        }
        else
        {
            $("#filters").fadeOut(500);
            isShowing = false;
        }
    });

    $("#search").keyup(function(){
        s2(this.value);
    });

    $("#uploadBtn").click(function(){
       window.open('admin.php?m=articles&qAct=upload', 'Last opp fil..');
    });

    $("a.listed_file").click(function(){
        $("#artImage").val(this.id);
        $("#imagePicker").fadeOut(500);
        return false;
    });

    $("#tglActive").click(function(){
       $("td.active").each(function(index, td){
           var val = $(td).text();
           if (val == 1 && !isToggled)
           {
               $(td).parent('tr').css('display', 'table-row');
           }
           else if (val == 1 && isToggled)
           {
               $(td).parent('tr').css('display', 'none');
           }
           else if (val == 0 && !isToggled)
           {
               $(td).parent('tr').css('display', 'none');
           }
           else if (val == 0 && isToggled)
           {
               $(td).parent('tr').css('display', 'table-row');
           }
       });

        if (isToggled)
        {
            isToggled = false;
            $("#tglActive").text('Active');
        }
        else
        {
            isToggled = true;
            $("#tglActive").text('unactive');
        }

    });


    function s1(txt)
    {
        if (txt != '')
        {
            $("td.name").not(":contains('"+txt+"')").parent('tr').css('display', 'none');
            $("td.name:contains('"+txt+"')").parent('tr').css('display', 'table-row');
        }
        else
        {
            $("td.name").parent('tr').css('display', 'table-row');
        }
    }

    function s2(txt)
    {
        var t = txt.toLowerCase();
        $("td.name").each(function(index, td){
            var val = $(td).text().toLowerCase();
            if (val.indexOf(t) === -1)
            {
                $(td).parent('tr').css('display', 'none');
            }
            else
            {
                $(td).parent('tr').css('display', 'table-row');
            }
        });
    }

});