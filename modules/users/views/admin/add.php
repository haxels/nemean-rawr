<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//telephone 	email 	firstname 	lastname 	streetaddress 	zipcode 	birthdate 	parent
?>
<h3>Add new user</h3>

<div id="simplereg">
    
    <form id="simplereg" method="post" action="">
        <fieldset>

            <legend>Register</legend>

            <ol>
                
            <li><label>First name:</label><input type="text" name="firstname" required="required"/> </li>
            
            <li><label>Last name:</label><input type="text" name="lastname" required="required"/> </li>

            <li><label>E-mail:</label><input type="email" name="email" required="required"/> </li>

            <li><label>Password:</label><input type="password" name="password" required="required"/></li>

            <li><label>Confirm password:</label><input type="password" name="confpassword" required="required"/></li>

            <li><label>Activate:</label><input type="checkbox" name="activated" required="required"/></li>

            <li><label>Paid:</label><input type="checkbox" name="paid" required="required"/></li>
            </ol>
        </fieldset>
        
        <input type="submit" name="submit" value="Confirm">
     </form>
</div>