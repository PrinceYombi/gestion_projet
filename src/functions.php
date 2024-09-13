<?php

 function displayAccueil(){
    global $model;
    $getTaches = $model->getTaches(NULL, NULL);

    //print_r($getTaches); exit();

    $result = '<h1 class="my-3 text-center">Bienvenu à Prince Gestion_Projet</h1>';
    $result .='
            <table class="table my-3 mx-3">
                <thead>
                    <tr>
                    <th scope="col">Projets</th>
                    <th scope="col">Taches</th>
                    <th scope="col">Membres</th>
                    <th scope="col">Date debut/fin</th>
                    <th scope="col">Progression</th>
                    </tr>
                </thead>
                <tbody>';

    if (isset($getTaches)) {
       
        foreach ($getTaches as $key => $value) {
        
            $getFaiteTache = $model->getFaiteTache($value['id']);

            $result .='
                <tr>
                    <td>'.$value['nom_projet'].'</td>
                    <td>'.$value['nom_tache'].'</td>
                    <td>'.$value['membre'].'</td>
                    <td>'.$value['date_debut']." / ".$value['date_fin'].'</td>';
            if (isset($getFaiteTache[0])) {
                
                if ($getFaiteTache[0]['progression'] === "100%") {
                   
                    $result .= '
                        <td class="bg-success">'.$getFaiteTache[0]['progression']." - "."Terminée".'</td>
                    ';
                }else{

                    $result .= '
                    <td class="bg-warning">'.$getFaiteTache[0]['progression']." - "."En cours".'</td>
                ';
                }
            }else{
                $result .= '
                        <td class="bg-danger">Pas faite</td>
                    ';
            }
        }
    }
                    
    $result .='</tbody>
    </table>';

    return $result;
 }
//PAGE LOGIN
function displayLogin(){

    $result = '
       <div class="login-signin">
       <form method="POST" action="LoginAction">
            <div class="form-title">
                <h4>Se connecter</h4>
            </div>
            <div class="form-content">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="email" class="form-control" placeholder="Votre email" name="email" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Mot de passe</span>
                    <input type="password" class="form-control" placeholder="Votre mot de passe" name="password" aria-describedby="basic-addon1" required>
                </div>
                <button type="submit" class="btn btn-success mb-3">Connexion</button>
                <div class="inscription">
                    <p>Si vous n\'avez un compte, veuillez cliquer sur <a href="'.BASE_URL.SP."Signin".'">Inscription.</a></p>
                </div>
            </div>
        </form>
       </div>
    ';

    return $result;
}

//TRAITEMENT DE LA PAGE LOGIN
function displayLoginAction(){

    global $model;

    if (!empty($_POST)) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $authenUser = $model->authenUser($email, $password);

        if ($authenUser) {
            
            $_SESSION['user'] = $authenUser;
            return '<p class="btn btn-success">Connexion réussie</p>'.displayAccueil();
        }else{
            
            header("Location: ".BASE_URL.SP."Login"."");
        }
    }

}

//PAGE INSCRIPTION
function displaySignin(){

    $result = '
       <div class="login-signin">
       <form method="POST" action="SigninAction">
            <div class="form-title">
                <h4>S\'inscrire</h4>
            </div>
            <div class="form-content">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Pseudo</span>
                    <input type="text" class="form-control" placeholder="Entrer un pseudo" name="pseudo" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="email" class="form-control" placeholder="Entrer un email"  name="email" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Mot de passe</span>
                    <input type="password" class="form-control" placeholder="Definir un mot de passe"  name="password" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Status</label>
                    <select class="form-select" id="inputGroupSelect01" name="status" required>
                        <option selected>Choose...</option>
                        <option value="admin">Admin</option>
                        <option value="membre">Membre</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success mb-3">Inscription</button>
                <a class="btn btn-primary mb-3" href="'.BASE_URL.SP."Login".'">Retour</a>
            </div>
        </form>
       </div>
    ';

    return $result;
}

