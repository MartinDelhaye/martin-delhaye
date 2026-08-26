<?php

namespace Portfolio\Infrastructure\Api\Projet;

use Portfolio\Application\Service\Projet\GetProjetByIdService;
use Portfolio\Infrastructure\Api\ResponseData;

final class GetProjetByIdController
{
    public function __construct(private readonly GetProjetByIdService $service)
    {
    }

    public function handle(?string $idProjetBrut): void
    {
        if ($idProjetBrut === null || !ctype_digit($idProjetBrut)) {
            ResponseData::erreur('Paramètre id_projet manquant ou invalide', 400);
            return;
        }

        $projet = $this->service->execute((int) $idProjetBrut);

        if ($projet === null) {
            ResponseData::erreur('Projet non trouvé', 404);
            return;
        }

        ResponseData::succes([
            'projet' => [
                'id_projet' => $projet->id()->value(),
                'titre_projet' => $projet->titre(),
                'texte_projet' => $projet->texte(),
                'date_projet' => $projet->date(),
                'url_projet' => $projet->urlProjet(),
                'urlGitHub_projet' => $projet->urlGitHub(),
                'illustration_projet' => $projet->illustration(),
                'images' => array_map(
                    fn ($image) => ['url_image' => $image->url()],
                    $projet->images()
                ),
            ],
        ]);
    }
}
