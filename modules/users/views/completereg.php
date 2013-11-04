<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//telephone 	email 	firstname 	lastname 	streetaddress 	zipcode 	birthdate 	parent
?>

<div id="completereg">
    
    <form id="completereg" method="post">
        <fieldset>

            <legend>Register</legend>

            <ol>
                
            <li><label>First name:</label><input type="text" name="firstname" required="required"/> </li>
            
            <li><label>Last name:</label><input type="text" name="lastname" required="required"/> </li>

            <li><label>E-mail:</label><input type="email" name="email" required="required"/> </li>

            <li><label>Password:</label><input type="password" name="password" required="required"/></li>

            <li><label>Confirm password:</label><input type="password" name="confpassword" required="required"/></li>
            
            <li><label>Birth date:</label><input type="date" name="bday" required="required"/> </li>
            </ol>
        </fieldset>
        
        <fieldset>

            <legend>Contact</legend>

            <ol>
            
                
            <li><label>Telephone:</label><input type="number" name="tlfnumber" required="required"/> </li>
            
            <li><label>Zip code:</label><input type="number" name="zipcode" required="required"/> </li>

            <li><label>Street address:</label><input type="text" name="email" required="required"/> </li>

            </ol>
        </fieldset>
        
        <fieldset>

            <legend>Parent</legend>

            <ol>
            
                
            <li><label>First name:</label><input type="text" name="pfirstname" required="required"/> </li>

                <li><label>Last name:</label><input type="text" name="plastname" required="required"/> </li>

                <li><label>E-mail:</label><input type="email" name="pemail" required="required"/> </li>

                <li><label>Telephone:</label><input type="number" name="ptlfnumber" required="required"/> </li>
            
            </ol>
        </fieldset>
        
        <button type=submit> Register </button>
     </form>
</div>