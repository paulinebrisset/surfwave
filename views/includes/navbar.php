<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="/public/assets/images/logo.png" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Boutique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Location</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cours de surf</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">L'histoire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <?php
                if (isset($_SESSION['utilisateur'])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/gestion">Gestion</a>
                    </li>
                <?php
                }
                ?>
            </ul>
            <form class="form-inline my-2 my-md-0">
                <input class="form-control" type="text" placeholder="Recherche" aria-label="Search">
            </form>
            <?php
            if (!(isset($_SESSION['utilisateur']))) {
                echo ('<button type="button" class="btn" id="ouvertureFenetreConnexion">Connexion</button>');
            } else {
                echo ('<form method="post" action="">
                <button type="submit" class="btn" name="deconnexion">Déconnexion</button>
          </form>');
            }
            ?>
        </div>
    </div>
</nav>