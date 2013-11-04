<?php

$user = $data['user'];



?>


<div class="editUser">

<div id="accordion">
    
	<h3><a href="#">User info</a></h3>
	<div>
            
            <form method="post">
                <ul>

                    <li><label>E-mail:</label><input type="email" name="email" required="required" value ="<?php echo $user->getContactInfo()->getEmail()?>"/> </li>

                    <li><label>Old password:</label><input type="password" name="oldpassword" /></li>

                    <li><label>New password:</label><input type="password" name="password" /></li>

                    <li><label>Confirm password:</label><input type="password" name="confpassword" /></li>

                    <input type="submit" name="submit" value="Confirm">
                
                </ul>
            
		
	</div>
        
        
	<h3><a href="#">Personal info</a></h3>
	<div>
            
            
                <ul>

                    <li><label>First name:</label><input type="text" name="firstname" required="required" value="<?php echo $user->getFirstName()?>"/> </li>

                    <li><label>Last name:</label><input type="text" name="lastname" required="required" value="<?php echo $user->getLastName()?>"/> </li>

                    <li><label>Birth date:</label><input type="date" name="birthdate" required="required" value="<?php echo $user->getBirthdate()?>"/> </li>
                    
                </ul>
            
                 <input type="submit" name="submit" value="Confirm">
           
		
	</div>
        
        
	<h3><a href="#">Contact info</a></h3>
	<div>
            
            
                <ul>
                
                    <li><label>Telephone:</label><input type="number" name="tlfnumber" required="required" value="<?php echo $user->getContactInfo()->getTelephone()?>"/> </li>

                    <li><label>Zip code:</label><input type="number" name="zipcode" required="required" value="<?php echo $user->getContactInfo()->getAddress()->getZipLocation()->getZipCode()?>"/> </li>

                    <li><label>Street address:</label><input type="text" name="address" required="required" value="<?php echo $user->getContactInfo()->getAddress()->getStreetaddress()?>"/> </li>

                </ul>
                
                <input type="submit" name="submit" value="Confirm">
                 
                
                
            
		
		
	</div>
        
        
	<h3><a href="#">Parent info</a></h3>
	<div>
            
           
                <ul>
               
                <li><label>E-mail:</label> <input type="email" name="pemail" required="required" value="<?php echo $user->getParent()->getEmail()?>"/> </li>

                <li><label>Telephone:</label><input type="number" name="ptlfnumber" required="required" value="<?php echo $user->getParent()->getTelephone()?>"/> </li>
            
                <input type="submit" name="submit" value="Confirm">
                
                </ul>
            </form>
		
	</div>
</div>
</div>
