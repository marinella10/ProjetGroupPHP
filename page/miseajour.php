<?php
//Demarrer la session php
session_start();
if(isset($_SESSION["email"])){

    //Connexion a la base de donnée ecommer via PDO
//Les variable de phpmyadmin
    $user = "root";
    $pass = "";
//test d'erreur
    try {
        /*
         * PHP Data Objects est une extension définissant l'interface pour accéder à une base de données avec PHP. Elle est orientée objet, la classe s’appelant PDO.
         */
        //Instance de la classe PDO (Php Data Object)
        $dbh = new PDO('mysql:host=localhost;dbname=ecommerce', $user, $pass);
        //Debug de pdo
        /*
         * L'opérateur de résolution de portée (aussi appelé Paamayim Nekudotayim) ou, en termes plus simples,
         * le symbole "double deux-points" (::), fournit un moyen d'accéder aux membres static ou constant, ainsi qu'aux propriétés ou méthodes surchargées d'une classe.
         */
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p class='container alert alert-success text-center'>Vous êtes connectez a PDO MySQL</p>";

    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }

    if($dbh){
        //Requète SQL de selection des produits
        $sql = "SELECT * FROM produits WHERE id_produit = ?";

        $id_produit = $_GET['id_produit'];
        //Grace a PDO on accède à la methode query()
        //Requète préparée
        $request = $dbh->prepare($sql);
        //Lié les paramètres
        $request->bindParam(1, $id_produit);

        //Execution de la requète
        $request->execute();
        //Retourne un objet de resultats
        $details = $request->fetch(PDO::FETCH_ASSOC);

    }

    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/styles.css">

        <title>PHP CRUD CONNEXION</title>
        <title>Page Editer un élève</title>
    </head>
    <body>
    <header>
        <?php
        require_once "menu.php";
        ?>
    </header>

    <div class="container-fluid">
            <span class="mt-3 d-flex justify-content-around">
                <h3 class="mt-3 text-warning">BIENVENUE <?= $_SESSION['email'] ?></h3>
                <form method="post">
                    <button id="btn-deconnexion" name="btn-deconnexion" class="btn btn-danger">DECONNEXION</button>
                </form>
            </span>

    <div class="container">

        <!--On passe ID pour le traitement-->

        <form action="miseajour.php?id_student=<?= $details['id_student'] ?>"  id="form-update" method="post" enctype="multipart/form-data">
            <h3 class="text-info">EDITER L'ELEVE</h3>
            <div class="text-center img-logo">
                <img src="" alt="logo " title="">
            </div>
    <div class="mb-3">
        <label for="nom_eleve" class="form-label">Nom de l'élève</label>
        <input type="text" class="form-control" id="nom_eleve" name="nom_eleve" required>
    </div>

    <div class="mb-3">
        <label for="prenom_eleve" class="form-label">Prenom de l'élève</label>
        <textarea class="form-control" rows="5" id="prenom_eleve" name="prenom_eleve"
                  required></textarea>
    </div>

    <div class="mb-3">
        <label for="avatar_eleve" class="form-label">Avatar des élèves</label>
        <input type="file" class="form-control" id="avatar_eleve" name="avatar_eleve" required>
    </div>

    <div class="mb-3">
        <label for="date_naissance_eleve" class="form-label">Date de naissance des eleves</label>
        <input type="date_naissance_eleve" class="form-control" id="date_naissance_eleve" name="date_naissance_eleve" required>
    </div>

    <div class="mb-3">
        <label for="age_eleve" class="form-label">L'age des élèves</label>
        <input type="file" class="form-control" id="age_eleve" name="age_eleve" required>
    </div>

    <div class="mb-3">
        <label for="classe_eleve" class="form-label">La classe des élèves</label>
        <input type="file" class="form-control" id="classe_eleve" name="classe_eleve" required>
    </div>


    <div class="mb-3">
        <label for="absence_eleve" class="form-label">Absences</label>
        <select class="form-control" name="absence_eleve" id="absence_eleve" required>
            <option value="0">OUI</option>
            <option value="1">NON</option>
        </select>
    </div>

    <div class="d-flex justify-content-around">
        <button type="submit" name="btn-connexion" class="btn btn-warning">Mettre à jour</button>
        <a href="eleve.php" class="btn btn-success">Annuler</a>
    </div>
    </form>
    </div>
    </div>

    </body>
    </html>


    <?php

    //Deconnexion et destruction de la session $_SESSION['email']
    function deconnexion(){
        var_dump("hello");
        echo "elloo";
        session_unset();
        session_destroy();
        header('Location: ../index.php');
    }

    //Click sur le bouton de deconnexion
    if(isset($_POST['btn-deconnexion'])){
        deconnexion();
    }

}else{
    echo "<a href='' class='btn btn-warning'>S'inscrire</a>";
}








