<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Portfolio\Infrastructure\Repository\ProjetRepository;
use Portfolio\Application\Service\Projet\GetProjetByIdService;
use Portfolio\Infrastructure\Api\Projet\GetProjetByIdController;

$projetRepository = new ProjetRepository($bdd);
$service = new GetProjetByIdService($projetRepository);
$controller = new GetProjetByIdController($service);

$controller->handle($_GET['id_projet'] ?? null);
