<?php
include 'config/config.php';
include "PHP/fonctions.php";
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
    <script type="module" src="JS/main.js"></script>
</head>

<body>
    <header class="flex row justify-content-between text-color-second">
        <div class="fond-main flex align-items-center padding-small border-radius-top-right border-radius-bottom-right">
            <p>Martin Delhaye</p>
        </div>
        <nav class="fond-main flex justify-content-between align-items-center padding-small border-radius-top-left border-radius-bottom-left">
            <button id="menuBurger" class="text-center display-none navButton" aria-label="Ouvrir le menu">
                &#9776;
            </button>
            <ul id="menuNav" class="flex align-items-center gap-medium column-mobile">
                <li><a href="#quiJeSuis" class="animation-hoverBarre">Qui Je suis </a></li>
                <li><a href="#competences" class="animation-hoverBarre">Compétences</a></li>
                <li><a href="#projets" class="animation-hoverBarre">Projets</a></li>
                <li><a href="#contact" class="animation-hoverBarre">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="accueil" class="height-screen flex column align-items-center text-center text-color-second">
            <h1 class="display-none">Developpeur Web</h1>
            <a href="#quiJeSuis"
                class="animation-hautBas position-absolute bottom-0 left-50"><?php echo makePicture('images/Icon-flèche-bas-rose.png', 'Flèche aller vers le bas', 'icon'); ?>
            </a>
        </section>
    </main>
</body>

</html>