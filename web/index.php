<?php
include 'config/config.php';
include "PHP/fonctions.php";

$listeCompetences = obtenirDonnees(
    'id_competence, nom_competence, image_competence',
    'competences',
    'parent_id IS NULL'
);
$listeSousCompetences = obtenirDonnees(
    'id_competence, nom_competence, image_competence, parent_id',
    'competences',
    'parent_id IS NOT NULL'
);

$listeProjets = obtenirDonnees(
    'id_projet, titre_projet, illustration_projet',
    'projets',
    trier: 'date_projet DESC'
);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martin Delhaye">
    <meta name="description" content="Site du Portfolio de Martin Delhaye">
    <meta name="keywords" content="Martin Delhaye, Portfolio, Développement Web">
    <title>Martin Delhaye - Portfolio</title>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <!-- add de la police Coolvetica -->
    <link rel="stylesheet" href="https://use.typekit.net/tlw3ues.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/competences.css">
    <link rel="stylesheet" href="CSS/projets.css">
    <link rel="stylesheet" href="CSS/animations.css">
    <link rel="stylesheet" href="CSS/texts.css">
    <link rel="stylesheet" href="CSS/responsive.css">
    <?php
    include 'assets/backgroundShader.html';
    ?>
    <script type="module" src="JS/main.js"></script>
</head>

<body>
    <header class="position-absolute flex row justify-content-between width-100 text-color-second">
        <div class="background-glass-main flex align-items-center padding-small border-radius-bottom-right">
            <p>Martin Delhaye</p>
        </div>
        <nav>
            <button id="menuBurger" class="background-glass-main text-center display-none border-radius-bottom-left" aria-label="Ouvrir le menu">
                &#9776;
            </button>
            <ul id="menuNav" class="flex gap-medium column-mobile">
                <li><a href="#projets" class="animation-hoverBarre">Projets</a></li>
                <li><a href="#competences" class="animation-hoverBarre">Compétences</a></li>
                <li><a href="#contact" class="animation-hoverBarre">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="accueil">
            <div class="flex column align-items-center justify-content-between">
                <div class=" width-100 flex row column-mobile align-items-center height-80 gap-medium text-center text-color-white no-gap-mobile">
                    <img fetchpriority="high" class="height-100" src="images/photoProfile.webp" alt="Photo de profil" title="Cmoi"/>
                    <div class="flex column align-items-center gap-medium background-black padding-small border-radius background-glass-main ">
                        <h1 class="margin-auto text-color-white ">Développeur Web</h1>
                        <p class="overflowX-scroll text-justify">
                            Bonjour, je m’appelle Martin et j’ai <?php echo obtenirAge(); ?> ans. Je viens de terminer la deuxième année de mon BUT
                            Métiers du Multimédia et de l’Internet (MMI). Le codage est une véritable passion pour moi, et je
                            cherche constamment à approfondir mes connaissances dans ce domaine. Je suis particulièrement
                            intéressé par le développement backend et les défis de réflexions qu’il présente. Mon objectif est
                            de continuer à apprendre et à améliorer mes compétences dans ce domaine
                        </p>
                        <a href="Delhaye-Martin-CV.pdf" target="_blank" class="button width-content">Mon CV</a>
                    </div>
                </div>
                <a href="#competences"
                    class="animation-hautBas bottom-0 left-50"><?php echo makePicture('images/Icon-flèche-bas-rose.png', 'Flèche aller vers le bas', 'icon'); ?>
                </a>
            </div>
        </section>
        <section id="projets">
            <div class="background-glass-main flex column align-items-between text-color-white padding-small gap-large">
                <h2>Mes Projets</h2>
                <div class="flex align-items-center justify-content-center width-100 height-100 gap-medium column-mobile noactive" id="projet-container">
                    <div class="flex column width-100 height-100 gap-small" id="listeProjets">
                        <?php
                        foreach ($listeProjets as $projet) {
                            echo displayProject($projet);
                        }
                        ?>
                    </div>
                    <div id="projet-detail" class="flex column-mobile height-100 justify-content-between align-items-center background-glass-second background-second padding-small gap-medium border-radius">
                        <div id="container-projetInfo" class="flex column gap-large width-100 height-100 align-items-center justify-content-center">
                            <div class="flex column gap-small width-100">
                                <h3 id="projet-titre"></h3>
                                <div id="projet-lien" class="flex gap-small">
                                    <a href="#" id="projet-url" target="_blank" style="display:none;">
                                        <button class="button">Découvrir le projet</button>
                                    </a>
                                    <a href="#" id="projet-github" target="_blank" style="display:none;">
                                        <button class="button">Voir le code</button>
                                    </a>
                                </div>
                            </div>
                            <p id="projet-description" class="overflowX-scroll"></p>
                        </div>
                        <div id="container-diapo" class="position-relative flex column width-50 height-100 justify-content-center">
                            <div id="diapo" class="flex-grow-1">
                                <img class="arrow left-arrow" alt="Une image" src="images/iconFlecheGauche.png" id="Precedent" loading="lazy">
                                <img class="arrow right-arrow" alt="Une image" src="images/iconFlecheDroite.png" id="Suivant" loading="lazy">
                            </div>
                            <input type="button" value="Pause" id="Pause" class="display-none"><br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="competences">
            <div class="background-glass-main flex column align-items-center text-color-white padding-small gap-medium">
                <h2>Mes Compétences</h2>
                <div id="listeCompetences" class="flex column align-items-center flex-wrap height-100 gap-medium width-100 margin-auto overflowY-scroll">
                    <?php
                    displayCompetences($listeCompetences, $listeSousCompetences);
                    ?>
                </div>
            </div>
        </section>
        <section id="contact" class=" flex column justify-content-between align-items-center height-screen text-color-white text-color-main">
            <h2 class="background-glass-main padding-small border-radius text-color-white">Me contacter</h2>
            <div class="flex column align-items-center justify-content-center gap-medium">
                <a href="mailto:delhayemar1@gmail.com"
                    class="flex align-items-center gap-small button button-icon"><?php echo makePicture('images/contact/iconMail.webp', 'Icone mail', 'icon'); ?>
                    <p>delhayemar1@gmail.com</p>
                </a>
                <a href="tel:06 24 52 81 84"
                    class="flex align-items-center gap-small button button-icon"><?php echo makePicture('images/contact/Icon-Tel.png', 'Icone Tel', 'icon'); ?>
                    <p>06 24 52 81 84</p>
                </a>
                <div id="reseauxSociaux" class="flex row align-items-center justify-content-center gap-medium">
                    <a href="https://www.linkedin.com/in/martindelhaye/" target="_blank" class="button flex align-items-center filter-blanc">
                        <?php echo makePicture('images/contact/icon-LinkedIn.webp', 'Icone Tel', 'icon'); ?>
                    </a>
                    <a href="https://github.com/MartinDelhaye" target="_blank" class="button button-icon flex align-items-center ">
                        <?php echo makePicture('images/contact/iconGitHub.webp', 'Icone Tel', 'icon'); ?>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <a href="#" class="button button-icon flex align-items-center filter-blanc " id="returnTop">
        <?php echo makePicture('images/Icon-flèche-bas-bleu.png', 'Haut de la page', 'icon-small button-icon'); ?>
    </a>
</body>

</html>