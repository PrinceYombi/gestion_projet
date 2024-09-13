<?php

class projectLayer{

    private $connexion;

    function __construct(){

        try {
            $host = HOST_NAME;
            $dbname = DB_NAME;
            $root = ROOT;
            $password = PASSWORD;
            $this->connexion = new PDO("mysql:host=$host;dbname=$dbname", $root, $password);

            //echo 'connexion réussi';
        } catch (\PDOException $th) {
            //throw $th;
            $th->getMessage();
        }
    }

    /**
     * CREATE USERS
     */
    function createUsers($pseudo, $email, $password, $status){

        $sql = "INSERT INTO utilisateurs (pseudo, email, password, status) VALUES(:pseudo, :email, :password, :status)";

        try {
            
            $result = $this->connexion->prepare($sql);
            
            $var = $result->execute(array(
                ":pseudo"=>$pseudo,
                "email"=>$email,
                "password"=>sha1($password),
                ":status"=>$status
            ));

            if ($var) {
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (PDOExeption $th) {
            return NULL;
        }
    }

    /**
     * GET USER BY ID
     */
    function getUsers(){

        $sql = "SELECT * FROM utilisateurs";

        try {
            
            $result = $this->connexion->prepare($sql);
            
            $result->execute(array());

            $dataUser = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($dataUser) {
                unset($dataUser[0]['password']);
                return $dataUser;
            }else{
                return FALSE;
            }

        } catch (PDOExeption $th) {
            return NULL;
        }
    }

    /**
     * GET USER BY ID
     */
    function getUserById($id){

        $sql = "SELECT * FROM utilisateurs WHERE id=:id";

        try {
            
            $result = $this->connexion->prepare($sql);
            
            $result->execute(array(
                ":id"=>$id
            ));

            $dataUser = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($dataUser) {
                unset($dataUser[0]['password']);
                return $dataUser[0];
            }else{
                return FALSE;
            }

        } catch (PDOExeption $th) {
            return NULL;
        }
    }

    /**
     * AUTHENTIFICATION DE L'USER
     * email et mot de passe
     */
    function authenUser($email, $password){

        $sql = "SELECT * FROM utilisateurs WHERE email=:email";

        try {
            
            $result = $this->connexion->prepare($sql);
            $result->execute(array(
                ":email"=>$email
            ));

            $dataUser = $result->fetchAll(PDO::FETCH_ASSOC);

           if (isset($dataUser[0])) {

                if ($dataUser[0]['password'] === sha1($password)) {
                    
                    unset($dataUser[0]['password']);
                    return $dataUser[0];
                }else{
                    return NULL;
                }
           }

        } catch (PDOExeption $th) {
            return NULL;
        }
    }

    /**
     * METTRE A JOUR LE COMPTE UTILISATEUR
     */
    function updateUserCompte($newCompte){

        $sql = "UPDATE utilisateurs SET ";
        
        $id = $newCompte['id'];
        unset($newCompte['id']);

        try {

            foreach ($newCompte as $key => $value) {
                $value = addslashes($value);
                $sql .= " $key = '$value' ,";
            }

            $sql = substr($sql,0,-1);
            $sql .= " WHERE id=:id";
             //print_r($sql);exit();
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ":id"=>$id
            ));

            if ($var) {
                return TRUE;
            }else{
                return FALSE;
            }


        } catch (\PDOException $th) {
            //throw $th;
            $th->getMessage();
        }


    }

      /**
     * REQUETTE DE CERATION D'UN PROJET
     */
    function createProjet($nom, $description, $date_debut, $date_fin, $image_name, $image_tmp){

        $sql = "INSERT INTO `projets` (`nom`, `description`, `date_debut`, `date_fin`, `image_name`, `image_tmp`) VALUES(:nom, :description, :date_debut, :date_fin, :image_name, :image_tmp)";

        try {
            
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ":nom"=>$nom,
                ":description"=>$description,
                ":date_debut"=>$date_debut,
                ":date_fin"=>$date_fin,
                ":image_name"=>$image_name,
                ":image_tmp"=>$image_name
            ));

