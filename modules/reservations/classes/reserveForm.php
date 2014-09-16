<a id="a<?php echo $seat_id; ?>" class="mapAvailable">&nbsp;&nbsp;</a>
<span class="info">
    <form id="f<?php echo $seat_id; ?>" class="reserveSeatForm" title="<?php echo $seat_id; ?>"
          action="index.php" method="POST">
        <h2>Plass <?php echo $seat_id; ?></h2>
        <p>
            Skriv inn ditt passord for å reservere plassen.
        </p>
        <hr />
        <ol>
            <li>
                <label for="psw">&nbsp;</label>
                <input name="psw" type="password" autofocus="autofocus" placeholder="Passord..." value="" />
            </li>
            <li>
                <label for="seatID">&nbsp;</label>
                <input name="seatID" type="hidden" value="<?php echo $seat_id; ?>" />
            </li>
            <li>
                <label for="submit_reserve">&nbsp;</label>
                <input title="<?php echo $seat_id; ?>" class="reserveFormBtn" name="submit_reserve" type="submit" value="Reserver" />
            </li>
        </ol>
    </form>
</span>