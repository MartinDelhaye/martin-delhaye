<?php

namespace Portfolio\Infrastructure\Api;

/**
 * Enveloppe JSON standard pour toutes les réponses API.
 * Garde le contrat existant utilisé par le JS actuel : {statut, ...}
 * ou {statut: "erreur", erreur: "..."}.
 */
final class ResponseData
{
    public static function succes(array $donnees): void
    {
        self::envoyer(['statut' => 'ok'] + $donnees);
    }

    public static function erreur(string $message, int $codeHttp = 404): void
    {
        http_response_code($codeHttp);
        self::envoyer(['statut' => 'erreur', 'erreur' => $message]);
    }

    private static function envoyer(array $donnees): void
    {
        header('Content-Type: application/json');
        echo json_encode($donnees, JSON_UNESCAPED_UNICODE);
    }
}
