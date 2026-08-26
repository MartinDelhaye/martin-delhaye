<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Portfolio\Infrastructure\Repository\ProjetRepository;
use Portfolio\Application\Service\Competence\GetProjetsForCompetenceService;
use Portfolio\Infrastructure\Api\Competence\GetProjetsForCompetenceController;

$projetRepository = new ProjetRepository($bdd);
$service = new GetProjetsForCompetenceService($projetRepository);
$controller = new GetProjetsForCompetenceController($service);

$controller->handle($_GET['id_competence'] ?? null);
