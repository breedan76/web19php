<?php
namespace src\Controller;

use src\Model\Article;
use src\Model\BDD;

class ArticleController extends AbstractController {

    public function Add(){
        if($_POST){
            $objArticle = new Article();
            $objArticle->setTitre($_POST["Titre"]);
            $objArticle->setDescription($_POST["Description"]);
            $objArticle->setDateAjout($_POST["DateAjout"]);
            $objArticle->setAuteur($_POST["Auteur"]);
            //Exécuter l'insertion
            $id = $objArticle->SqlAdd(BDD::getInstance());
            // Redirection
            header("Location:/article/show/$id");
        }else{
            return $this->twig->render("Article/add.html.twig");
        }


    }

    public function All(){
        $articles = new Article();
        $datas = $articles->SqlGetAll(BDD::getInstance());


        return $this->twig->render("Article/all.html.twig", [
            "articleList"=>$datas
        ]);
    }

    public function Show($id){
        $articles = new Article();
        $datas = $articles->SqlGetById(BDD::getInstance(),$id);

        return $this->twig->render("Article/show.html.twig", [
            "article"=>$datas
        ]);
    }

    public function Delete($id){
        $articles = new Article();
        $datas = $articles->SqlDeleteById(BDD::getInstance(),$id);

        header("Location:/Article/All");
    }

    public function Update($id){
        $articles = new Article();
        $datas = $articles->SqlGetById(BDD::getInstance(),$id);

        if($_POST){
            $objArticle = new Article();
            $objArticle->setTitre($_POST["Titre"]);
            $objArticle->setDescription($_POST["Description"]);
            $objArticle->setDateAjout($_POST["DateAjout"]);
            $objArticle->setAuteur($_POST["Auteur"]);
            $objArticle->setId($id);
            //Exécuter la mise à jour
            $objArticle->SqlUpdate(BDD::getInstance());
            // Redirection
            header("Location:/article/show/$id");
        }else{
            return $this->twig->render("Article/update.html.twig", [
                "article"=>$datas
            ]);
        }

    }

    public function Fixtures(){
        //Vider la table
        $article = new Article();
        $article->SqlTruncate(BDD::getInstance());

//Tableau "Jeu de donnée"
        $Titres = ["PHP en force", "Java en baisse", "JS un jour ça marchera", "Flutter valeur montante", "GO le futur"];
        $Prenoms = ["Rebecca", "Alexandre", "Emilie", "Léo", "Aegir"];
        $datedujour = new \DateTime();

        for($i = 0;$i < 200;$i++){
            $datedujour->modify("+1 day");
            shuffle($Titres);
            shuffle($Prenoms);

            //Objet Article
            $objArticle = new Article();
            $objArticle->setTitre($Titres[0]);
            $objArticle->setDescription("Ceci est une excellent description");
            $objArticle->setDateAjout($datedujour->format("Y-m-d"));
            $objArticle->setAuteur($Prenoms[0]);

            //Exécuter l'insertion
            $objArticle->SqlAdd(BDD::getInstance());
        }
        header("Location:/?controller=Article&action=All");
    }

}


function getDatabaseConnexion()
{
    try {
        $user = "root";
        $pass = "";
        $pdo = new PDO('mysql:host=localhost;dbname=tuto_php', $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}


// récupere tous les users
function getAllUsers()
{
    $con = getDatabaseConnexion();
    $requete = 'SELECT * from utilisateurs';
    $rows = $con->query($requete);
    return $rows;
}

// creer un user
function createUser($nom, $prenom, $age, $adresse)
{
    try {
        $con = getDatabaseConnexion();
        $sql = "INSERT INTO utilisateurs (nom, prenom, age, adresse)
VALUES ('$nom', '$prenom', '$age' ,'$adresse')";
        $con->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

//recupere un user
function readUser($id)
{
    $con = getDatabaseConnexion();
    $requete = "SELECT * from utilisateurs where id = '$id' ";
    $stmt = $con->query($requete);
    $row = $stmt->fetchAll();
    if (!empty($row)) {
        return $row[0];
    }

}

//met à jour le user
function updateUser($id, $nom, $prenom, $age, $adresse)
{
    try {
        $con = getDatabaseConnexion();
        $requete = "UPDATE utilisateurs set
nom = '$nom',
prenom = '$prenom',
age = '$age',
adresse = '$adresse'
where id = '$id' ";
        $stmt = $con->query($requete);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

// suprime un user
function deleteUser($id)
{
    try {
        $con = getDatabaseConnexion();
        $requete = "DELETE from utilisateurs where id = '$id' ";
        $stmt = $con->query($requete);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
