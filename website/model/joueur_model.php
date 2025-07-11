<?php
// on créé une classe dont on se servira pour appeler ses méthodes
class Joueur_model {
    private $pdo;

    public function __construct($pdo){
        // dans le construct, prend la variable pdo du controlleur pdo pour créer la connexion
        if (isset($pdo)) $this->pdo = $pdo;
    }

    public function get_players_by_emailU($emailU) {
        // cette fonction renvoie les joueurs associés à l'utilisateur emailU donné
        $result = array();

        try {
            $req = $this->pdo->prepare("select * from joueur where emailU = :emailU;");
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->execute();

            // on créé une boucle pour être sûr d'avoir tous les éléments séparés dans notre tableau result
            $a_player = $req->fetch(PDO::FETCH_ASSOC);
            while ($a_player) {
                $result[] = $a_player;
                $a_player = $req->fetch(PDO::FETCH_ASSOC);
            }
        }
        // renvoie le message d'erreur par défaut si erreur il y a
        catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function get_player_by_emailU_faction($emailU, $name_faction) {
        // cette fonction renvoie le joueur singulier dont l'emailU et la faction est donné
        try {
            $req = $this->pdo->prepare("select joueur.* from joueur inner join faction on faction.idF = joueur.idF where emailU = :emailU and faction.nom = :name;");
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->bindValue(':name', $name_faction, PDO::PARAM_INT);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return $result;
    }

    public function add_player($emailU, $name_faction, $pseudo, $pts) {
        // Cette fonction renvoie TRUE si elle réussi à ajouter le joueur à la table joueur avec les données données
        try {
            // Ici on va faire deux requêtes (car plus simple en terme de syntaxe) afin de d'abord récupérer l'id de la faction pour ensuite l'injecter dans l'insert into
            $req = $this->pdo->prepare("select idF from faction where nom = :name;");
            $req->bindValue(':name', $name_faction, PDO::PARAM_STR);
            $req->execute();
            $faction = $req->fetch(PDO::FETCH_ASSOC);

            if ($faction) {
                // Si la première opération s'est bien déroulée on récupère l'idF de la faction dans le tableau associatif
                $faction_idF = $faction['idF'];

                $req = $this->pdo->prepare("insert into joueur (emailU, idF, pseudo, pts) values (:emailU, :idF, :pseudo, :pts);");
                $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
                $req->bindValue(':idF', $faction_idF, PDO::PARAM_INT);
                $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                $req->bindValue(':pts', $pts, PDO::PARAM_INT);
                $req->execute();
            }
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return TRUE;
    }

    public function delete_player($emailU, $name_faction) {
        // Cette fonction renvoie TRUE si elle réussi à supprimer le joueur de la table joueur dont l'email et la faction sont donnés
        try {
            $req = $this->pdo->prepare("delete from joueur join faction on faction.idF = joueur.idF where joueur.emailU = :emailU and faction.nom = :name;");
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->bindValue(':name', $name_faction, PDO::PARAM_INT);
            $req->execute();
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return TRUE;
    }

    public function update_player_in_points($emailU, $name_faction, $pts) {
        // Cette fonction renvoie TRUE si elle réussi à update le joueur dont l'email et la faction sont donnés en lui attribuant
        // le nouveau nombre de point donné actualisé
        try {
            $req = $this->pdo->prepare("update joueur join faction on faction.idF = joueur.idF set pts = :pts where joueur.emailU = :emailU and faction.nom = :name;");
            $req->bindValue(':pts', $pts, PDO::PARAM_INT);
            $req->bindValue(':emailU', $emailU, PDO::PARAM_STR);
            $req->bindValue(':name', $name_faction, PDO::PARAM_INT);
            $req->execute();
        }
        catch (PDOException $e) {
            print($e->getMessage());
            die();
        }
        return TRUE;
    }

    public function testAll() {
        // fonction de test qui teste toutes les méthodes de la classe avec un exemple
        if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
            header('Content-type:text/plain');

            echo("Player email with faction Aeldari with get_player_by_emailU_faction() : \n");
            print_r($this->get_player_by_emailU_faction("email", "Aeldari"));

            echo "Add player email with faction Le Chaos with 4000 points and pseudo with add_player() : \n";
            print_r($this->add_player("email", "Le chaos", 4000, "pseudo"));

            echo "Delete player email with faction Le Chaos with delete_player() : \n";
            print_r($this->delete_player("email", "Le Chaos"));

            echo("Update player email with faction Aeldari to 5000 points with update_player_in_points() : \n");
            print_r($this->update_player_in_points("email", "Aeldari", 5000));
        }
    }
}
?>