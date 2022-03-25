<?php
//demarer la session
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
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    
    <title>Detail Produit</title>

</head>
<body>

<?php

//faire la connexion avec la variable phpmyadmin
$user = "root";
$pass = "" ;

//faire le test en cas d'erreur pour avoir le contenu de la page avec le try catch
try {
    //faire la class PDO (l'orienté objet)
    $baseDonnee1 = new PDO('mysql:host=localhost;dbname=basegroup;charset=UTF8', $user, $pass);

    // faire le Debug de pdo
  
    $baseDonnee1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h4 class='container alert alert-info text-center'>Connexion a PDO MySQL</h4>";

    //catch pour attraper l'exception
}catch(PDOException $e){
    print "Erreur !: " . $e->getMessage() . "<br>";
    die();
}  
//la condition pour la requete de selection

//faire la requette SQL de type SELECT
 if($baseDonnee1){

    //Requète SQL de selection des enseignants 
    $sql = "SELECT * FROM professeurs WHERE id_prof = ?";
    //variable idProduit
    $idProf = $_GET["id_prof"];

    //preparer la requette avec "prepare"
    //Lorsque la requête est préparée, la base de données va analyser, 
    //compiler et optimiser son plan pour exécuter la requête.
    $requete = $baseDonnee1->prepare($sql);

    //recuperer la valeur id grace à $-GET['id_Prof'] et l'analyser
    $requete->bindParam(1, $idProf);
    //exécuter la requête
    $requete->execute();

    //PDO:FETCH_ASSOCplace les résultats dans un tableau où les valeurs 
    //sont mappées à leurs noms de champ.
    $coordoneProf = $requete->fetch(PDO::FETCH_ASSOC);

}

?>
    <div class="container  ">
        <div class="mx-auto bg-info w-50 text-center ">

            <img   src="<?= $coordoneProf['avatar_prof'] ?>"/>
            
            <div class="card-body ">
                <h2 class="card-title"><?= $coordoneProf['nom_prof'] ?> <?= $coordoneProf['prenom_prof'] ?></h2>
                <p class="card-text">Date de naissance : <?= $coordoneProf['date_naissance_prof'] ?></p>
                <p class="card-text">Age  : <?= $coordoneProf['age_prof'] ?></p>
                <p class="card-text">Numéro de téléphone  : <?= $coordoneProf['tel_prof'] ?>  </p>
                <p class="card-text">Email : <?= $coordoneProf['email_prof'] ?>  </p>
                <p class="card-text">Spécialité : <?= $coordoneProf['metier_prof'] ?></p>
               
                    <!--faire la condition si le produit est disponible-->
                    <?php
                    //stocker dans une variable
                    $date = new Datetime($coordoneProf['date_naissance_prof']);

                    if($coordoneProf['date_naissance_prof'] == true){
                        echo "OUI";
                    }else{
                        echo "NON";
                    }
                    
                    ?>
                </p>
                
                                    <br />

                                    <div class="container">

                                        <a href="prof.php" class="btn btn-outline-primary btn-lg mb-2">Retour sur la liste des enseignants </a> 
                                      
                                    </div>  
                                    
            </div>
        </div>
    </div>    
    <?php
        }else{
            echo "<a href='' class='btn btn-info'>S'inscrire</a>";
            header("location :../index.php");
        }
        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>