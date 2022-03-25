
<?php  session_start(); ?>

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

    <title>PHP CRUD CONNECTION</title>
    <title> Traitement élèves ajouter</title>
</head>
<body>

<header>
    <?php require_once 'navbar.php'?>
</header>



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
?>
<?php

// Verifier l'existance avec isset de ma superglobale $_FILES-->
if(isset($_FILES['avatar_eleve'])){


    // Variable pour ajouter le repertoire de destination
    $repertoireDestination = "../image/";
    //La photo uploader

    //  // viariable pour ajouter le repertoire de destination + la composante final d'un chemin(basename) et qui prend en paramettre en tableau associatif multidimentionnel
    $photo_eleve = $repertoireDestination . basename($_FILES['avatar_eleve']['name']);
    //Recup de l'image uploader

    //On assigne l'image uploader au repertoire de destination + la photo + son nom
    $_POST['avatar_eleve'] = $photo_eleve;


    //Les conditions de resussite
    //move_uploaded_file — Déplace un fichier téléchargé
    //On assigne a la photo un nom temporaire random en cas d'echec d'upload
    if(move_uploaded_file($_FILES['avatar_eleve']['tmp_name'], $photo_eleve)){
        echo "<p class='container alert alert-success'>Le fichier est valide et téléchargé avec succès !</p>";
    }else{
        echo "<p class='container alert alert-danger'>Erreur lors du téléchargement de votre fichier !</p>";
    }
}else{
    echo "<p class='container alert alert-warning'>Le fichier est invalide seul les format .png, .jpg, .bmp, .svg, .webp sont autorisé !</p>";
}


//Connexion a la base de donnée basegroup via PDO
//Les variable de phpmyadmin
$user = "root";
$pass = "";
//test d'erreur
try {
    /*
     * PHP Data Objects est une extension définissant l'interface pour accéder à une base de données avec PHP. Elle est orientée objet, la classe s’appelant PDO.
     */
    //Instance de la classe PDO (Php Data Object)
    $dbh = new PDO('mysql:host=localhost;dbname=basegroup', $user, $pass);
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
    //Requète SQL de selection des eleves
    $sql = "INSERT INTO `eleves`(`id_Student`, `nom_eleve`, `prenom_eleve`, `avatar_eleve`, `date_naissance_eleve`, `age_eleve`, `classe_eleve`, `absence_eleve`) VALUES (?,?,?,?,?,?,?,?)";
    //Requète préparée = connexion + methode prepare + requete sql
    //Les requètes préparée lutte contre les injections SQL
    //PDO::prepare — Prépare une requête à l'exécution et retourne un objet
    $insert = $dbh->prepare($sql);
    //Bindé les paramètre
    //Liés les paramètre du formulaire a la table phpmyadmin
    //PDOStatement::bindParam — Lie un paramètre à un nom de variable spécifique
    $insert->bindParam(1, $_POST['id_student']);
    $insert->bindParam(2, $_POST['nom_eleve']);
    $insert->bindParam(3, $_POST['prenom_eleve']);
    $insert->bindParam(4, $_POST['avatar_eleve']);
    $insert->bindParam(5, $_POST['date_naissance_eleve']);
    $insert->bindParam(6, $_POST['age_eleve']);
    $insert->bindParam(7, $_POST['classe_eleve']);
    $insert->bindParam(8, $_POST['absence_eleve']);

    //executer la requète préparée
    //PDOStatement::execute — Exécute une requête préparée
    //Elle execute la reqète passé dans un tableau de valeur
    $insert->execute(array(
        $_POST['id_student'],
        $_POST['nom_eleve'],
        $_POST['prenom_eleve'],
        $_POST['avatar_eleve'],
        $_POST['date_naissance_eleve'],
        $_POST['age_eleve'],
        $_POST['classe_eleve'],
        $_POST['absence_eleve']

    ));

    if($insert){
        echo "<p class='container alert alert-success'>Les élèves ont bien été rajouté!</p>";
        echo "<a href='eleve.php' class='btn btn-success'>Retour</a>";
    }else{
        echo "<p class='alert alert-danger'>Erreur lors de l'ajout de l'élève</p>";
    }
}
?>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>