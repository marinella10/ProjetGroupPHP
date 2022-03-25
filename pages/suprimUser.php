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
    <body>

    <header>

        <?php
        require_once "navbar.php";
        ?>
    </header>



    <?php
    //faire sa connexion à PDO
    $user = "root";
    $pass = "";

    try {
        //faire la class PDO (l'orienté objet)
        $baseDonnee1 = new PDO('mysql:host=localhost;dbname=base1;charset=UTF8', $user, $pass);
    
        // faire le Debug de pdo
      
        $baseDonnee1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<h4 class='container alert alert-info text-center'>Vous êtes connectez a PDO MySQL</h4>";
    
        //catch pour attraper l'exception
    }catch(PDOException $e){
        print "Erreur !: " . $e->getMessage() . "<br>";
        die();
    }  

//faire la requete SQL
$sql = "DELETE FROM users WHERE idUsers = ?";

//recuperer ID avec GET 
$userId = $_GET['idUser'];

//preparer la requete 
$effacer = $baseDonnee1->prepare($sql);

$effacer->bindParam(1, $userId);
//on affiche sous forme d'un tableau
$effacer->execute();

//faire la condition si la supression est faire ou pas
if($effacer==true){

    echo "<h2 class='alert alert-primary'>l'utilisateur a été suprimer</h2>";
?>
<!--le lien pour le retour-->
  <!--echo "<a class='btn-brimary' href='administrateurs.php'>Retour</a>";-->
    <div class=container>
    <a class="btn btn-primary" href="administrateurs.php">Retour</a>
    </div>

    <?php
}else{
    echo "<h2 class='alert alert-primary'>Erreur</h2>";
}
   

 }else{
          
            header("location :../index.php");
 }
        
        ?>
       
</body>
</html>
