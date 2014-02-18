
<?php foreach($data['reservations'] as $reservation) : ?>

    <div style="top:40%; margin: 0 auto; text-align: center;">
        <img src="site/img/logo.jpg" width="250px"/><br><br>
        <h4>Plass nummer</h4>
    <h1> <?php echo $reservation['reservation']->getSeatId(); ?></h1><br><br>
    <h4>Reservert til</h4>
        <h1><?php echo ($reservation['user'] instanceof User) ? $reservation['user']->getName() : 'Javell'; ?></h1><br><br>

        <h4>Velkommen!</h4>
          <p>  Velkommen til Nemean! Håper du får et fint opphold her hos oss. Skulle det være noe du lurer på er det bare
            å kontakte oss i Crew, og vi hjelper deg så godt vi kan! Vi vil også oppfordre deg til å klikke deg inn på
            www.nemean.no og lese gjennom vårt reglement.</p><br><br>
        <div style="color: gray;">
           <br> Nemean Crew
        </div>
    </div>
<br><br>
        <footer style ="text-align: center;">
            <img src="site/img/sponsorer/sparebankenHemne.jpg" width="167px"/> <em></em>
            <img src="site/img/sponsorer/hemnenett.jpg" width="167px"/><em></em>
            <img src="site/img/sponsorer/sagoyvaretaxi.jpg" width="167px"/><em></em>
            <img src="site/img/sponsorer/DI.jpg" width="167px"/><em></em>
            
        </footer>
    <pagebreak />

<?php endforeach; ?>

