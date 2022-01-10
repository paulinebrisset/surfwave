<section class="ouverture">
    <!-- <div class="d-none d-md-none d-block"> -->
    <div class="container-fluid">
        <div class="bloc location">
            <div class="row">
                <h2>Ajouter un nouveau tarif</h2>
            </div>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <?php
                            //Impression de la liste des matériels dispos (libellés)
                            echo ('<th>Durée</th>');
                            echo ('<th>Produit</th>');
                            echo ('<th>Nouveau tarifs</th>');
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="">
                            <?php

                            foreach ($tarifsManquants as $tarifManquant) {
                                //if/else doit déterminer si on complète une ligne commencée ou si on doit créer une nouvelle ligne dans le tableau
                                echo ('<tr>');
                                echo ('<td>' . $tarifManquant['libDuree'] . '</td>');
                                echo ('<td>' . $tarifManquant['libcategoProd'] . '</td>');
                                echo ('<td>
                            <input name=' . $tarifManquant['codeDuree'] . $tarifManquant['categoProd'] . ' type="number" method="post">
                            </td>');
                                echo ('</tr>');
                            }
                            ?>
                    </tbody>
                </table>
                <input type="submit" class="btn btn-outline-danger" value="Ajouter ces nouveaux tarifs">
                </form>
            </div>
        </div>
</section>