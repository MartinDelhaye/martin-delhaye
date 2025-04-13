<?php

include 'config/config.php';
include "PHP/fonctions.php";

if(isset($_GET['id_projet'])) $idProjet = $_GET['id_projet'];
else $idProjet = 1;
$infoProjet = obtenirDonnees('*', 'projets', 'id_projet = "' . $idProjet . '"', '', 'fetch');
$tabUrlProjet = obtenirDonnees('url_image', 'images_projet', 'id_projet = "' . $idProjet . '"');


// print_r($tabUrlProjet);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php infoMeta(); ?>
    <meta name="description" content="Site du Portfolio de Martin Delhaye">
    <meta name="keywords" content="Martin Delhaye, Portfolio, Devellopement Web">
    <title>Martin Delhaye - Projet</title>
</head>

<body>
    <?php foreach ($tabUrlProjet as $url) {
        echo '<div class="display-none carrousel-url">' . $url["url_image"] . '</div>';
    } ?>


    <header class="fond-main flex row justify-content-between align-items-center text-second width-100 padding-small ">
        <p class="text-important">Martin Delhaye</p>
        <nav class="fond-main flex row justify-content-center border-rond border-rond-no-right padding-small">
            <a id="returnIndex" class="text-center navButton" href="index.php#projets">
                &#8593;
            </a>
        </nav>
    </header>
    <main id="mainProjet" class="fond-main flex column justify-content-between align-items-center height-screen text-white padding-small ">
        <h1 id="titreProjet" class="text-center"><?php echo $infoProjet["titre_projet"]; ?></h1>

        <div id="contenuProjet" class="flex justify-content-center align-items-center width-100 padding-small">
            <div id="projet" class="flex row column-mobile justify-content-between align-items-center gap-medium width-100">
                <!-- Carrousel -->
                <div id="carrousel-container" class="flex column justify-content-center width-50 width-100-mobile height-100">
                    <div id="diapo" class="width-100 flex justify-content-center height-100">
                        <?php echo afficherImage('Images/Icon-flèche-bas-rose.png', 'Flèche aller vers le bas', 'fleche-carrousel display-none', 'carrousel-precedent'); ?>
                        <?php echo afficherImage('Images/Icon-flèche-bas-rose.png', 'Flèche aller vers le bas', 'fleche-carrousel display-none', 'carrousel-suivant'); ?>
                        <?php echo afficherImage($infoProjet['illustration_projet'], 'Photo de profil', 'width-100 border-second border-rond fond-black height-80', 'carrousel-image'); ?>
                    </div>
                    <input type="button" value="Pause" id="carrousel-Pause" class="button ">
                </div>

                <!-- Texte -->
                <p class="overflow-scroll width-50 width-100-mobile height-80 flex column justify-content-center">
                    <?php echo nl2br(htmlspecialchars($infoProjet["texte_projet"])); ?>
                </p>
            </div>
        </div>

        <!-- Liens en bas -->
        <div id="liensProjet" class="flex row gap-large justify-content-center align-items-center width-100 text-center">
            <?php
            if (isset($infoProjet["url_projet"])) {
                echo '<a href="' . $infoProjet["url_projet"] . '" class="button flex align-items-center " target="_blank">Découvrir</a>';
            } else {
                echo '<p class="height-100 "> Le site n\'est plus hébergé </p>';
            }
            if (isset($infoProjet["urlGitHub_projet"])) {
                echo "<div class='flex column height-100'> <p>Le code est accessible sur GitHub :</p>";
                echo '<a href="' . $infoProjet["urlGitHub_projet"] . '" class="button" target="_blank">Lien GitHub</a></div>';
            }
            ?>
        </div>
    </main>

</body>
</html>