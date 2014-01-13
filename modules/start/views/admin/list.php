<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 9/29/12
 * Time: 9:59 AM
 * To change this template use File | Settings | File Templates.
 */
echo date("d/m - Y, H:i:s");
?>
<br />
Nettside status: <img id="site_closed" rel="1" alt="<?php echo ($data['site_closed']) ? '0' : '1'; ?>" class="changeSetting" src="resources/site/img/admindesign/<?php echo ($data['site_closed']) ? 'red_circle' : 'green_circle'; ?>.png" width="24" height="24" />
<br />
Plasskart status: <img id="locked" rel="1" alt="<?php echo ($data['locked']) ? '0' : '1'; ?>" class="changeSetting" src="resources/site/img/admindesign/<?php echo ($data['site_closed']) ? 'red_circle' : 'green_circle'; ?>.png" width="24" height="24" />
<br />
Comporeg status:<!-- <button id="comporeg_open" rel="0" alt="<?php echo ($data['regOpen']) ? '0' : '1'; ?>" class="changeSetting"><?php echo ($data['regOpen']) ? 'Steng' : 'Åpne'; ?></button> -->
<img id="comporeg_open" class="changeSetting" rel="0" alt="<?php echo ($data['regOpen']) ? '0' : '1'; ?>" src="resources/site/img/admindesign/<?php echo ($data['regOpen']) ? 'green_circle' : 'red_circle'; ?>.png" width="24" height="24" />