<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Portfolio\Infrastructure\Repository\CompetenceRepository;
use Portfolio\Application\Service\Projet\GetCompetencesForProjetService;
use Portfolio\Infrastructure\Api\Projet\GetCompetencesForProjetController;

$competenceRepository = new CompetenceRepository($bdd);
$service = new GetCompetencesForProjetService($competenceRepository);
$controller = new GetCompetencesForProjetController($service);

$controller->handle($_GET['id_projet'] ?? null);
