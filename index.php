<?php
//Pour démarer une nouvelle session
session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/bootstrap.css">
   
    
    
    <title>CONNEXION</title>
</head>
<body>
<div class="container">

  <div class="bg-img">
    <form  class="container" method="post">
      <h1 class="h1-conect ">CONNEXION</h1>

      <label for="email" class="text-white" ><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required>

      <label for="formConnect" class="text-white" ><b>Mot de passe</b></label>
      <input type="password"  name="password" placeholder="Enter Mot de passe" id="formConnect" required>

      <button type="submit"  name="btnConnect" class="btn text-white bg-info">Connexion</button>
    </form>
  </div>

</div>


<?php
//faire le  crud de la connexion
//le click pour la connexion (isset : varaible déclaré et differente de null) 
    //

 if(isset($_POST["btnConnect"])){
        
    //var_dump ($email);
    connexion();
}

//mettre toute la connexion dans la fonction 
function connexion(){

//connexion PDO  
//declarer les variable de phpmyadmin
   $user = "root";
   $pass = "";
   $dbname = "basegroup";
   $host = "localhost";
//test d'erreur, soit on de connecte, si non , on retourne au bloc catch
//Instance de la classe PDO (Php Data Object)
//"double deux-points" (::), fournit un moyen d'accéder aux membres static ou constant, ainsi qu'aux propriétés ou méthodes surchargées d'une classe.
            try{
                $baseDonnee1 = new PDO("mysql:host=localhost;dbname=basegroup;charset=UTF8", $user, $pass);
                
                // faire le Debug de pdo
              
                $baseDonnee1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "<h4 class='container alert alert-info text-center'>Connexion à PDO MySQL</h4>";
//catch (PDOException $e) Représente une erreur émise par PDO
            } catch (PDOException $e) {
                print "ERREUR !: " . $e->getMessage() . "<br>";
                die();
            }

    //hydrater les champs
    //Cette fonction retourne une chaîne de caractères avec ces modifications
    //faille xss = ON HYDRATE LES DONNÉES = Sanitize
        //trim — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
        //htmlspecialchars — Convertit les caractères spéciaux en entités HTML :: 
    $emailUser = trim(htmlspecialchars($_POST['email']));
    $passwordUser = trim(htmlspecialchars($_POST['password']));

    //si les champs ne sont pas vide
    //on recupére avec $_post pour envoyer à une autre page
    if(isset($emailUser) && !empty($emailUser) && isset($passwordUser) && !empty($passwordUser)){
    
        //faire la requette sql 
        $sql = "SELECT * FROM users WHERE email = ? && password = ?";

        //faille
        $connect = $baseDonnee1->prepare($sql);

        //Lier tout les paramètre du formulaire a  la requète SQL
        $connect->bindParam(1,  $emailUser);
        $connect->bindParam(2, $passwordUser);

        //Execute la requète et afficher un tableau associatif
        $connect->execute();


        //avoir un utilisateur dans la table administrateur
        //rowCount Elle s'utilise pour le nombre de lignes AFFECTEES
        if($connect->rowCount() > 0){

            //stocker le resultat dans une variable
          
            $result = $connect->fetch();

            //si le resultat existe
            if($result){

                //on recupére les coordonnées de l'utilisateur d
                $email = $result['email'];
                $password = $result['password'];
                if($emailUser == $email && $passwordUser == $password){

                  $_SESSION['email'] = $emailUser;
        
                  //redirection php vers la page de multiplication
                  header("Location: pages/accueil.php");
                  
              }else{
                echo "<h2 class='p-blan text-white'>MERCI DE REMPLIR LES CHAMPS</h2>";
              }
            }
        }


    
      //Condition d'egalité de mail et de mot de passe
      

    }else{
      echo "<h2 class='p-blan text-white'>ERREUR DE CONNEXION</h2>";
    }
}
    ?>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
</body>
</html>