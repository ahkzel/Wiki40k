<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/style.css">
        <title>wiki40K - Ajouter un joueur</title>
    </head>

    <body>

        <header>
            <div class="header-container">
                <a href="index.php" class="retour-home">⬅ Accueil</a>
            </div>
        </header>

        <main>
            <form action="index.php?url=submit-add-joueur" method="POST" class="form-account">
                <h2>Ajouter une faction que vous jouez</h2>

                <label for="choix-faction">Faction que vous voulez ajouter (unique) :</label>
                <select id="choix-faction" name="faction_joueur" required>
                    <option value="" disabled selected>-- Sélectionner une faction --</option>
                    <?php if (!empty($faction_names)) : ?>
                        <?php foreach ($faction_names as $faction_name) : ?>
                            <option value="<?= $faction_name ?>">
                                <?= $faction_name ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <label for="points">Points d'armée possédés (optionnel, par défaut : 0) :</label>
                <input type="text" id="points" name="points">

                <label for="played-factions">Factions déjà jouées :</label>
                <ul>
                    <?php if (!empty($factions_played)) : ?>
                        <?php foreach ($factions_played as $faction):?>
                            <li><?= htmlspecialchars($faction) ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <button type="submit" class="submit-add-joueur">Valider</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2025 - Wiki40k, Axel Beaulieu-Luangkham. Tous droits réservés.</p>
        </footer>

    </body>
</html>