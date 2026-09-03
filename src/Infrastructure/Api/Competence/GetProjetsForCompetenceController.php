<?php

namespace Portfolio\Infrastructure\Api\Competence;

use Portfolio\Application\Service\Competence\GetProjetsForCompetenceService;
use Portfolio\Infrastructure\Api\ResponseData;

final class GetProjetsForCompetenceController
{
    public function __construct(private readonly GetProjetsForCompetenceService $service)
    {
    }

    public function handle(?string $idCompetenceBrut): void
    {
        if ($idCompetenceBrut === null || !ctype_digit($idCompetenceBrut)) {
            ResponseData::erreur('Paramètre id_competence manquant ou invalide', 400);
            return;
        }

        $projets = $this->service->execute((int) $idCompetenceBrut);

        ResponseData::succes([
            'projets' => array_map(
                fn ($p) => [
                    'id_projet' => $p->getId()->getValue(),
                    'titre_projet' => $p->titre(),
                    'illustration_projet' => $p->illustration(),
                ],
                $projets
            ),
        ]);
    }
}
