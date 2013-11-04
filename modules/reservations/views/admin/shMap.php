<?php
/**
 * Created by JetBrains PhpStorm.
 * User: havardaxelsen
 * Date: 6/12/12
 * Time: 10:15 PM
 * To change this template use File | Settings | File Templates.
 */

$seatcount  = 192;
$rows       = 6;
$rowwidth   = 16;
$separator = true;
$inverted = true;


for($i = 1; $i <= $seatcount; $i++){


    echo   "X ";
                                                // Sjekker at plassnummer er delelig med radbredde. Dette viser om man er på slutten av ei rad eller ei

    if(($i%$rowwidth) == 0){

        //Sjekker om raden er odde- eller partall
        if(($i/$rowwidth)%2 == 0){
                               // Dette er partall, og dermet bare ett linjeskift
            echo ($inverted) ? '<br>' : '<br><br>';
        }
        else{
            echo ($inverted) ? '<br><br>' : '<br>';                               // Dette er oddetall, og dermet dobbelt linjeskift
        }
    }
    elseif ($i%($rowwidth/2) == 0 && $separator)
    {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    }


}
?>

