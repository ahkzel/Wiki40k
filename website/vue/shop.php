<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/style.css">
        <title>wiki40K - Shop</title>
    </head>

    <body>

        <header>
            <div class="header-container">
                <a href="index.php" class="retour-home">⬅ Accueil</a>

                <h1>Boutique</h1>
                
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
            <div class="main-content-shop">
                <div class="shop-items">
                    <?php foreach ($available_sets as $set): ?>
                        <div class="shop-box">
                            <h3><?= htmlspecialchars($set["nom"]) ?></h3>
                            <p>Prix : <?= htmlspecialchars($set["prix"]) ?> €</p>
                            <p>Stock disponible : <?= htmlspecialchars($set["stock"]) ?></p>
                            <img src="<?= "/../assets/".$set["image"] ?>">
                            <form method="POST" action="index.php?url=add-set" method="POST">
                                <input type="hidden" name="name_set" value="<?= htmlspecialchars($set["nom"]) ?>">
                                <button type="submit" class="button-add-cart">Ajouter au panier</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-icon" onclick="toggleCart()">🛒 Panier</div>

                <div class="cart-content" id="cart" style="display: none;">
                    <h2>Mon Panier</h2>

                    <ul class="cart-items" id="cart-items">
                        <?php if (!empty($sets_to_cart)) : ?>
                            <?php foreach ($sets_to_cart as $set) : ?>
                                <li class="cart-item">
                                    <span class="set-name"><?= htmlspecialchars($set["nom"]) ?></span>
                                    
                                    <button class="button-quantity" onclick="updateQuantity('minus', <?= htmlspecialchars($set['idM']) ?>)">-</button>
                                    <span class="number-item" id="number-item-<?= htmlspecialchars($set["idM"]) ?>">1</span>
                                    <button class="button-quantity" onclick="updateQuantity('plus', <?= htmlspecialchars($set['idM']) ?>, <?= htmlspecialchars($set['stock']) ?>)">+</button>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li>Aucun set dans le panier.</li>
                        <?php endif; ?>
                    </ul>

                    <form method="POST" action="index.php?url=buy-shop">
                        <?php if (!empty($sets_to_cart)) : ?>
                            <?php foreach ($sets_to_cart as $set) : ?>
                                <input type="hidden" name="sets[<?= $set["idM"] ?>][nom]" value="<?= $set["nom"] ?>">
                                <input type="hidden" name="sets[<?= $set["idM"] ?>][quantite]" id="input-quantity-<?= $set["idM"] ?>" value="1">
                            <?php endforeach; ?>
                            <button type="submit" class="button-buy-all">Tout acheter</button>
                        <?php endif; ?>
                    </form>
                </div>

            </div>
        </main>

        <footer>
            <p>&copy; 2025 - Wiki40k, Axel Beaulieu-Luangkham. Tous droits réservés.</p>
        </footer>

        <script src="../assets/javascript/main.js"></script>
    </body>
</html>