<?php
/**
 * Created by PhpStorm.
 * User: Ragnar
 * Date: 2/15/14
 * Time: 8:20 PM
 */
?>
<li>
<img title="<?php echo $data['product']->getName(); ?>"
	 src="site/img/ordericons/<?php echo $data['product']->getImage(); ?>"/>
	<span class="price"><?php echo $data['product']->getPrice(); ?></span>
</li>