//PAGE MON COMPTE
function displayCompte(){

    $result = '
    <div class="compte">
    <form method="POST" action="UpdateUserCompte">
         <div class="form-title">
             <h4>Mon compte</h4>
         </div>
         <div class="form-content">
             <div class="input-group mb-3">
                 <span class="input-group-text" id="basic-addon1">Pseudo</span>
                 <input type="text" class="form-control" placeholder="Entrer un pseudo" name="pseudo" aria-describedby="basic-addon1"
                  value="'.$_SESSION['user']['pseudo'].'"
                 >
             </div>
             <div class="input-group mb-3">
                 <span class="input-group-text" id="basic-addon1">@</span>
                 <input type="email" class="form-control" placeholder="Entrer un email"  name="email" aria-describedby="basic-addon1"
                 value="'.$_SESSION['user']['email'].'"
                 >
             </div>
             <button type="submit" class="btn btn-success mb-3">Mettre à jour</button>
         </div>
     </form>
    </div>
 ';

 return $result;
}

//TRAITEMENT DE LA MISE A JOUR DU COMPTE UTILISATEUR
function displayUpdateUserCompte(){

    global $model;

    $_POST['id'] = $_SESSION['user']['id'];

    $updateUserCompte = $model->updateUserCompte($_POST);

    if ($updateUserCompte) {

        $_SESSION['user'] = $model->getUserById($_SESSION['user']['id']);

        $result = '<p class="btn btn-success">Mise à jour réussie</p>';
    }else{
        $result = '<p class="btn btn-danger">Mise à jour échoué</p>';
    }

    return $result.displayCompte();
}

function displayMembres(){
    global $model;
    $users = $model->getUsers();

    $result = '
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-3 mx-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Ajouter un membre
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter membre</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="SigninAction">
                            <div class="form-content">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Pseudo</span>
                                    <input type="text" class="form-control" placeholder="Entrer un pseudo" name="pseudo" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                    <input type="email" class="form-control" placeholder="Entrer un email"  name="email" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Mot de passe</span>
                                    <input type="password" class="form-control" placeholder="Definir un mot de passe"  name="password" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01">Status</label>
                                    <select class="form-select" id="inputGroupSelect01" name="status" required>
                                        <option value="membre">Membre</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success mb-3">Ajouter</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    ';
   
    $result .='
            <table class="table my-3 mx-3">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($users as $key => $value) {
        
        $result .='
            <tr>
                <th scope="row">'.$value['id'].'</th>
                <td>'.$value['pseudo'].'</td>
                <td>'.$value['email'].'</td>
                <td>'.$value['status'].'</td>
            </tr>
        ';
    }
                    


    $result .='</tbody>
    </table>';

    return $result;
}

