(function($){

    $.confirm = function(params){

        if($('#confirmOverlay').length){
            // A confirm is already shown on the page:
            return false;
        }

        var buttonHTML = '';
        buttonHTML += '     <a href="#" class="btn btn-danger" action="yes()">Ja<span></span></a>';
        buttonHTML += '     <a href="#" class="btn" action="no()">Nei<span></span></a>';
        $.each(params.buttons,function(name,obj){

            // Generating the markup for the buttons:
            console.log(obj);



            if(!obj.action){
                obj.action = function(){};
            }
        });

        var markup = [
            '<div id="confirmOverlay">',
            '<div id="confirmBox" class="adminConfirm">',
            '<fieldsetclass="span5"><legend>',params.title,'</legend>',
            '<p>',params.message,'</p>',
            '<div id="confirmButtons">',
            buttonHTML,
            '</div></div></div></fieldset>'
        ].join('');

        $(markup).hide().appendTo('body').fadeIn();

        var buttons = $('#confirmBox .btn'),
            i = 0;

        $.each(params.buttons,function(name,obj){
            buttons.eq(i++).click(function(){

                // Calling the action attribute when a
                // click occurs, and hiding the confirm.

                obj.action();
                $.confirm.hide();
                return false;
            });
        });
    }

    $.confirm.hide = function(){
        $('#confirmOverlay').fadeOut(function(){
            $(this).remove();
        });
    }

})(jQuery);