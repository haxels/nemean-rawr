/**
 * Created with JetBrains PhpStorm.
 * User: Ragnar
 * Date: 1/31/13
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */
/*
    Nemean Javascript


*/

    /**
     * Nemean object
     *
     */
    var Nemean = {};
    N = Nemean;

/**
 * popup
 * @param selector
 */
    N.popup = function(selector, callback){
        callback();
        $(selector).fadeIn(500);
        addMask();
    }



/**
 *
 * @param selector
 * @param url
 * @param data
 */

    N.submit = function(formSelector, url, selector, type){
        $("span.error").html("");
        $.post(url, $(formSelector).serialize(), function(response) {
            formResponse(response, selector, type);
        });
    }

/**
 *
 * @param data
 * @param url
 * @param selector
 * @param type
 */
    N.post = function(data, url, selector, type){
        console.log(selector);
        $.post(url, data, function(response) {
            formResponse(response, selector, type);
        });
    }

/**
 *
 * @param selector
 * @param type
 * @param data
 */
    function action(selector, type, data){

        var s = ($.type(selector)==="string") ? $(selector) : selector;
        switch(type){

            case 'checkbox':
                s.attr('value', data.value);
                s.attr('checked', data.value);
                s.parent().stop().css('background-color', "green").animate({backgroundColor: "#FFFFFF"}, 5000);
                console.log('jaai');
                break;

            case 'update':

                s.html(data);
                break;

            case 'errors':

                for(var i =0; i<data.length; i++){
                   $(selector+" input[name="+data[i].field+"]").siblings('span.error.'+data[i].field).html(data[i].msg);
                }
                break;

            case 'deleteRow':

                s.slideUp();
                break;

            case 'remove':
                s.hide();
                s.remove();

            case 'removePopup':

            default:
                s.fadeOut(500);
                $(".adminPopup").fadeOut(500);
                removeMask();
                break;
        }

    }


 /**
 * notify
 * @param type
 * @param title
 * @param message
 */
    N.notify = function(){
        console.log("Notify!");
    }


function addMask()
{
    $("body").append('<div id="overlay"></div>');
    $("#overlay").fadeIn(300);
}
/**
 *
 * @param response
 * @param selector
 */

function formResponse(response, selector, type){
    var obj = $.parseJSON(response);
    var s = ($.type(selector)==="string") ? $(selector) : selector;
    if (obj.success)
    {
        action(selector, type, null);
        resetForms();
    }
    if(obj.errors)
    {
        action(selector, 'errors', obj.errors);
    }
    if(obj.html){
        action(obj.updateSelector, obj.type, obj.html);
    }
    if(obj.checkbox)
    {
        action(selector, 'checkbox', obj.checkbox);

    }
    N.notify();
    return false;

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

function resetForms(){
    $("form").each(function(){
        this.reset();
    });
}
