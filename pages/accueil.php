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
   
    <title>Page d'accueil </title>
</head>

<body>

<div class="row justify-content-center">

    <div class="card text-center" style="width: 22rem;">
        <img src="../img/george.png" class="card-img-top" alt="imageAccueil">
       
    </div>
</div>

<div class="card-body m-5 text-center">
       
            <a class="p-3 mb-2 bg-primary text-white" href="administrateurs.php">Page Administrateurs</a>
            <a class="p-3 mb-2 bg-secondary text-white" href="prof.php">Page des Enseignants</a>
            <a class="p-3 mb-2 bg-info text-white" href="eleve.php">Page des Eléves</a>
</div>

    <!--créer le bouton de deconnexion -->
    <div class="btn-deconect">
        <form method="post" >
            <button class=" btn btn-info" name="btn-deconnexion" >Deconnexion</button>

           
        </form>
        
    </div>

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

    //Connexion a la base de donnée base1 via PDO

     //Les variable de phpmyadmin
        $user = "root";
        $pass = "";

    //faire le test d'erreur
        try{
             $baseDonnee1 = new PDO('mysql:host=localhost;dbname=basegroup;charset=UTF8', $user, $pass);
                
    // faire le Debug de pdo
              
            $baseDonnee1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "<h4 class='container alert alert-info text-center'>Connexion réussis a PDO MySQL</h4>";

            } catch (PDOException $e) {
                print "ERREUR !: " . $e->getMessage() . "<br>";
                die();
            }


        }else{
            echo "<a href='' class='btn btn-info'>S'inscrire</a>";
            header("location :../index.php");
        }
        ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>