//TRAITEMENT DE LA PAGE SIGNIN
function displaySigninAction(){

    global $model;

    if (isset($_SESSION['user'])) {
        
        if ($_SESSION['user']['status'] === "admin") {
    
            if (!empty($_POST)) {
        
                $pseudo = $_POST['pseudo'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $status = $_POST['status'];
        
                $user = $model->createUsers($pseudo, $email, $password, $status);
        
                if ($user) {
                    
                    return '<p class="btn btn-success">Membre crée avec success</p>'.displayMembres();
                }else{
                    return '<p class="btn btn-danger">Echec de creation d\'un memebre</p>'.displayMembres();
                }
            }
       }
    }

    if (!empty($_POST)) {
            
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $status = $_POST['status'];

        $user = $model->createUsers($pseudo, $email, $password, $status);
        $authenUser = $model->authenUser($email, $password);

        if ($authenUser) {
            
            $_SESSION['user'] = $authenUser;
            return '<p class="btn btn-success">Connexion réussie</p>'.displayAccueil();
        }else{
            return '<p class="btn btn-danger">Connexion échoué</p>'.displaySignin();
        }
    }

}

//PAGE PROJETS
function displayProjets(){

    global $model;

    if ($_SESSION['user']['status'] === "admin") {
        
        $result = '
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-3 mx-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Ajouter un projet
            </button>
    
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter projet</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="ProjetsAction" enctype="multipart/form-data">
                                <div class="form-content">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Nom</span>
                                        <input type="text" class="form-control" placeholder="Nom du projet" name="nom" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Description</span>
                                        <textarea class="form-control" placeholder="Description du projet" name="description" required>
                                        </textarea>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Date de debut</span>
                                        <input type="date" class="form-control" name="date_debut" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Date de la fin</span>
                                        <input type="date" class="form-control"  name="date_fin" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control"  name="imageProjet" required>
                                    </div>
                                    <button type="submit" class="btn btn-success mb-3">Ajouter</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }else{

        $result ='';
    }


    $getProjet = $model->getProjet(NULL, NULL);

    $result .= '<div class="cards d-flex flex-wrap p-2 my-3 justify-content-center">';
    foreach ($getProjet as $key => $value) {
        
        $result .='
        <div class="card mb-3 w-50 mx-2">
            <div class="row g-0 h-100">
                <div class="col-md-6 h-100">
                <img src="'.BASE_URL.SP."assets/images".SP.$value['image_name'].'" class="img-fluid rounded-start w-100 h-100" alt="...">
                </div>
                <div class="col-md-6 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-center mt-3">'.$value['nom'].'</h5>
                        <p class="card-text text-center my-3" style="font-size:0.8em">'.$value['description'].'</p>
                        <p class="card-text text-center">Date debut du projet : '.$value['date_debut'].'</p>
                        <p class="card-text text-center">Date fin du projet : '.$value['date_fin'].'</p>';

        if ($_SESSION['user']['status']==="admin") {
            
            $result .='<a href="'.BASE_URL.SP."Taches".SP.$value['id'].'"class="btn btn-primary btn-voir w-100">Ajouter les taches</a>';
        }
                        
        $result .= '</div>
                </div>
            </div>
        </div>
        ';

    }

    $result .='
        </div>
    ';
    return $result;
}

//PAGE DES TACHES
function displayTaches(){

    global $model;
    global $url;
    $users = $model->getUsers();

    if (isset($url[1]) && is_numeric($url[1])) {
        
        $idProjet = $url[1];
        $projet = $model->getProjet($idProjet, NULL);

            $result = '
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary my-3 mx-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Ajouter les taches
                </button>
        
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter taches</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="'.BASE_URL.SP."TachesAction".'">
                                    <div class="form-content">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Id_projet</span>
                                            <select class="form-select" id="inputGroupSelect01" name="idProjet" required>
                                                <option value="'.$projet[0]['id'].'">'.$projet[0]['id'].'</option>
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Nom projet</span>
                                            <select class="form-select" id="inputGroupSelect01" name="nom_projet" required>
                                                <option value="'.$projet[0]['nom'].'">'.$projet[0]['nom'].'</option>
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Nom tache</span>
                                            <input type="text" class="form-control" placeholder="Entrer nom_tache" name="nom_tache" aria-describedby="basic-addon1" required>
                                        </div>
                                          <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Description</span>
                                            <textarea class="form-control" placeholder="Description de la tache" name="description" required>
                                            </textarea>
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="inputGroupSelect01">Memebre</label>
                                            <select class="form-select" id="inputGroupSelect01" name="membre" required>';
                                                
                                            foreach ($users as $key => $value) {
                                                
                                                $result .= '<option value="'.$value['pseudo'].'">'.$value['pseudo'].'</option>';
                                            }
    
    
            $result .=                       '</select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Date debut</span>
                                            <input type="date" class="form-control"  name="date_debut" aria-describedby="basic-addon1" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Date fin</span>
                                            <input type="date" class="form-control"  name="date_fin" aria-describedby="basic-addon1" required>
                                        </div>
                                        <button type="submit" class="btn btn-success mb-3">Ajouter</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';


    }else{
        $result = '';
    }


    $getTaches = $model->getTaches(NULL, $_SESSION['user']['pseudo']);

    //print_r($getTaches); exit();

    $result .='
            <table class="table my-3 mx-3">
                <thead>
                    <tr>
                    <th scope="col">Nom_projet</th>
                    <th scope="col">Nom_tache</th>
                    <th scope="col">Description</th>
                    <th scope="col">Membres</th>
                    <th scope="col">Date debut/fin</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>';

    if (isset($getTaches[0])) {
       
        foreach ($getTaches as $key => $value) {
        
            $result .='
                <tr>
                    <td>'.$value['nom_projet'].'</td>
                    <td>'.$value['nom_tache'].'</td>
                    <td>'.$value['description'].'</td>
                    <td>'.$value['membre'].'</td>
                    <td>'.$value['date_debut']." / ".$value['date_fin'].'</td>
                    <td>';

                    $getFaiteTache = $model->getFaiteTache($value['id']);
                
                    if (isset($getFaiteTache[0]) && $value['id']=== $getFaiteTache[0]['tache_id']) {
                        
                        $result .= '
                            <form method="POST" action="updateProgression">
                            <div class="input-group w-100 mb-3">
                                <select class="form-select" id="inputGroupSelect01" name="progression" required>';
                           
                                if ($getFaiteTache[0]['progression'] === "00%") {
                                    
                                    $result .='
                                        <option value="00%" selected>00%</option>
                                        <option value="25%">25%</option>
                                        <option value="50%">50%</option>
                                        <option value="75%">75%</option>
                                        <option value="100%">100%</option>
                                    ';
                                }elseif ($getFaiteTache[0]['progression'] === "25%") {
                                    $result .='
                                    <option value="00%">00%</option>
                                    <option value="25%" selected>25%</option>
                                    <option value="50%">50%</option>
                                    <option value="75%">75%</option>
                                    <option value="100%">100%</option>
                                ';
                                }elseif ($getFaiteTache[0]['progression'] === "50%") {
                                    $result .='
                                    <option value="00%">00%</option>
                                    <option value="25%">25%</option>
                                    <option value="50%" selected>50%</option>
                                    <option value="75%">75%</option>
                                    <option value="100%">100%</option>
                                ';
                                }elseif ($getFaiteTache[0]['progression'] === "75%") {
                                    $result .='
                                    <option value="00%">00%</option>
                                    <option value="25%">25%</option>
                                    <option value="50%">50%</option>
                                    <option value="75%" selected>75%</option>
                                    <option value="100%">100%</option>
                                ';
                                }else{
                                    $result .='
                                    <option value="00%">00%</option>
                                    <option value="25%">25%</option>
                                    <option value="50%">50%</option>
                                    <option value="75%">75%</option>
                                    <option value="100%" selected>100%</option>
                                    ';
                                }

                        $result .='</select>
                            </div>
                            <button type="submit" class="btn btn-success mb-3">Faire</button>
                            </form>
                        
                        ';
                    }else{

                        $result .= '
                            <form method="POST" action="FaireTache">
                            <div class="input-group w-100 mb-3">
                                <select class="form-select" id="inputGroupSelect01" name="progression" required>
                                    <option value="00%">00%</option>
                                    <option value="25%">25%</option>
                                    <option value="50%">50%</option>
                                    <option value="75%">75%</option>
                                    <option value="100%">100%</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success mb-3">Faire</button>
                            </form>
                        
                        ';

                    }

            $result .= '</td>
                </tr>
            ';
        }
    }
                    
    $result .='</tbody>
    </table>';

   if (isset($getTaches[0])) {

    $result .= '
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary my-3 mx-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Ajouter un commentaire
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter commentaire</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="'.BASE_URL.SP."Comments".'">
                        <div class="form-content">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Titre</span>
                                <input type="text" class="form-control" placeholder="Entrer le titre de votre commentaire" name="titre_comment" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Commentaire</span>
                                <textarea class="form-control" placeholder="Description de la tache" name="comment" required>
                                </textarea>
                            </div>
                            <button type="submit" class="btn btn-success mb-3">Ajouter</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    ';

   }
    $getComments = $model->getComments();
   
    if (isset($getComments[0])) {
        
        foreach ($getComments as $key => $value) {
            $membre = $model->getUserById($value['membre_id']);
            $result .= '

                <div class="comments mx-3 p-3 d-flex gap-3 w-100">
                    <div class="comment-name">
                        <h2 class="">'.$membre['pseudo'].'</h2>
                    </div>
                    <div class="comment-content bg-dark rounded text-light p-2">
                        <h4>'.$value['titre'].'</h4>
                        <p>'.$value['content'].'</p>
                    </div>
                </div>
            ';
        }
    }

    return $result;
}

//TARITEMENT DE LA PAGE PROJET
function displayProjetsAction(){

    global $model;

    if (!empty($_POST) && isset($_POST)) {
        
        $nom = ($_POST['nom']);
        $description = $_POST['description'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
    }

    if (isset($_FILES['imageProjet']['name']) && $_FILES['imageProjet']['error']==0) {

        $image_name = $_FILES['imageProjet']['name'];
        $image_tmp = $_FILES['imageProjet']['tmp_name'];

        
        $destination = "assets/images"."/".$image_name;
        move_uploaded_file($image_tmp, $destination);

    }

    $projetData = $model->createProjet($nom, $description, $date_debut, $date_fin, $image_name, $image_tmp);

    if ($projetData) {
        
        return "<p class='btn btn-success'>Projet créé avec success</p>".displayProjets();
    }else{

        return "<p class='btn btn-danger'>Echec, veuillez réessayer !</p>".displayProjets();
    }
}

//TRAITEMENT DE L'AJOUT D'UNE TACHE
function displayTachesAction(){
    global $model;

    if (!empty($_POST)) {
        
        $idProjet = $_POST['idProjet'];
        $nom_projet = $_POST['nom_projet'];
        $nom_tache = $_POST['nom_tache'];
        $description = $_POST['description'];
        $membre = $_POST['membre'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
    }

 
    $tache = $model->createTache($idProjet, $nom_projet, $membre, $nom_tache, $description, $date_debut, $date_fin);


    if ($tache) {
        
        return "<p class='btn btn-success'>Tache créé avec success</p>".displayTaches();
    }else{

        return "<p class='btn btn-danger'>Echec, veuillez réessayer !</p>".displayProjets();
    }

}

//TRAITEMENT DES TACHES FAITES
function displayFaireTache(){
    global $model;
    if (!empty($_POST)) {
        
        $progression = $_POST['progression'];

    }
   
    if (isset($_SESSION['user'])) {
        
        $getTaches = $model->getTaches(NULL, $_SESSION['user']['pseudo']);

        foreach ($getTaches as $key => $value) {
            

            $faite_tache = $model->FaiteTache($value['projet_id'], $value['id'], $_SESSION['user']['id'], $progression);

            $updateProgression = $model->upDateProgression($value['id'], $progression);

            if ($updateProgression) {
                
                
                return "<p class='btn btn-success'>Tache fait avec success</p>".displayTaches();
            }else{
        
                return "<p class='btn btn-danger'>Echec, veuillez réessayer !</p>".displayTaches();
            }
            
        }
    }
}

//TRAITEMENT MISE A JOUR PROGRESSION
function displayUpdateProgression(){
    global $model;
    if (!empty($_POST)) {
        
        $progression = $_POST['progression'];

    }

    if (isset($_SESSION['user'])) {
        
        $getTaches = $model->getTaches(NULL, $_SESSION['user']['pseudo']);

        foreach ($getTaches as $key => $value) {
            
            $updateProgression = $model->upDateProgression($value['id'], $progression);

            if ($updateProgression) {
        
                return "<p class='btn btn-success'>Mise à jour progression avec success</p>".displayTaches();
            }else{
        
                return "<p class='btn btn-danger'>Echec, veuillez réessayer !</p>".displayTaches();
            }
            
        }
    }

}

//TRAITEMENT DES COMMENTAIRES
function displayComments(){
    global $model;
    if (!empty($_POST)) {
        
        $titre_comment = $_POST['titre_comment'];
        $comment = $_POST['comment'];
    }

    $createComment = $model->createComment($_SESSION['user']['id'], $titre_comment, $comment);

    if ($createComment) {
        
        return "<p class='btn btn-success'>Commentaire créé avec success</p>".displayTaches();
    }else{

        return "<p class='btn btn-danger'>Echec, veuillez réessayer !</p>".displayTaches();
    }

}
