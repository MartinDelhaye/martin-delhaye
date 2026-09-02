<?php

namespace Portfolio\Infrastructure\Api\Projet;

use Portfolio\Application\Service\Projet\GetCompetencesForProjetService;
use Portfolio\Infrastructure\Api\ResponseData;

final class GetCompetencesForProjetController
{
    public function __construct(private readonly GetCompetencesForProjetService $service)
    {
    }

    public function handle(?string $idProjetBrut): void
    {
        if ($idProjetBrut === null || !ctype_digit($idProjetBrut)) {
            ResponseData::erreur('Paramètre id_projet manquant ou invalide', 400);
            return;
        }

        $competences = $this->service->execute((int) $idProjetBrut);

        ResponseData::succes([
            'competences' => array_map(
                fn ($c) => [
                    'id_competence' => $c->id()->value(),
                    'nom_competence' => $c->nom(),
                    'image_competence' => $c->image(),
                    'type_competence' => $c->type()->value,
                ],
                $competences
            ),
        ]);
    }
}
