<?php

$user = $data['user'];
echo "hei";
var_dump($user);

?>


<div class="editUser">

<div id="accordion">
    
	<h3><a href="#">User info</a></h3>
	<div>
            
            <form>
                <ul>

                    <li><label>E-mail:</label><input type="email" name="email" required="required" value ="<?php echo $user->getContactInfo()->getEmail()?>"/> </li>

                    <li><button type=submit> Generate password </button></li>

                 
                    <button type=submit> Confirm changes </button>
                
                </ul>
            </form>
		
	</div>
        
        
	<h3><a href="#">Personal info</a></h3>
	<div>
            
            <form>
                <ul>

                    <li><label>First name:</label><input type="text" name="firstname" required="required"/> </li>

                    <li><label>Last name:</label><input type="text" name="lastname" required="required"/> </li>

                    <li><label>Birth date:</label><input type="date" name="bday" required="required"/> </li>
                    
                </ul>
            
                 <button type=submit> Confirm changes </button>
            </form>
		
	</div>
        
        
	<h3><a href="#">Contact info</a></h3>
	<div>
            
            <form>
                <ul>
                
                    <li><label>Telephone:</label><input type="number" name="tlfnumber" required="required"/> </li>

                    <li><label>Zip code:</label><input type="number" name="zipcode" required="required"/> </li>

                    <li><label>Street address:</label><input type="text" name="email" required="required"/> </li>

                </ul>
                
                <button type=submit> Confirm changes </button>
                 
                
                
            </form>
		
		
	</div>
        
        
	<h3><a href="#">Parent info</a></h3>
	<div>
            
            <form>
                <ul>
                
                <li><label>First name:</label><input type="text" name="pfirstname" required="required"/> </li>
            
                <li><label>Last name:</label><input type="text" name="plastname" required="required"/> </li>

                <li><label>E-mail:</label><input type="email" name="pemail" required="required"/> </li>

                <li><label>Telephone:</label><input type="number" name="ptlfnumber" required="required"/> </li>
            
                 <button type=submit> Confirm changes </button>
                
                </ul>
            </form>
		
	</div>
</div>
