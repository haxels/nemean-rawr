<div id="qRegister">
    <form id="quickRegForm" action="?m=users&act=qReg" method="POST">
        <h4>Registrering</h4>
        <hr />
        <div class="form-left">
            <li>
                <label for="firstname">Fornavn:</label>
                <input name="firstname" type="text" />
                <span class="hidden"></span>
            </li>
            <li>
                <label for="lastname">Etternavn:</label>
                <input name="lastname" type="text" />
                <span class="hidden"></span>
            </li>
            <li>
                <label for="email">E-post:</label>
                <input id="regEmail" type="email" name="email" required="required"/>
                <span class="hidden"></span>
            </li>
            <li>
                <label for="password">Passord:</label>
                <input type="password" name="password" required="required"/>
                <span class="hidden"></span>
            </li>
            <li>
                <label for="confpassword">Bekreft passord:</label>
                <input type="password" name="confpassword" required="required"/>
                <span class="hidden"></span>
            </li>
            <li>
                <label for="birthdate">Fødselsdato:</label>
                <input type="text" name="birthdate" required="required" placeholder="DD/MM/YYYY" />
                <span class="hidden"></span>
            </li>
            <li>
                <label for="telephone">Telefon:</label>
                <input type="text" name="telephone" required="required"/>
                <span class="hidden"></span>
            </li>
            <li>
                <label for="zipcode">Postnr:</label>
                <input type="text" name="zipcode" required="required" />
                <span class="hidden"></span>
            </li>
            <li>
                <label for="streetadress">Gateadresse:</label>
                <input type="text" name="streetadress" required="required"/>
                <span class="hidden"></span>
            </li>
            <li>
            <label for="acceptTerms">Jeg har lest, og godtar betingelsene:</label>
            <input  type="checkbox" id="okTerms" name="acceptTerms" value="1" required="required" />
            <span class="hidden"></span>
        </li>
        <li>
            <label>&nbsp;</label>
            <input class="btn" type="submit" id="submitQReg" name="submitQReg" value="Registrer"/>
        </li>
        </div>
        <div id="terms" class="form-right">
            <h3> Betingelser </h3>
            <p>
                For å opprette bruker i vårt system avhenger det av at du setter deg inn i, og godtar, de nedenforstående betingelser. Ved å hake av "Godta betingelser" samtykker du til følgende:
            </p>
            <ul>
                <li>
                    &bull; Bilder og video av deg kan brukes av Nemean i promoteringsøyemed
                </li>
                <br>

                <p>
                    &bull; Om dette ikke er ønskelig må det leveres skriftlig beskjed om dette.
                </p>
                <br>

                <p>
                    &bull; Om du er plassert i plasskartet idét det stenges, må du betale uansett om du ikke kommer på arrangementet
                </p>
                <br>

                <p>
                    &bull; Hvis du er under 18 år må registrere en foresatt dersom du ønsker å plassere deg i vårt plasskart. En epost vil da bli sendt til den aktuelle foresatte, der vedkommende må bekrefte at du får delta.
                </p>
                <br>

                <p>
                    &bull; Du er pliktig til å sette deg inn i Nemeans reglement.
                </p>
                <br>

                <p>
                    &bull; Nemean reserverer seg retten til å kunne endre på arrangementsreglene uten varsel - det er opp til den enkelte å holde seg oppdatert på dette (Ordensregler kan ikke ha tilbakevirkende kraft).
                </p>
                <br>

                <p>
                    &bull; Nemean tar vare på personlig informasjon (Adresse, telefonnummer osv.). Informasjonen vil brukes til å kontakte deltagere ved behov.
                </p>
                <br>

                <p>
                    &bull; Ditt fulle navn vises på vår nettside
                </p>
                <br>

            </ul>

        </div>
        
    </form>

</div>

<div id="forgotPsw">
	<h4>Glemt passord</h4>
        <hr />
        <div class="form-left">
    <form id="forgotPswForm" action="" method="POST"

        <p>
            Skriv inn din e-postadresse og du vil motta en e-post med et midlertidig passord.
        </p>

        <li>
            <label for="email">E-post:</label>
            <input name="email" type="text" />
        </li>
        <li>
            <label for="submitForgot1">&nbsp;</label>
            <input class="btn" name="submitForgot1" type="submit" value="Send" />
        </li>
    </form>
   </div>
   
    <div class="form-right"></div>
</div>

<div id="loginBox">
    <h4>Login</h4>
            <hr />
    <div class="form-left">
        <form id="loginBoxForm" action="" method="POST">
            
            <li>
                <label for="username">E-post:</label>
                <input name="username" type="text" autofocus="autofocus" />
            </li>
            <li>
                <label for="password">Passord:</label>
                <input name="password" type="password" />
            </li>
            <li>
                <label for="submit_login">&nbsp;</label>
                <input class="btn" name="submit_login" type="hidden" value="Logg inn" />
            </li>
            <li>
                <label for="submit_login">&nbsp;</label>
                <input class="btn" name="submit_login" type="submit" value="Logg inn" />
            </li>
        </form>
    </div>
    <div class="form-right"></div>
</div>

<div id="notify" class="message success">
    <h3></h3>
    <p></p>
</div>

