<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/style.css">
        <title>wiki40K - Connexion</title>
    </head>

    <body>

        <header>
            <div class="header-container">
                <a href="index.php" class="retour-home">⬅ Accueil</a>
            </div>
        </header>

        <main>
            <form action="index.php?url=submit-connexion" method="POST" class="form-account">
                <h2>Se connecter</h2>

                <?php if (isset($_SESSION["error_msg"])) : ?>
                    <h3><?= htmlspecialchars($_SESSION["error_msg"]);?></h3>
                <?php endif; ?>

                <label for="email">Email :</label>
                <input type="email" id="email" name="emailU" required>

                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdpU" required>

                <button type="submit" class="submit-account">Valider</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2025 - Wiki40k, Axel Beaulieu-Luangkham. Tous droits réservés.</p>
        </footer>

    </body>
</html>