<?php
	/**
	 * Created by PhpStorm.
	 * User: Ragnar
	 * Date: 2/15/14
	 * Time: 8:20 PM
	 */
?>

	<li>
		<img title="<?php echo $data['mainCourse']->getName(); ?>"
			 src="site/img/ordericons/<?php echo $data['mainCourse']->getImage(); ?>"/>
		<span class="price"><?php echo $data['mainCourse']->getPrice(); ?></span>
	</li>
<?php foreach ($data['products'] as $product) : ?>
<li>
	<img title="<?php echo $product->getName(); ?>"
		 src="site/img/ordericons/<?php echo $product->getImage(); ?>"/>
	<span class="price"><?php echo $product->getPrice(); ?></span>
</li>
<?php endforeach; ?>

<?php echo $data['total']; ?>