<div id="completereg">

    <form id="cRegForm" action="" method="POST">
        <h4>Fullfør registrering</h4>
        <p>
            På grunn av din alder må du registrere en foresatt som ansvarlig for deg.
            Din foresatte vil motta en e-post med en bekrefelseslink. Du vil ikke kunne plassere deg før din
            foresatte har mottatt og besøkt bekreftelseslinken.
        </p>
        <hr />
        <li>
            <label>First name:</label>
            <input type="text" name="firstname" required="required"/>
        </li>

        <li>
            <label>Last name:</label>
            <input type="text" name="lastname" required="required"/>
        </li>

        <li>
            <label>Foresattes e-mail:</label>
            <input type="email" name="email" required="required"/>
        </li>

        <li>
            <label>Foresattes telefonnummer:</label>
            <input type="number" name="telephone" required="required"/>
        </li>
        <input id="cRegSID" name="seat_id" type="hidden" value="" />
        <li>
            <label for="submit_cReg">&nbsp;</label>
            <input name="submit_cReg" type="submit" value="Send" />
        </li>
    </form>
</div>

<div id="applicationForm">

    <form id="application" action="" method="POST">
        <h4>Søknadskjema for crewopptak</h4>
        <hr />
        <div class="form-left">
        <li>
            <label for="firstname">Fornavn:</label>
            <input name="firstname" type="text" />
            <span class="hidden"></span>
        </li>
        <li>
            <label for="lastname">Etternavn:</label>
            <input name="lastname" type="text" />
            <span class="hidden"></span>
        </li>

        <li>
            <label for="email">Epost:</label>
            <input name="email" type="text" />
            <span class="hidden"></span>
        </li>

        <li>
            <label for="byear">Fødselsår:</label>
            <input name="byear" type="text" />
            <span class="hidden"></span>
        </li>

        <li>
            <label for="why"><b>Hvorfor?</b></label>
            <br /><br />
            <textarea name="why" cols="78" rows="10"  placeholder="Hvorfor skal akkurat du være med i Nemean Crew? Ta med relevant utdanning eller andre erfaringer som du kan dra nytte av som Crew hos Nemean." ></textarea>
            <span class="hidden"></span>
        </li>
        <li>
        </li>

</div>
        <div class="form-right">
            <li> </li>
            <li></li>
            <li></li>
            <li></li>
        <li>
            <label for="what"><b>Hva?</b></label>
            <br /><br />
            <textarea name="what" cols="85" rows="10" placeholder="Hvis du blir med i Nemean Crew, hva ønsker du å gjøre? Gaming, kiosk, underholdning, web, foto, etc?  Hvis du ønsker Gaming, er det noen spill du behersker?" ></textarea>
            <span class="hidden"></span>
        </li>

        </div>
         <label>&nbsp;</label>
            <input class="btn" type="submit" id="submitCA" name="submitCA" value="Send"/>
    </form>

</div>


<div id="gMap">
    <!--<iframe 
        width="1100"
        height="400"
        frameborder="0"
        scrolling="no"
        marginheight="0"
        marginwidth="0"
        src="https://maps.google.com/?ie=UTF8&amp;ll=63.289217,9.088697&amp;spn=0.01794,0.066047&amp;t=m&amp;z=15&amp;output=embed">
    </iframe>
    <br />
    <small>
        <a
        href="https://maps.google.com/?ie=UTF8&amp;ll=63.289217,9.088697&amp;spn=0.01794,0.066047&amp;t=m&amp;z=15&amp;source=embed"
        style="color:#0000FF;text-align:left">Vis større kart</a>
    </small>-->

</div>

<div id="pMap"></div>

<div id="orderForm">
    <form id="order" action="" method="">
        <h4>Bestilling</h4>
        <hr />
        <div id="mainProducts" class="form-left">
            <h5>Hovedrett</h5>
            <a class="product" value="burger">
				<img title="Burger" src="site/img/ordericons/burger.png"/>
				<input value="1" name="products[]" hidden type="checkbox"/>
			</a>
            <a class="product" value="pizza">
				<img title="Pizza"  src="site/img/ordericons/pizza.png"/>
				<input value="18" name="products[]" hidden type="checkbox"/>
			</a>
        </div>
        <div class="form-right accessories">
            <div  class="burger" style="display:none;">
                <h5>Tilbehør</h5>
                <a class="product">
					<img title="Ost" src="site/img/ordericons/ost.png"/>
					<input name="products[]" hidden value="2" type="checkbox"/>
				</a>
                <a class="product">
					<img title="Mais"
						 src="site/img/ordericons/mais.png"/>
					<input name="products[]" value="3" hidden type="checkbox"/>
				</a>
                <a class="product">
					<img title="Tomat" src="site/img/ordericons/tomat.png"/>
					<input name="products[]" value="4" hidden type="checkbox"/>
				</a>
                <a class="product">
					<img title="Salat" src="site/img/ordericons/salat.png"/>
					<input name="products[]"value="17" hidden type="checkbox"/>
				</a>
                <a class="product">
					<img title="Dressing"
						 src="site/img/ordericons/dressing.png"/>
					<input name="products[]" value="23" hidden
						   type="checkbox"/>
				</a>
                <a class="product">
					<img title="Ketchup"
						 src="site/img/ordericons/ketchup.png"/>
					<input name="products[]" value="24" hidden
						   type="checkbox"/>
				</a>
            </div>

            <div class="pizza" style="display:none;">
                <h5>Tilbehør</h5>
                <a class="product"><img src="site/img/ordericons/ketchup.png"/>
					<input name="products[]" value="24" hidden
							  type="checkbox"/></a>
            </div>
        </div>
        <div id="total"></div>
		<hr />
        <input class="btn" type="submit" id="orderSubmit" name="orderSubmit" hidden value="Bestill"/>
    </form>

</div>
