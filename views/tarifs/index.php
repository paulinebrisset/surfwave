<section class="d-none d-md-none d-xl-block">
   <div class="container">
      <div class="bloc location">
         <h1>Vue Tarifs</h1>
         <h2>Location de materiel</h2>
         <div class="bloc-info row">
            <div class="col-lg-6">
               <img src="public/assets/images/planchesdesurf.jpg" alt="Planches de surf" class="img-fluid">

            </div>
            <div class="col-lg-6">
               <p>Nous proposons du matériel de location de qualité, avec un grand choix de planches de surf et de bodyboard ainsi que des combinaisons.<br /><br /> Tarifs : à partir de 7 €</p>
            </div>
         </div>
         <h2>Tarifs</h2>
         <table class="table">
            <thead>
               <tr>
                  <?php
                  //Impression de la liste des matériels dispos (libellés)
                  echo ('<th>Tarifs location</th>');
                  foreach ($option['libTarifs'] as $nomColonnes) {
                     echo ('<th>' . $nomColonnes . '</th>');
                  } ?>
               </tr>
            </thead>
            <tbody>
               <?php
               //impression de tous les tarifs

               $counter = $tarifs[0]['libDuree']; //counter va retenir le libDuree, et changer si on est arrivé "au bout" d'un libDuree
               echo ('<tr>');
               echo ('<td>' . $tarifs[0]['libDuree'] . '</td>'); // Initialisation avec la première cellule, qui doit afficher "1 heure"

               foreach ($tarifs as $location) {
                  //if/else doit déterminer si on complète une ligne commencée ou si on doit créer une nouvelle ligne dans le tableau

                  //tant qu'on parle toujours de la même durée de location = comparaison de deux chaînes de caractères
                  if (strcmp($location['libDuree'], $counter) == 0) {
                     echo ('<td>' . $location['prixLocation'] . '</td>');
                  } else {
                     //changement de duree de location
                     $counter = $location['libDuree'];
                     echo ('</tr><tr>');
                     echo ('<td>' . $location['libDuree'] . '</td>' .
                        '<td>' . $location['prixLocation'] . '</td>');
                  }
               }
               echo ('</tr>');
               ?>
            </tbody>
         </table>
      </div>
   </div>
</section>