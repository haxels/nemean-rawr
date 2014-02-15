<?php
	/**
	 * Created by PhpStorm.
	 * User: Ragnar
	 * Date: 2/15/14
	 * Time: 8:20 PM
	 */
?>
<?php foreach ($data['products'] as $product) : ?>
<li>
	<img title="<?php echo $product->getName(); ?>"
		 src="site/img/ordericons/<?php echo $product->getImage(); ?>"/>
	<span class="price"><?php echo $product->getPrice(); ?></span>
</li>
<?php endforeach; ?>