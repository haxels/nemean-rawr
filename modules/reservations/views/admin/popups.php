<div id="regGuest" class="adminPopup">
<form  id="regGuestForm" action="" method="">

    <button type="button" class="close x" >&times;</button>
    <fieldset class="span8">
    <legend>Registrer gjest</legend>

        <label>Navn: </label>
        <input name="name" type="text" />
       <span class="error name"></span>
<br><hr>
        <input class="btn btn-primary" type="submit" name="submit" value="Registrer" />
    </fieldset>
</form>
</div>


<div id="regReservation" class="adminPopup topPopup">
    <form id="regReservationForm" action="" method="">
        <button type="button" class="close x" >&times;</button>
        <fieldset class="span8">
        <legend>  Reserver plass</legend>
            <label>Plassnummer: </label>
            <input id="id" name="seat_id" type="text" />
            <span class="error seat_id"></span>

            <label>Bruker:</label>

            <input class="userSearch" type="text" />
            <input class="userSearch-id" name="user_id" type="hidden" /><br>
            <span class="error user_id"></span>
    <hr>
            <input class="btn btn-primary" type="submit" name="submit" value="Registrer" />
        </fieldset>
    </form>
</div>



<div id="viewUser" class="adminPopup">
    <button type="button" class="close x" >&times;</button>
    <div id="responseHolder"></div>
</div>


    <div id="rsvSettings" class="adminPopup">
        <button type="button" class="close x" >&times;</button>
        <div id="settings">

        </div>
    </div>
