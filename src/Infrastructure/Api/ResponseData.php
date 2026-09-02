<?php

namespace Portfolio\Infrastructure\Api;

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
