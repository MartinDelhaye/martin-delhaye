<?php
include 'config/config.php';
include "PHP/fonctions.php";

// $listeCompetencesLangage = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "Langage"');
// $listeCompetencesLibrairie = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "Librairie"');
// $listeCompetencesCMS = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "CMS"');
// $listeCompetencesLogiciel = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "Logiciel"');
// $listeLangages = obtenirDonnees('id_competence, nom_competence, image_competence', 'competences', 'type_competence = "Langage" AND parent_id IS NULL');
$listeLangages = obtenirDonnees(
    'id_competence, nom_competence, image_competence, description',
    'competences',
    'type_competence = "Langage" AND parent_id IS NULL'
);
$listeSousCompetences = obtenirDonnees(
    'id_competence, nom_competence, image_competence, parent_id, description',
    'competences',
    'parent_id IS NOT NULL'
);

$listeCompetences = obtenirDonnees('nom_competence, image_competence', 'competences');
$listeCMS = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "CMS"');
$listeLogiciels = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "Logiciel"');


$listeProjets = obtenirDonnees('id_projet, titre_projet, illustration_projet, date_projet', 'projets', '', 'date_projet DESC');


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martin Delhaye">
    <meta name="description" content="Site du Portfolio de Martin Delhaye">
    <meta name="keywords" content="Martin Delhaye, Portfolio, Devellopement Web">
    <title>Martin Delhaye - Portfolio</title>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <link rel="stylesheet" href="https://use.typekit.net/tlw3ues.css">

    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/anc.css">
    <?php
    include 'assets/backgroundShader.html';
    ?>
    <script type="module" src="JS/main.js"></script>
</head>

<body>
    <header class="flex row justify-content-between text-color-second">
        <div class="background-main flex align-items-center padding-small border-radius-top-right border-radius-bottom-right">
            <p>Martin Delhaye</p>
        </div>
        <nav
            class="background-main flex justify-content-between align-items-center padding-small border-radius-top-left border-radius-bottom-left">
            <button id="menuBurger" class="text-center display-none navButton" aria-label="Ouvrir le menu">
                &#9776;
            </button>
            <ul id="menuNav" class="flex align-items-center gap-medium column-mobile">
                <li><a href="#competences" class="animation-hoverBarre">Compétences</a></li>
                <li><a href="#projets" class="animation-hoverBarre">Projets</a></li>
                <li><a href="#contact" class="animation-hoverBarre">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="accueil">
            <!-- <div class="width-100 height-100 flex column align-items-center justify-content-between text-center text-color-white"> -->
                <div class="flex row column-mobile align-items-center justify-content-between height-100 gap-medium padding-large text-center text-color-white">
                    <?php echo makePicture('Images/photoProfile.png', 'Photo de profil', 'width-100 height-100 shadow'); ?>
                    <div class="flex column background-black padding-small border-radius">
                        <h1 class="margin-auto text-color-white ">Developpeur Web</h1>
                        <p class="overflowX-scroll text-justify">
                            Bonjour, je m’appelle Martin et j’ai 19 ans. Je viens de terminer la deuxième année de mon BUT
                            Métiers du Multimédia et de l’Internet (MMI). Le codage est une véritable passion pour moi, et je
                            cherche constamment à approfondir mes connaissances dans ce domaine. Je suis particulièrement
                            intéressé par le développement backend et les défis de réflexions qu’il présente. Mon objectif est
                            de continuer à apprendre et à améliorer mes compétences dans ce domaine.
                        </p>
                        <a href="Delhaye-Martin-CV.pdf" target="_blank"><button class="button">Mon CV</button></a>
                </div>
            </div>
        </section>
        <!-- <a href="#quiJeSuis"
                    class="animation-hautBas bottom-0 left-50"><?php echo makePicture('images/Icon-flèche-bas-rose.png', 'Flèche aller vers le bas', 'icon'); ?>
                </a> -->
        <!-- <section id="quiJeSuis"
            class="background-main flex column justify-content-between align-items-center height-screen text-color-white padding-small">
            <h2>Qui Je Suis ?</h2>
           
        </section> -->
        <section id="competences" class="background-second flex column align-items-center text-color-white padding-small gap-large">
            <h2>Mes Compétences</h2>
            <div id="listeCompetences" class="flex column height-80 gap-medium width-100 margin-auto">

                <h3>Langages de programmation</h3>
                <div class="grid-competences">
                    <?php
                    foreach ($listeLangages as $langage) {
                        echo afficherCompetenceEtEnfants($langage, $listeSousCompetences);
                    }
                    ?>
                </div>
                <h3>CMS</h3>
                <article class="flex row gap-medium flex-wrap">
                    <?php
                    foreach ($listeCMS as $cms) {
                        echo afficherCompetence($cms['nom_competence'], $cms['image_competence']);
                    }
                    ?>
                </article>
                <h3>Logiciels</h3>
                <article class="flex row gap-medium flex-wrap">
                    <?php
                    foreach ($listeLogiciels as $logiciel) {
                        echo afficherCompetence($logiciel['nom_competence'], $logiciel['image_competence']);
                    }
                    ?>
                </article>
            </div>
        </section>

        <section id="projets"
            class="height-screen background-main flex column align-items-center text-color-white padding-small gap-large">
            <h2>Mes Projets</h2>
            <div class="flex row height-80 gap-medium width-100 align-items-center overflowX-scroll">
                <?php
                foreach ($listeProjets as $focus) {
                    echo afficherProjet($focus['id_projet'], $focus['titre_projet'], $focus['illustration_projet'], $focus['date_projet']);
                }
                ?>
            </div>
        </section>
        <section id="contact" class=" flex column justify-content-between align-items-center height-screen text-color-white padding-small text-color-main">
            <h2 class="text-color-white">Me contacter</h2>
            <div class="flex column align-items-center gap-medium">
                <a href="mailto:delhayemar1@gmail.com"
                    class="flex align-items-center gap-small button button-icon"><?php echo makePicture('Images/Icon-Mail.png', 'Icone mail', 'icon'); ?>
                    <p>delhayemar1@gmail.com</p>
                </a>
                <a href="tel:06 24 52 81 84"
                    class="flex align-items-center gap-small button button-icon"><?php echo makePicture('Images/Icon-Tel.png', 'Icone Tel', 'icon'); ?>
                    <p>06 24 52 81 84</p>
                </a>
            </div>
            <div id="reseauxSociaux" class="flex row align-items-center gap-medium">
                <a href="https://www.linkedin.com/in/martindelhaye/" target="_blank" class="button flex align-items-center filtre-blanc">
                    <?php echo makePicture('Images/reseauxSociaux/icon-LinkedIn.webp', 'Icone Tel', 'icon'); ?>
                </a>
                <a href="https://github.com/MartinDelhaye" target="_blank" class="button button-icon flex align-items-center ">
                    <?php echo makePicture('Images/reseauxSociaux/icon-GitHub.png', 'Icone Tel', 'icon'); ?>
                </a>
            </div>
        </section>
    </main>

    <a href="#" class="button button-icon flex align-items-center filtre-blanc " id="returnTop">
        <?php echo makePicture('Images/Icon-flèche-bas-bleu.png', 'Haut de la page', 'icon-small button-icon'); ?>
    </a>
</body>

</html>