<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 26.08.12
 * Time: 11:03
 * To change this template use File | Settings | File Templates.
 */
?>

<script>
    $(document).ready(function(){
        notify('<?php echo $data['msg']; ?>');

        function notify(msg)
        {
            $("#notifyMsg").html(msg);
            $("#notify").fadeIn(500).fadeOut(3000);
            //removeMask(3000);
        }
    });

</script>