<?php
namespace src\Model;
class Categorie
{
    private $Id;
    private $libelle;
    private $icone;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }
    /**
     * @param mixed $Id
     * @return Article
     */
    public function setId($Id)
    {
        $this->Id = $Id;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getlibelle()
    {
        return $this->libelle;
    }
    /**
     * @param mixed $libelle
     * @return Article
     */
    public function setLibelle($libelle)
    {
        $this->Libelle = $libelle;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getIcone()
    {
        return $this->icone;
    }
    /**
     * @param mixed $icone
     * @return Article
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;
        return $this;
    }

    public function SqlDeleteById(\PDO $bdd, $Id){
        $requete = $bdd->prepare("DELETE FROM articles WHERE Id=:Id");
        $requete->execute([
            "Id" => $Id
        ]);
        return true;
    }
    public function SqlAdd(\PDO $bdd){
        try {
            $requete = $bdd->prepare("INSERT INTO categorie (libelle, icone) VALUES(:libelle, :icone)");
            $requete->execute([
                "libelle" => $this->getlibelle(),
                "icone" => $this->geticone(),
            ]);
            return $bdd->lastInsertId();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function SqlGetAll(\PDO $bdd){
        $requete = $bdd->prepare("SELECT * FROM categorie");
        $requete->execute();
        //$datas =  $requete->fetchAll(\PDO::FETCH_ASSOC);
        $datas =  $requete->fetchAll(\PDO::FETCH_CLASS,'src\Model\Categorie');
        return $datas;
    }
    public function SqlGetById(\PDO $bdd, $Id){
        $requete = $bdd->prepare("SELECT * FROM categorie WHERE Id=:Id");
        $requete->execute([
            "Id" => $Id
        ]);
        $requete->setFetchMode(\PDO::FETCH_CLASS,'src\Model\Categorie');
        $categorie = $requete->fetch();
        return $categorie;
    }
}