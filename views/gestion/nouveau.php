<section class="ouverture">
    <!-- <div class="d-none d-md-none d-block"> -->
    <div class="container">
        <div class="bloc gestion">
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
                            <input name=' . $tarifManquant['codeDuree'] . $tarifManquant['categoProd'] . ' type="number" step="0.01" method="post">
                            </td>');
                                echo ('</tr>');
                            }
                            ?>
                    </tbody>
                </table>
                <input type="submit" class="btn btn-outline-danger btngtn" value="Ajouter ces nouveaux tarifs">
                </form>
                <form action="/gestion">
                    <button type="submit" class="btn btn-outline-danger btngtn">Retour vers l'interface de gestion</button>
                </form>
            </div>
        </div>
</section>