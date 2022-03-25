<?php

//pour une nouvelle session (demarer)

session_start();
if(isset($_SESSION['email'])){

?>

<h1 class="h1-accueil text-blak">Bienvenue</h1>

<p class="h1-accueil"><?= $_SESSION['email'] ?></p>

<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   
    <title>Administrateurs</title>
</head>

<body>
<h4 class='container alert alert-info text-center mt-5'>Bienvenue sur la page Administrateurs</h4>
<header>
        <?php
        require_once "navbar.php";
        ?>
</header>

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
       // echo "<h4 class='container alert alert-info text-center'>Connexion a PDO MySQL</h4>";

      
        //catch pour attraper l'exception
    }catch(PDOException $e){
        print "Erreur !: " . $e->getMessage() . "<br>";
        die();
    }  
    $sql = "SELECT `idUsers`, `email`, `password` FROM `users`";
    $users = $baseDonnee1->query($sql);
    
    ?>

    
    <div class="container">
        <table class="table">
            <h4 class="text-dark">Liste des utilisateurs</h4>
                <thead>
                    <tr>
                        <th class="text-dark" scope="col">Id</th>
                        <th class="text-dark" scope="col">Email</th>
                        <th class="text-dark" scope="col">Mot de pass</th>
                        <th>

                        
                        </td>
                    </td>
                 </tr>
                    </tr>
                </thead>

           
                <?php
                //on parcoure notre tableau avec foreach
                foreach ($users as $user){
                ?>
                 <tbody>
                    <tr>
                        <th class="text-dark " scope="row"><?=$user['idUsers']?></th>
                            <td class="text-dark font-weight-bold" ><?=$user['email']?></td>
                            <td class="text-dark" ><?=$user['password']?></td>
                            <td><a class="btn btn-info text-dark"  href="suprimUser.php?idUser=<?=$user['idUsers'] ?>">Supprimer</a></td>
                    </tr>
                    
                <?php
                }
                ?>
            </tbody>
        </table>
        
        
    </div>

    <div class="container mt-5">
        
        <a class="btn btn-info" href="prof.php">Aller sur la page Enseignants</a>
        <a class="btn btn-secondary" href="eleve.php">Aller sur la page Eléves</a>
        <a class="btn btn-primary" href="accueil.php">Retour à la page d'accueil</a>

    </div>
    
<?php
 }else{
           
            header("location :../index.php");
 }
        
        ?>
</body>
</html>