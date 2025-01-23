<?php

include("Config/config.php");


$listeCompetencesLangage = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "Langage"');
$listeCompetencesLibrairie = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "Librairie"');
$listeCompetencesCMS = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "CMS"');
$listeCompetencesLogiciel = obtenirDonnees('nom_competence, image_competence', 'competences', 'type_competence = "Logiciel"');

$listeProjets = obtenirDonnees('id_projet, titre_projet, illustration_projet, date_projet', 'projets', '', 'date_projet DESC');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php infoMeta(); ?>
    <meta name="description" content="Site du Portfolio de Martin Delhaye">
    <meta name="keywords" content="Martin Delhaye, Portfolio, Devellopement Web">
    <title>Martin Delhaye - Portfolio</title>
</head>

<body>
<?php
    session_start();
    if(!isset($_SESSION['connecte'])) :
        $_SESSION['connecte'] = true;
        ?>
        <div class="splashscreen text-white flex justify-content-center align-items-center">
            <h2>Bienvenue !</h2>
        </div>
    <?php endif; ?>
    <header class="fond-main flex row justify-content-between align-items-center text-second width-100 padding-small border-rond border-rond-no-top">
        <p class="text-important">Martin Delhaye</p>
        <nav class ="fond-main flex row justify-content-center border-rond border-rond-no-right padding-small">
            <button id="menuBurger" class="text-center display-none navButton" aria-label="Ouvrir le menu">
                &#9776;
            </button>
            <div id="menuNav" class="flex align-items-center gap-medium  column-mobile">
                <a href="#quiJeSuis" class="animation-hoverBarre">Qui Je suis </a>
                <a href="#competences" class="animation-hoverBarre">Compétences</a>
                <a href="#projets" class="animation-hoverBarre">Projets</a>
                <a href="#contact" class="animation-hoverBarre">Contact</a>
            </div>
        </nav>
    </header>


    <main>
        <section id="acceuil" class="flex column justify-content-between align-items-center height-screen ">
            <div class="flex column text-center text-main">
                <h1 >Développeur Web</h1>
                <p id="sous-titre">Actuellement en recherche de Stage</p>
            </div>
            <a href="#quiJeSuis"
                class="text-center animation-hautBas"><?php echo afficherImage('Images/Icon-flèche-bas-bleu.png', 'Flèche aller vers le bas', 'icon'); ?>
            </a>
        </section>
        <section id="quiJeSuis"
            class="fond-main flex column justify-content-between align-items-center height-screen text-white padding-small">
            <h2>Qui Je Suis ?</h2>
            <div id="presentation" class="flex row column-mobile align-items-center justify-content-center height-80 gap-medium padding-large">
                <?php echo afficherImage('Images/Photo_Delhaye_Martin.jpg', 'Photo de profil', 'width-33 width-100-mobile border-second border-rond'); ?>
                <p class="overflowX-scroll">
                    Bonjour, je m’appelle Martin et j’ai 18 ans. Actuellement, je suis en deuxième année d’un BUT
                    Métiers du Multimédia et de l’Internet (MMI). Le codage est une véritable passion pour moi, et je
                    cherche constamment à approfondir mes connaissances dans ce domaine. Je suis particulièrement
                    intéressé par le développement backend et les défis de réflexions qu’il présente. Mon objectif est
                    de continuer à apprendre et à améliorer mes compétences dans ce domaine passionnant.
                </p>
            </div>
            <a href="Delhaye-Martin-CV.pdf" target="_blank"><button class="button">Mon CV</button></a>
        </section>
        <section id="competences" class="min-height-screen fond-second flex column align-items-center  text-white padding-small gap-large">
            <h2>Mes Compétences</h2>
            <div id="listeCompetences" class="flex column height-80 gap-medium width-100 ">
                <div class="flex row column-mobile gap-medium justify-content-between">
                    <div class="flex column gap-medium width-50 width-100-mobile">
                        <h3>Langages de programation</h3>
                        <article id="listeLangage" class="flex row gap-medium flex-wrap">
                            <?php
                            foreach ($listeCompetencesLangage as $focus) {
                                echo afficherCompetence($focus['nom_competence'], $focus['image_competence']);
                            }
                            ?>
                        </article>
                        <h3>Librairie</h3>
                        <article id="listeLibrairie" class="flex row gap-medium flex-wrap">
                            <?php
                            foreach ($listeCompetencesLibrairie as $focus) {
                                echo afficherCompetence($focus['nom_competence'], $focus['image_competence']);
                            }
                            ?>
                        </article>
                        <h3>CMS</h3>
                        <article id="listeCMS" class="flex row gap-medium flex-wrap">
                            <?php
                            foreach ($listeCompetencesCMS as $focus) {
                                echo afficherCompetence($focus['nom_competence'], $focus['image_competence']);
                            }
                            ?>
                        </article>
                        <h3>Logiciel</h3>
                        <article id="listeLogiciel" class="flex row gap-medium flex-wrap">
                            <?php
                            foreach ($listeCompetencesLogiciel as $focus) {
                                echo afficherCompetence($focus['nom_competence'], $focus['image_competence']);
                            }
                            ?>
                        </article>
                    </div>
                    <div class="flex column justify-content-center width-33 width-100-mobile">
                        <h3>À Venir</h3>
                        <p>Actuellement en formation, je vais prochainement enrichir mes compétences avec de nouvelles technologies et pratiques :<br>
                            - Theming WordPress<br>
                            - Création de pages interactives avec ThreeJs<br>
                            - React/Next.js<br>
                            - Symfony <br>
                            - Les bases de l'intégration continue et du versioning <br><br>
                        Voici d’ailleurs l’un des prochains projets sur lesquels je vais travailler <br>
                        Développer une application complète en React, connectée à une API développée avec Symfony et intégrant une base de données.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section id="projets"
            class="height-screen fond-main flex column align-items-center text-white padding-small gap-large">
            <h2>Mes Projets</h2>
            <div class="flex row height-80 gap-medium width-100 align-items-center overflowX-scroll">
                <?php
                foreach ($listeProjets as $focus) {
                    echo afficherProjet($focus['id_projet'], $focus['titre_projet'], $focus['illustration_projet'], $focus['date_projet']);
                }
                ?>
            </div>
        </section>
        <section id="contact" class=" flex column justify-content-between align-items-center height-screen text-white padding-small text-main">
            <h2>Me contacter</h2>
            <div class="flex column align-items-center gap-medium">
                <a href="mailto:delhayemar1@gmail.com"
                    class="flex align-items-center gap-small button button-icon"><?php echo afficherImage('Images/Icon-Mail.png', 'Icone mail', 'icon'); ?>
                    <p>delhayemar1@gmail.com</p>
                </a>
                <a href="tel:06 24 52 81 84"
                    class="flex align-items-center gap-small button button-icon"><?php echo afficherImage('Images/Icon-Tel.png', 'Icone Tel', 'icon'); ?>
                    <p>06 24 52 81 84</p>
                </a>
            </div>
            <div id="reseauxSociaux" class="flex row align-items-center gap-medium">
                <a href="https://www.linkedin.com/in/martindelhaye/" target="_blank" class="button flex align-items-center filtre-blanc">
                    <?php echo afficherImage('Images/reseauxSociaux/icon-LinkedIn.webp', 'Icone Tel', 'icon'); ?>
                </a>
                <a href="https://github.com/MartinDelhaye" target="_blank" class="button button-icon flex align-items-center ">
                    <?php echo afficherImage('Images/reseauxSociaux/icon-GitHub.png', 'Icone Tel', 'icon'); ?>
                </a>
            </div>
        </section>
    </main>

    <a href="#" class="button button-icon flex align-items-center filtre-blanc " id="returnTop">
        <?php echo afficherImage('Images/Icon-flèche-bas-bleu.png', 'Haut de la page', 'icon-small button-icon'); ?>
    </a>
    
</body>

</html>