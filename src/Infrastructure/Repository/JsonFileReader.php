<?php

namespace Portfolio\Infrastructure\Repository;

final class JsonFileReader
{
    public static function lire(string $chemin): array
    {
        if (!file_exists($chemin)) {
            throw new \RuntimeException("Fichier de données introuvable : $chemin");
        }

        $contenu = file_get_contents($chemin);
        $donnees = json_decode($contenu, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON invalide dans $chemin : " . json_last_error_msg());
        }

        return $donnees;
    }
}