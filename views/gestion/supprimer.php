<section class="ouverture">
    <div class="container">
        <div class="bloc gestion">
            <div class="row">
                <h2>Suppression</h2>
            </div>
            <div class="row">
                <H3>Sélectionnez l'horaire et le produit pour lesquels vous voulez supprimer un tarif</h3>
            </div>
            <form method="post" action="">
                <div class="labelFormGestion row">
                    <label for="duree">Créaneau horaire concerné</label>
                    <select class="form-control" id="duree" name="duree">
                        <?php
                        foreach ($duree as $creneau) {
                            echo ('<option value="' . $creneau['codeDuree'] . '">' . $creneau['libDuree'] . '</option>');
                        }
                        ?>
                    </select>
                </div>
                <div class="labelFormGestion row">
                    <label for="categoprod">Produit concerné</label>
                    <select class="form-control" id="categoprod" name="categoprod">
                        <?php
                        foreach ($categoprod as $produit) {
                            echo ('<option value="' . $produit['categoProd'] . '">' . $produit['libcategoProd'] . '</option>');
                        }
                        ?>
                </div>
                <div class="row">
                    <input type="submit" class="btn btn-outline-danger btngtn" value="Supprimer">
                </div>
            </form>
            <div class="row">
                <form action="/gestion">
                    <button type="submit" class="btn btn-outline-danger btngtn">Retour vers l'interface de gestion</button>
                </form>
            </div>
        </div>
    </div>
</section>