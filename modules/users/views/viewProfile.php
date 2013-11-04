<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 17.07.12
 * Time: 23:29
 * To change this template use File | Settings | File Templates.
 */
$user = $data['user'];
?>

<div id="userProfile">
    <h3><?php echo $user->getName(); ?></h3>
    <button>Rediger</button><button>Slett reservasjon</button><button>Slett meg</button><br /> <br />
    <a href="?m=compos&act=view">Se compoer</a>
</div>