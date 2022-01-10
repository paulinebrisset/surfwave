<section class="ouverture">
   <!-- <div class="d-none d-md-none d-block"> -->
   <div class="container-fluid">
      <div class="bloc location">
         <div class="row">
            <h2>Modifier les tarifs</h2>
         </div>
         <div class="row">
            <table class="table">
               <thead>
                  <tr>
                     <?php

                     //Impression de la liste des matériels dispos (libellés)
                     echo ('<th>Produit<br/>Temps </th>');
                     foreach ($option['libTarifs'] as $nomColonnes) {
                        echo ('<th>' . $nomColonnes . '</th>');
                     }

                     echo ('<th>MAJ les tarifs</th>');
                     ?>
                  </tr>
               </thead>
               <tbody>
                  <?php

                  echo ('<form method="post" action="">');
                  //$prix=$tableau_vues_donnees[1];
                  //impression de tous les tarifs
                  $counter = $prix[0]['libDuree']; //counter va retenir le libDuree, et changer si on est arrivé "au bout" d'un libDuree
                  echo ('<tr>');
                  echo ('<td>' . $prix[0]['libDuree'] . '</td>'); // Initialisation avec la première cellule, qui doit afficher "1 heure"

                  foreach ($prix as $location) {
                     //if/else doit déterminer si on complète une ligne commencée ou si on doit créer une nouvelle ligne dans le tableau

                     //tant qu'on parle toujours de la même durée de location = comparaison de deux chaînes de caractères
                     if (strcmp($location['libDuree'], $counter) == 0) {
                        echo ('<td>
                            <input name=' . $location['codeDuree'] . $location['categoProd'] . ' type="number" method="post" placeholder="' . $location['prixLocation'] . '">                        </td>');
                     } else {
                        //changement de duree de location
                        $counter = $location['libDuree'];
                        echo ('<td>
                    <button type="submit" class="btn btn-outline-danger">Modifier
                        </td>');
                        echo ('</tr><tr>');
                        echo ('<td>' . $location['libDuree'] . '</td>');
                        echo ('<td>
                     <input name=' . $location['codeDuree'] . $location['categoProd'] . ' type="number" method="post" placeholder="' . $location['prixLocation'] . '">                 </td>');
                     }
                  }
                  echo ('<td>
                            <input type="submit" class="btn btn-outline-danger" value="Modifier">
                        </td>');
                  echo ('</tr>');
                  echo ('</form>');
                  ?>
               </tbody>
            </table>
         </div>
      </div>
</section>