            if ($var) {
                
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            return NULL;
        }
    }

    /**
     * REQUETTE DE RECUPERATION DES PROJETS
     */
    function getProjet($idProjet=NULL, $nom=NULL){

        $sql = "SELECT * FROM projets ";

        try {
            if (isset($idProjet)) {
                $sql .= "WHERE id = $idProjet";
            }
            if (isset($nom)) {
                $sql .= "WHERE nom = '$nom'";
            }
            $result = $this->connexion->prepare($sql);
            $result->execute(array());

            $dataProjet = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($dataProjet) {
                
                return $dataProjet;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            return NULL;
        }

    }

       /**
     * REQUETTE DE CERATION D'UNe TACHE
     */
    function createTache($projet_id, $nom_projet, $membre, $nom_tache, $description, $date_debut, $date_fin){

        $sql = "INSERT INTO `taches` (`projet_id`, `nom_projet`, `membre`, `nom_tache`, `description`, `date_debut`, `date_fin`) VALUES(:projet_id, :nom_projet, :membre, :nom_tache, :description, :date_debut, :date_fin)";

        try {
            
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ":projet_id"=>$projet_id,
                ":nom_projet"=>$nom_projet,
                ":membre"=>$membre,
                ":nom_tache"=>$nom_tache,
                ":description"=>$description,
                ":date_debut"=>$date_debut,
                ":date_fin"=>$date_fin
            ));

            if ($var) {
                
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

      /**
     * REQUETTE DE RECUPERATION DES PROJETS
     */
    function getTaches($idTache=NULL, $membre=NULL){

        $sql = "SELECT * FROM taches ";

        try {
            if (isset($idTache)) {
                $sql .= "WHERE id = $idTache";
            }
            if (isset($membre)) {
                $sql .= "WHERE membre ='$membre'";
            }

            $result = $this->connexion->prepare($sql);
            $result->execute(array());

            $dataProjet = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($dataProjet) {
                
                return $dataProjet;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            return NULL;
        }

    }

    /**
     * FAIRE TACHE
     */
     function faiteTache($projet_id, $tache_id, $membre_id, $progression){

        $sql = "INSERT INTO faite_tache (projet_id, tache_id, membre_id, progression) VALUES(:projet_id, :tache_id, :membre_id, :progression)";

        try {
            
            $result = $this->connexion->prepare($sql);
            
            $var = $result->execute(array(
                ":projet_id"=>$projet_id,
                ":tache_id"=>$tache_id,
                ":membre_id"=>$membre_id,
                ":progression"=>$progression
            ));

            if ($var) {
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (PDOExeption $th) {
            return NULL;
        }
    }

        /**
     * REQUETTE DE RECUPERATION FAIRE TACHE
     */
    function getFaiteTache($tache_id){

        $sql = "SELECT * FROM faite_tache WHERE tache_id= :tache_id";

        try {

            $result = $this->connexion->prepare($sql);
            $result->execute(array(":tache_id"=>$tache_id));

            $dataProjet = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($dataProjet) {
                
                return $dataProjet;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            return NULL;
        }

    }

       /**
     * METTRE A JOUR LA PROGRESSION
     */
    function updateProgression($tache_id, $progression){

        $sql = "UPDATE faite_tache SET  progression = :progression WHERE tache_id = :tache_id";

        try {

             //print_r($sql);exit();
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ":tache_id"=>$tache_id,
                ":progression"=>$progression
            ));

            if ($var) {
                return TRUE;
            }else{
                return FALSE;
            }


        } catch (\PDOException $th) {
            //throw $th;
            $th->getMessage();
        }


    }

    /**
     * COMMENTAIRE
     */
    function createComment($membre_id, $titre, $content){

        $sql = "INSERT INTO comments (membre_id, titre, content) VALUES(:membre_id, :titre, :content)";

        try {
            
            $result = $this->connexion->prepare($sql);
            
            $var = $result->execute(array(
                ":membre_id"=>$membre_id,
                ":titre"=>$titre,
                ":content"=>$content
            ));

            if ($var) {
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (PDOExeption $th) {
            return NULL;
        }
    }
    
          /**
     * REQUETTE DE RECUPERATION DES COMMENTAIRES
     */
    function getComments(){

        $sql = "SELECT * FROM comments";

        try {

            $result = $this->connexion->prepare($sql);
            $result->execute(array());

            $dataProjet = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($dataProjet) {
                
                return $dataProjet;
            }else{
                return FALSE;
            }

        } catch (\Throwable $th) {
            return NULL;
        }

    }
}


