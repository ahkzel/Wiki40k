<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/style.css">
        <title>wiki40K - Factions</title>
    </head>

    <body>

        <header>
            <div class="header-container">
                <a href="index.php" class="retour-home">⬅ Accueil</a>

                <h1>Factions</h1>
                
                <div class="user-links">
                    <?php if (isset($_SESSION["emailU"])) : ?>
                        <a href="index.php?url=add-joueur">Ajouter un joueur</a>
                        <a href="index.php?url=deconnexion">Se déconnecter</a>
                    <?php else : ?>
                        <a href="index.php?url=create-account">Créer un compte</a>
                        <a href="index.php?url=connexion">Se connecter</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <nav class="accueil-nav">
            <ul>
                <li><a href="index.php?url=factions">Factions</a></li>
                <li><a href="index.php?url=personnages">Personnages</a></li>
                <li><a href="index.php?url=planetes">Planètes</a></li>
                <li><a href="index.php?url=shop">Boutique</a></li>
            </ul>
        </nav>

        <main>
            <div class="main-content-accueil">
                <?php foreach ($all_factions as $faction): ?>
                    <a href="index.php?url=faction-detail&faction_name=<?=$faction["nom"];?>" class="link-detail">
                        <div class="accueil-box">
                            <h2><?= htmlspecialchars($faction["nom"]); ?></h2>
                            <ul>
                                <li><b>Appartenance : </b><?= htmlspecialchars($faction["appartenance"]); ?></li>
                                <li><b>Influence : </b><?= htmlspecialchars($faction["influence"]); ?></li>
                                <li><b>age : </b><?= htmlspecialchars($faction["age"]); ?></li>
                                <li><b>bio : </b><?= htmlspecialchars($faction["bio"]); ?></li>
                            </ul>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2025 - Wiki40k, Axel Beaulieu-Luangkham. Tous droits réservés.</p>
        </footer>

    </body>
</html>