<?php
/**
 * Created by PhpStorm.
 * User: Ragnar
 * Date: 1/26/14
 * Time: 8:55 PM
 */
?>

<?php foreach ($data['products'] as $product) : ?>

	<div><?php echo $product->getName(); ?></div>

<?php endforeach; ?>