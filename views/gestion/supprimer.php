<section class="first">
    <div class="container">
        <div class="row">
            <form method="post" action="">
                <div class="col-lg-4 d-none d-sm-none d-md-none d-xl-block">
                    <label for="duree">Créaneau horaire concerné</label>
                    <select class="form-control" id="duree" name="duree">
                        <?php
                        var_dump($data);
                        var_dump($tableau_vues_donnees);
                        foreach ($data as $creneau) {
                            echo ('<option value="' . $creneau['codeDuree'] . '">' . $creneau['libDuree'] . '</option>');
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-4 d-none d-sm-none d-md-none d-xl-block">
                    <label for="categoprod">Produit concerné</label>
                    <?php
                    foreach ($data as $produit) {
                        echo ('<option value="' . $produit['categoprod'] . '">' . $produit['libCategoprod'] . '</option>');
                    }
                    ?>
                </div>
                <div class="col-lg-4 d-none d-sm-none d-md-none d-xl-block">
                    <a href="#"><img class="img-fluid" src="public/assets/images/pub-nouveautes.jpg" alt="Nouveautés"></a>
                </div>
                <input type="submit" class="btn btn-outline-danger" value="Supprimer">
        </div>
    </div>
</section>