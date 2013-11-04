
<?php include 'menu.php'; ?>
<h3>Reservasjonsliste</h3><br>
<div class="btn-group">
    <?php if (!isset($_GET['paid'])) : ?>
    <a class="btn" href="?m=reservations&paid=1">Vis betalte</a>
    <?php else : ?>
    <a class="btn" href="?m=reservations&paid=<?php echo (isset($_GET['paid']) && $_GET['paid'] == 0) ? 1 : 0; ?>">
        <?php echo (isset($_GET['paid']) && $_GET['paid'] == 0) ? 'Vis betalte' : 'Vis ikke-betalte'; ?>
    </a>
    <?php endif; ?>
    <a class="btn btn-popup" href="#regGuest">Registrer besøkende</a>
    <a class="btn btn-popup" href="#map">Reserver plass</a>
    <a class="btn btn-danger" href="?m=reservations&qAct=emptyReservations">Tøm reservasjonsliste</a>
</div>

<br>
    Antall gjester: <span id="guestAmount"> <?php echo $data['guests']; ?></span>


<table class="table table-hover table-bordered" id="p">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="95%">Navn</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['reservations'] as $reservation) :

        $user = $data['users'][$reservation->getSeatId()];
        ?>

        <?php if ($reservation->getType() == 0) : ?>
    <tr>
        <td class="SID"><?php echo $reservation->getSeatId(); ?></td>
        <td class="name" id="<?php echo $user->getName(); ?>"><?php echo $user->getName(); ?>
            <span class="operations">
                <div class="btn-group">
                    <a class="btn user-btn" id="v<?php echo $user->getUserId(); ?>" href="#" title="Vis bruker"><i class="icon-search"> </i></a>
                    <a class="btn delete-btn" id="<?php echo $reservation->getSeatId(); ?>" title="Slett reservasjon"><i class="icon-remove"> </i></a>
                   <!-- <a class="btn <?php echo ($user->isInRole(['Paid'])) ? 'unpay-btn' : 'pay-btn'; ?>" id="<?php echo $user->getUserId(); ?>" title="<?php echo ($user->isInRole(['Paid'])) ? 'Fjern som betalt' : 'Registrer som betalt'; ?>"><?php echo ($user->isInRole(['Paid'])) ? 'Unpay' : 'Pay'; ?></a> -->
                    <a title="<?php echo ($user->isInRole(array('Paid'))) ? 'Fjern betaling' : 'Registrer betaling'; ?>"class="btn <?php echo ($user->isInRole(['Paid'])) ? 'unpay-btn' : 'pay-btn'; ?>" id="<?php echo $user->getUserId(); ?>" href="#"><?php echo ($user->isInRole(array('Paid'))) ? '<i class="icon-thumbs-down"></i>' : '<i class="icon-thumbs-up"></i>'; ?></a>
                </div>
            </span>
        </td>
    </tr>
        <?php elseif ($reservation->getType() == 99) : ?>
    <tr>
        <td class="SID"><?php echo $reservation->getSeatId(); ?></td>
        <td class="name" id="<?php echo $user->getName(); ?>"><?php echo ($user instanceof User) ? $user->getName() : '';?><?php echo ' <i style="color:grey;">(Avventer aktivering av foresatt)</i>'; ?><span class="operations">
                <div class="btn-group">
                    <a class="btn user-btn" id="v<?php echo $user->getUserId(); ?>" href="#" title="Vis bruker"><i class="icon-search"> </i></a>
                    <a class="btn activate-btn" id="<?php echo $user->getUserId(); ?>" title="Aktiver reservasjon"><i class="icon-ok"> </i></a>
                    <a class="btn delete-btn" id="<?php echo $reservation->getSeatId(); ?>" title="Slett reservasjon"><i class="icon-remove"> </i></a>
                </div>
            </span>
        </td>
    </tr>

        <?php elseif ($reservation->getType() == 50) : ?>
    <tr>
        <td class="SID"><?php echo $reservation->getSeatId(); ?></td>
        <td class="name">Reservert av Admin
            <span class="operations">
        <div class="btn-group">
            <a class="btn delete-btn" id="<?php echo $reservation->getSeatId(); ?>" title="Slett reservasjon"><i class="icon-remove"> </i></a>
        </div>
        </span>
        </td>
    </tr>

        <?php else : ?>
    <tr>
        <td class="SID"><?php echo $reservation->getSeatId(); ?></td>
        <td class="name"><?php echo 'Locked'; ?>
            <span class="operations">
        <div class="btn-group">
            <a class="btn delete-btn" id="<?php echo $reservation->getSeatId(); ?>"><i class="icon-remove"> </i></a>
        </div>
        </span>
        </td>
    </tr>

        <?php endif; endforeach; ?>
    </tbody>
</table>

