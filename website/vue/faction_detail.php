<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/style.css">
        <title>wiki40K - Faction Detail</title>
    </head>

    <body>

        <header>
            <div class="header-container">
                <a href="index.php" class="retour-home">⬅ Accueil</a>

                <h1><?=htmlspecialchars($active_faction["nom"]); ?></h1>

                <div class="user-links">
                    <?php if (isset($_SESSION["emailU"])) : ?>
                        <a href="index.php?url=add-joueur">Ajouter un joueur</a>
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
                <?php if (isset($active_faction)) :?>
                    <div class="detail-box">
                        <h2><?= htmlspecialchars($active_faction["nom"]); ?></h2>
                        <ul>
                            <li><b>Appartenance : </b><?= htmlspecialchars($active_faction["appartenance"]); ?></li>
                            <li><b>Influence : </b><?= htmlspecialchars($active_faction["influence"]); ?></li>
                            <li><b>Age : </b><?= htmlspecialchars($active_faction["age"]); ?></li>
                            <li><b>Bio : </b><?= htmlspecialchars($active_faction["bio"]); ?></li>
                            <li><a href="index.php?url=personnages&parent_faction=<?=$active_faction["nom"]?>">- Personnages relatifs à cette faction</a></li>
                            <li><a href="index.php?url=planetes&parent_faction=<?=$active_faction["nom"]?>">- Planètes relatives à cette faction</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2025 - Wiki40k, Axel Beaulieu-Luangkham. Tous droits réservés.</p>
        </footer>

    </body>
</html>