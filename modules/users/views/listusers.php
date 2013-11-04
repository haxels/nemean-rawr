<?php // Trenger metode for å få inn array av brukere  !! ?>

<div id="listusers">
<table>
    <thead>
        <tr>
            <th>Navn</th>
            <th>Operasjoner</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data['users'] as $user) : ?>
        <tr>
            <td><?php echo $user->getName(); ?></td>
            <td align="center">
                <a href="">Edit</a> |
                <a href="">Slett</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</div>