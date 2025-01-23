<?php 


include("Config/config.php");

if (isset($_POST['texte_projet'])) {

    $requete = 'UPDATE `projets` SET `texte_projet`= "'.$_POST['texte_projet'].'" WHERE `id_projet`=3';
    $stmt = $bdd->query($requete);

}

?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>
<body>

    <form action="modif.php" method="POST">
        <textarea name="texte_projet" cols="30" rows="10"></textarea>
        <input type="submit" value="Modifier">
    </form>

</body>
</html>