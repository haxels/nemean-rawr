<a id="a<?php echo $seat_id; ?>" class="mapCurrentUser" href="">&nbsp;&nbsp;
    <span class="info">
        <form id="f<?php echo $seat_id; ?>" class="removeRsvForm" action="" method="POST">
            <h2>Plass <?php echo $seat_id;?></h2>
            <p>
                Skriv inn ditt passord for å kansellere din reservasjon.
            </p>
            <hr />
            <li>
                <label for="psw">Passord:</label>
                <input name="psw" type="password" autofocus="autofocus" />
            </li>
            <li>
                <label for="seatID">&nbsp;</label>
                <input name="seatID" type="hidden" value="<?php echo $seat_id; ?>" /> 
            </li>
            <li>
                <label for="submit_reserve">&nbsp;</label>
                <input title="<?php echo $seat_id; ?>" class="removeRsvBtn" name="submit_reserve" type="submit" value="Slett" />
            </li>
        </form>
    </span>
</a>