<?php

$pdo = new PDO('sqlite:' . __DIR__ . '/../data/database.sqlite');

// supprimer  les questions test
$pdo->exec("DELETE FROM question");

$stmt = $pdo->prepare("
    INSERT INTO question (id, intitule, reponse, texte_vrai, texte_faux, created_at)
    VALUES (:id, :intitule, :reponse, :texte_vrai, :texte_faux, :created_at)
");

$questionsData = [
    ['intitule'=>"Le RGPD s'applique uniquement aux entreprises basées en Europe.", 'reponse'=>false, 'texte_vrai'=>"Le RGPD s'applique à toute entreprise traitant les données de citoyens européens.", 'texte_faux'=>"Faux : le RGPD s'applique aussi aux entreprises hors UE si elles traitent les données de citoyens européens."],
    ['intitule'=>"Une donnée personnelle est toute information permettant d’identifier directement ou indirectement une personne.", 'reponse'=>true, 'texte_vrai'=>"Exact, par exemple nom, email, IP, etc.", 'texte_faux'=>"Faux, c’est la définition exacte d’une donnée personnelle."],
    ['intitule'=>"Le consentement de la personne est toujours obligatoire pour traiter ses données.", 'reponse'=>false, 'texte_vrai'=>"Il existe d’autres bases légales comme l’exécution d’un contrat.", 'texte_faux'=>"Faux : le consentement n’est pas la seule base légale."],
    ['intitule'=>"Les entreprises doivent informer les utilisateurs de la finalité de la collecte de données.", 'reponse'=>true, 'texte_vrai'=>"Oui, la transparence est obligatoire selon le RGPD.", 'texte_faux'=>"Faux, c’est exactement ce que le RGPD impose."],
    ['intitule'=>"Les données collectées peuvent être conservées indéfiniment.", 'reponse'=>false, 'texte_vrai'=>"Les données doivent être conservées pour une durée limitée adaptée à la finalité.", 'texte_faux'=>"Faux : le stockage illimité viole le principe de limitation."],
    ['intitule'=>"Les utilisateurs ont le droit de demander la suppression de leurs données.", 'reponse'=>true, 'texte_vrai'=>"C’est le droit à l’effacement, ou « droit à l’oubli ».", 'texte_faux'=>"Faux, c’est un droit fondamental prévu par le RGPD."],
    ['intitule'=>"Il est légal de partager les données personnelles sans avertir la personne concernée.", 'reponse'=>false, 'texte_vrai'=>"Il faut informer ou obtenir le consentement selon le traitement.", 'texte_faux'=>"Faux : partager sans transparence est illégal."],
    ['intitule'=>"Les mots de passe doivent être stockés en clair pour plus de simplicité.", 'reponse'=>false, 'texte_vrai'=>"Les mots de passe doivent être hachés pour sécuriser les données.", 'texte_faux'=>"Faux : stocker en clair est une grave faille de sécurité."],
    ['intitule'=>"Les entreprises doivent notifier les violations de données à l’autorité compétente dans les 72 heures.", 'reponse'=>true, 'texte_vrai'=>"Exact, c’est une obligation légale du RGPD.", 'texte_faux'=>"Faux, c’est exactement ce que prévoit la loi."],
    ['intitule'=>"Les cookies de suivi nécessitent souvent le consentement de l’utilisateur.", 'reponse'=>true, 'texte_vrai'=>"Sauf exceptions, le consentement est requis pour les cookies non essentiels.", 'texte_faux'=>"Faux, c’est obligatoire dans la plupart des cas."],
    ['intitule'=>"Les données sensibles comme la santé peuvent être traitées sans protection particulière.", 'reponse'=>false, 'texte_vrai'=>"Les données sensibles nécessitent des mesures renforcées.", 'texte_faux'=>"Faux : leur traitement est strictement encadré."],
    ['intitule'=>"Une politique de confidentialité doit être facilement accessible et compréhensible.", 'reponse'=>true, 'texte_vrai'=>"Oui, la clarté et l’accessibilité sont obligatoires.", 'texte_faux'=>"Faux, la loi exige cette transparence."],
    ['intitule'=>"Une personne peut demander à accéder à toutes ses données personnelles.", 'reponse'=>true, 'texte_vrai'=>"C’est le droit d’accès prévu par le RGPD.", 'texte_faux'=>"Faux, le droit d’accès permet à chacun de consulter ses données."],
    ['intitule'=>"Les entreprises peuvent ignorer les demandes de suppression si elles veulent.", 'reponse'=>false, 'texte_vrai'=>"Les demandes doivent être traitées sauf exceptions légales.", 'texte_faux'=>"Faux : ignorer la demande constitue une violation."],
    ['intitule'=>"Les données collectées doivent être exactes et mises à jour si nécessaire.", 'reponse'=>true, 'texte_vrai'=>"C’est le principe d’exactitude du RGPD.", 'texte_faux'=>"Faux, le RGPD exige la mise à jour pour éviter les erreurs."],
    ['intitule'=>"Les mineurs n’ont pas de droits particuliers sur leurs données personnelles.", 'reponse'=>false, 'texte_vrai'=>"Les mineurs ont des droits spécifiques, notamment pour le consentement parental.", 'texte_faux'=>"Faux : le RGPD protège les mineurs de manière spéciale."],
    ['intitule'=>"La sécurisation des données personnelles est uniquement la responsabilité du service informatique.", 'reponse'=>false, 'texte_vrai'=>"Toute l’organisation doit être impliquée dans la protection des données.", 'texte_faux'=>"Faux : la responsabilité est globale et organisationnelle."],
    ['intitule'=>"Les entreprises peuvent transférer les données en dehors de l’UE si le pays garantit un niveau de protection adéquat.", 'reponse'=>true, 'texte_vrai'=>"Exact, c’est prévu par le RGPD (ex. Privacy Shield ou accords équivalents).", 'texte_faux'=>"Faux, le transfert est possible uniquement sous conditions."],
    ['intitule'=>"Les employés doivent être formés à la protection des données personnelles.", 'reponse'=>true, 'texte_vrai'=>"Oui, la formation est obligatoire pour réduire les risques.", 'texte_faux'=>"Faux, la loi impose cette obligation."],
    ['intitule'=>"Les logs d’accès contenant des données personnelles doivent être protégés.", 'reponse'=>true, 'texte_vrai'=>"Oui, même les logs peuvent contenir des informations personnelles sensibles.", 'texte_faux'=>"Faux, ils doivent être sécurisés pour éviter les fuites."]
];

// insérer chaque question
foreach ($questionsData as $index => $qData) {
    $stmt->execute([
        ':id' => $index + 1,
        ':intitule' => $qData['intitule'],
        ':reponse' => $qData['reponse'] ? 1 : 0,
        ':texte_vrai' => $qData['texte_vrai'],
        ':texte_faux' => $qData['texte_faux'],
        ':created_at' => date('Y-m-d H:i:s'),
    ]);
}

