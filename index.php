<?php
require __DIR__ . '/vendor/autoload.php';
include 'config/config.php';
include 'PHP/fonctions.php';

use Portfolio\Infrastructure\Repository\ProjetRepository;
use Portfolio\Infrastructure\Repository\CompetenceRepository;
use Portfolio\Application\Service\Projet\GetProjetsListService;
use Portfolio\Application\Service\Competence\GetCompetencesGroupedByTypeService;

$projetRepository = new ProjetRepository($bdd);
$competenceRepository = new CompetenceRepository($bdd);

$listeProjets = (new GetProjetsListService($projetRepository))->execute();
$groupesCompetences = (new GetCompetencesGroupedByTypeService($competenceRepository))->execute();
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

    <!-- Style -->
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <header>
    </header>

    <main>

</main>
</body>

</html>
