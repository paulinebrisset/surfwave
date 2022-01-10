<section class="ouverture">
    <div class="container">
        <div class="row">
            <h2>Sélectionner l'horaire et le produit pour lesquels vous voulez supprimer un tarif</h2>
            <form method="post" action="">
                <div class="labelFormGestion">
                    <label for="duree">Créaneau horaire concerné</label>
                    <select class="form-control" id="duree" name="duree">
                        <?php
                        foreach ($duree as $creneau) {
                            echo ('<option value="' . $creneau['codeDuree'] . '">' . $creneau['libDuree'] . '</option>');
                        }
                        ?>
                    </select>
                </div>
                <div class="labelFormGestion">
                    <label for="categoprod">Produit concerné</label>
                    <select class="form-control" id="categoprod" name="categoprod">

                    <?php
                    foreach ($categoprod as $produit) {
                        echo ('<option value="' . $produit['categoProd'] . '">' . $produit['libcategoProd'] . '</option>');
                    }
                    ?>
                </div>
                <div class="col-lg-4 d-none d-sm-none d-md-none d-xl-block">
                    <a href="#"><img class="img-fluid" src="public/assets/images/pub-nouveautes.jpg" alt="Nouveautés"></a>
                </div>
                <input type="submit" class="btn btn-outline-danger" value="Supprimer">
            </form>
        </div>
    </div>
</section>