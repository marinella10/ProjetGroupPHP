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
    
    
    <title>Mise à jour professeurs</title>

</head>
<body>

<header>
        <?php
        require_once "navbar.php";
        ?>
</header>
     
    <!--créer le bouton de deconnexion -->
    <div class="btn-deconect">
        <form method="post" >
            <button class="btn btn-info" name="btn-deconnexion" >Deconnexion</button>
        </form>
    </div>
    <?php
    function deconnexion(){
        
        session_unset();
        session_destroy();
        header('Location: ../accueil.php');
    }

    //faire la deconnexion avec le bouton 
    if(isset($_POST['btn-deconnexion'])){
        deconnexion();
    }

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


//On fait toujours  la même premiére requette pour suprimer ou faire le detail d'un produits,
// une deuxiéme requette pour supprimer , ajouter ou faire le detail  

//faire la requette SQL de type SELECT
if($baseDonnee1){

    //Requète SQL de selection des produits 
    $sql = "SELECT * FROM professeurs WHERE id_prof = ?";
    //variable idProduit
    $idProf = $_GET["id_prof"];

    //preparer la requette avec "prepare"
    //Lorsque la requête est préparée, la base de données va analyser, 
    //compiler et optimiser son plan pour exécuter la requête.
    $requete = $baseDonnee1->prepare($sql);

    //recuperer la valeur id grace à $-GET['idProduit'] et l'analyser
    $requete->bindParam(1, $idProf);
    //exécuter la requête
    $requete->execute();

    //PDO:FETCH_ASSOCplace les résultats dans un tableau où les valeurs 
    //sont mappées à leurs noms de champ.
    $coordoneProf = $requete->fetch(PDO::FETCH_ASSOC);

}
?>

<div class="container">
    <!--créer le formulaire et utiliser l"ID pour le traitement-->
   <!-- L' enctype attribut spécifie comment les données du formulaire doivent 
   être encodées lors de leur soumission au serveur, peut être utilisé que si method="post".-->

   <form  action="traitementMisJour.php?id_prof=<?= $coordoneProf['id_prof'] ?>" method="post" id="form-update"  enctype="multipart/form-data">
        <h1 class="text-center text-primary bg-info">Mise à jour des coordonnées de l'enseignant </h1>

            <div class="md-3">
                <label for="nom_prof">Nom </label>
                <input type="text" class="form-control" id="nom_prof" name="nom_prof" placeholder="<?= $coordoneProf['nom_prof'] ?>" required>
            </div>

            <div class="md-3">
                <label for="prenom_prof">Prenom </label>
                <input type="text" class="form-control" id="prenom_prof" name="prenom_prof" placeholder="<?= $coordoneProf['prenom_prof'] ?>" required>
            </div>
            <div class="md-3">
                <label for="avatar_prof">Image du Produit</label>
                <input type="file" class="form-control" id="avatar_prof" name="avatar_prof" placeholder="<?= $coordoneProf['avatar_prof'] ?>" required>
            </div>

            <div class="md-3">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" class="form-control" id="date_naissance"  name="date_naissance_prof" placeholder="<?= $coordoneProf['date_naissance_prof'] ?>" required>
            </div>
            <div class="md-3">
                <label for="">Numéro de téléphone</label>
                <input type="tel"  class="form-control" id="telNo"  name="tel_prof" placeholder="<?= $coordoneProf['tel_prof'] ?>" required>
            </div>
            <div class="md-3">
                <label for="email"  ><b>Email</b></label>
                <input type="email" placeholder="<?= $coordoneProf['email_prof'] ?>" name="email_prof" required>
            </div>

            <div class="md-3">
                <label for="age_prof">Age </label>
                <input type="number"  class="form-control" id="age-prof"  name="age_prof" placeholder="<?= $coordoneProf['age_prof'] ?>" required>
                
            </div>
            <div class="md-3">
                <label for="metier-prof">Matiére</label>
                <input type="text" class="form-control" id="metier_prof" name="metier_prof" placeholder="<?= $coordoneProf['metier_prof'] ?>" required>
            </div>

            <div class="md-3">
                <label for="vaccin_prof">Enseignant vacciné</label>
                <select class="form-control" id="etat_prof" name="etat_prof" placeholder="<?= $coordoneProf['etat_prof'] ?>" required>
                    <option value="0"> Oui</option>
                    <option value="1"> Nom</option>
                </select>
            </div>

            </div>

        
        <button type="submit"  class="btn btn-primary" name="btnConnexion">Mettre à jour les coordonnées </button>
        <a href="prof.php" class="btn btn-info">Annuler</a>

    </form>

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