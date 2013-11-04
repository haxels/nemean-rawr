<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 5/11/12
 * Time: 4:05 PM
 * To change this template use File | Settings | File Templates.
 */

$settings = $data['settings'];

foreach ($data['settings'] as $settings) :

    echo $settings->getValue();

endforeach;

?>