<div id="viewUser" class="adminPopup">
    <button type="button" class="close x" >&times;</button>
    <div id="responseHolder"></div>
</div>


<div id="addUser" class="adminPopup">
    <button type="button" class="close x">&times;</button>
    <form id="addUserForm" method="" action="">
        <fieldset class="span8">

            <legend>Register</legend>
            <label>First name:</label><input type="text" name="firstname" required="required"/>
            <span class="error firstname"></span>
            <label>Last name:</label><input type="text" name="lastname" required="required"/>
            <span class="error lastname"></span>

            <label>E-mail:</label><input type="email" name="email" required="required"/>
            <span class="error email"></span>

            <label>Password:</label><input type="password" name="pass1" required="required"/>
            <span class="error pass1"></span>

            <label>Confirm password:</label><input type="password" name="pass2" required="required"/>
            <span class="error"></span>

            <label>Activate:</label><input type="checkbox" name="activated"/>
            <span class="error activated"></span>

            <label>Paid:</label><input type="checkbox" name="paid"/>
            <span class="error paid"></span>

            <hr />

            <input class="btn btn-primary" type="submit" name="submit" value="Lagre">
        </fieldset>

    </form>
</div>