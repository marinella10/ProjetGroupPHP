<?php

//pour une nouvelle session (demarer)

session_start();

if(isset($_SESSION['email'])){

?>

<h1 class="h1-accueil">Bienvenue</h1>

<p class="h1-accueil"><?= $_SESSION['email'] ?></p>


<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   
    <title>liste professeurs </title>
</head>

<body>

    <!--navbar sur toute les pages-->
<header>
        <?php
        require_once "navbar.php";
        ?>
</header>
    
   
    <!--créer le bouton de deconnexion -->
    <div class="btn-deconect">
        <form method="post" >
            <button class=" btn btn-info" name="btn-deconnexion" >Deconnexion</button>

        </form>
        
    </div>
    <h4 class='container alert alert-info text-center mt-5'>Bienvenue sur la page Enseignants</h4>

    <?php
    function deconnexion(){
        
        session_unset();
        session_destroy();
        header('Location: ../index.php');
    }

    //faire la deconnexion avec le bouton 
    if(isset($_POST['btn-deconnexion'])){
        deconnexion();
    }

    //Connexion a la base de donnée basegroup via PDO

     //Les variable de phpmyadmin
        $user = "root";
        $pass = "";

    //faire le test d'erreur
    //PDO::__construct — Crée une instance PDO qui représente une connexion à la base
        try{
             $baseDonnee1 = new PDO('mysql:host=localhost;dbname=basegroup;charset=UTF8', $user, $pass);
                
    // faire le Debug de pdo
              
            $baseDonnee1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "<h4 class='container alert alert-info text-center'>Connexion réussis a PDO MySQL</h4>";

            } catch (PDOException $e) {
                print "ERREUR !: " . $e->getMessage() . "<br>";
                die();
            }

    // faire la condition

        if($baseDonnee1){

     //Requète SQL de selection des produits (de tout les produits)
             $sql = "SELECT * FROM professeurs";
    // accèder à la methode query() grace à sql
               
            $affich = $baseDonnee1->query($sql);
            }

            ?>
    <!--container pour les produit-->
    <div class="container">

            <a href="ajoutProf.php" class="mt-3 btn btn-info">Ajouter un nouveau professeur</a>
                
            <h2 class=" text-center text-white-50 bg-dark mt-4">liste des professeurs de la 6éme A</h2>

        <div class="row">
                
    <!--Pour chaque col on affiche une ligne de la table produits de la BDD ecommerce-->
            <?php

            foreach ($affich as $prof){
                $date = new DateTime($prof['date_naissance_prof']);
            ?>
                            
            <div class="col-md-4">
                            
                <div class="card">

                    <div class="p-3 border bg-light">
                        <img src="<?= $prof['avatar_prof'] ?>" class="card-img-top img-fluid" alt="<?= $prof['nom_prof'] ?> < ?>" title="<?= $prof['nom_prof'] ?><?= $prof['prenom_prof'] ?>">
                        <h4 class="card-title text-info text-center"><?= $prof['nom_prof'] ?><?= $prof['prenom_prof'] ?></h4>                 
                    </div>
                    <div class="card-body">

                    <?php

    //voir si l'enseignant est present ou absent
                    if($prof['etat_prof'] == true){
                    echo "L'enseignant est vacciné";

                    }else{
                    echo "L'enseignant n'est pas vacciné";
                    }

                 ?>
            
                        <div class="container-fluid  justify-content-center">

                            <a href="coordonneProf.php?id_prof=<?= $prof['id_prof'] ?>" class="btn btn-primary">Coordonnées de l'enseignant</a>
                            <a href="misJourProf.php?id_prof=<?= $prof['id_prof'] ?>" class="btn btn-secondary">Mettre à jour les coordonnées</a>
                            <a href="suprimProf.php?id_prof=<?= $prof['id_prof'] ?>" class="btn btn-info">Supprimer l'enseignant</a>
                        </div>

                    </div>

                 </div>
            </div>
                            <?php
                        }

                    ?>

        </div>
    </div>

    <div class=container>
        
        <a class="btn btn-info" href="eleve.php">Aller sur la page Eléves</a>
        <a class="btn btn-secondary" href="administrateurs.php">Aller sur la page Administrateurs</a>
        <a class="btn btn-primary" href="accueil.php">Retour à la page d'accueil</a>

    </div>
     
        <?php
        }else{
           
            header("location :../index.php");
        }
        ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>

