
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
                  //Impression de la liste des matériels dispos
                  echo ('<th>Tarifs location</th>');
                  for ($i = 0; $i < 3; $i++) {
                     echo ('<th>' . $tarifs[$i]['libCategoProd'] . '</th>');
                  } 
                  echo ('<th></th>');
                  ?>
               </tr>
            </thead>
            <tbody>
               <?php
               //impression de tous les tarifs

               // Initialisation avec la première cellule, qui doit afficher "1 heure"
               $counter = $tarifs[0]['libDuree'];
               echo ('<tr>');
               echo ('<td>' . $tarifs[0]['libDuree'] . '</td>');
               foreach ($tarifs as $location) {
                  //tant qu'on parle toujours de la même durée de location -> comparaison de deux chaînes de caractères
                  if (strcmp($location['libDuree'], $counter) == 0) {
                     echo (
                        '<td>' . $location['prixLocation'].
                        '
                     <form method="post" action="gestion/modifier/'.$location["codeDuree"].$location['categoProd'].'"><input type="submit" class="btn btn-outline-danger" value="Modifier"></form>
                </td>');
                  } else {
                    echo ('<td>' . $location['prixLocation'] .
                    '<form method="post" action="gestion/modifier/'.$location["codeDuree"].$location['categoProd'].'"><input type="submit" class="btn btn-outline-danger" value="Modifier"></form>
                    </td>');
                     $counter = $location['libDuree'];
                     echo ('</tr><tr>');
                     echo ('<td>' . $location['libDuree'] . '</td>' .
                        '<td>' . $location['prixLocation'] . '</td>');
                  }
               }
               ?>
            </tbody>
         </table>
      </div>
   </div>
</section>
