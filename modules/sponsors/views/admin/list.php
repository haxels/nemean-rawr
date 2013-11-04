<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 20.06.12
 * Time: 16:16
 * To change this template use File | Settings | File Templates.
 */

?>
<a href="?m=sponsors&act=addSponsor">Add new sponsor</a>
<table>
    <tr>
        <td>Name</td>
        <td>Image</td>
        <td>Link</td>
        <td>Operations</td>
    </tr>
<?php foreach ($data['sponsors'] as $sponsor) : ?>
    <tr>
        <td><?php echo $sponsor->getName(); ?></td>
        <td><?php echo $sponsor->getImage(); ?></td>
        <td><?php echo $sponsor->getLink(); ?></td>
        <td>
            <a href="?m=sponsors&act=editSponsor&sID=<?php echo $sponsor->getSponsorId(); ?>">Edit</a> |
            <a href="?m=sponsors&act=deleteSponsor&sID=<?php echo $sponsor->getSponsorId(); ?>">Delete</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>