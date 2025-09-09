-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : dim. 31 août 2025 à 16:28
-- Version du serveur : 11.7.2-MariaDB-ubu2404
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mdportfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `id_competence` int(11) NOT NULL,
  `nom_competence` varchar(100) NOT NULL,
  `image_competence` varchar(255) DEFAULT NULL,
  `type_competence` varchar(50) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `competences`
--

INSERT INTO `competences` (`id_competence`, `nom_competence`, `image_competence`, `type_competence`, `parent_id`, `description`) VALUES
(1, 'PHP', 'images/competences/logo-PHP.png', 'Langage', NULL, NULL),
(2, 'SQL', 'images/competences/logo-SQL.png', 'Langage', NULL, NULL),
(3, 'HTML', 'images/competences/logo-HTML.png', 'Langage', NULL, NULL),
(4, 'CSS', 'images/competences/logo-CSS.png', 'Langage', NULL, NULL),
(5, 'JavaScript', 'images/competences/logo-JavaScript.png', 'Langage', NULL, NULL),
(6, 'Python', 'images/competences/logo-Python.png', 'Langage', NULL, NULL),
(7, 'Snap.js', 'images/competences/logo-Snap.js.svg', 'Librairie', 5, NULL),
(8, 'GSAP', 'images/competences/logo-GSAP.jpg', 'Librairie', 5, NULL),
(9, 'WordPress', 'images/competences/logo-WordPress.png', 'CMS', NULL, NULL),
(10, 'Visual Studio Code', 'images/competences/logo-Visual_Studio_Code.png', 'Logiciel', NULL, NULL),
(11, 'MySQL', 'images/competences/logo-MySQL.png', 'Logiciel', NULL, NULL),
(12, 'Figma', 'images/competences/logo-Figma.svg', 'Logiciel', NULL, NULL),
(13, 'InDesign', 'images/competences/logo-InDesign.png', 'Logiciel', NULL, NULL),
(14, 'Illustrator', 'images/competences/logo-Illustrator.png', 'Logiciel', NULL, NULL),
(15, 'Photoshop', 'images/competences/logo-Photoshop.png', 'Logiciel', NULL, NULL),
(16, 'Symfony', 'images/competences/logo-Symfony.png', 'Librairie', 1, NULL),
(17, 'Twig', 'images/competences/logo-Twig.png', 'Librairie', 1, NULL),
(20, 'THREE.JS', 'images/competences/logo-THREE.JS.png', 'Librairie', 5, NULL),
(21, 'React', 'images/competences/logo-React.png', 'Framework', 5, NULL),
(22, 'Next.js', 'images/competences/logo-Next.js.png', 'Framework', 21, NULL),
(23, 'Ammo.js', 'images/competences/logo-Ammo.js.png', 'Librairie', 20, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `images_projet`
--

CREATE TABLE `images_projet` (
  `id_image` int(11) NOT NULL,
  `id_projet` int(11) DEFAULT NULL,
  `url_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_projet`
--

INSERT INTO `images_projet` (`id_image`, `id_projet`, `url_image`) VALUES
(1, 1, 'images/Projets/MaMusique/carrousel-1.png'),
(2, 1, 'images/Projets/MaMusique/carrousel-2.png'),
(3, 5, 'images/Projets/TwoSeeToSee/2.png'),
(4, 5, 'images/Projets/TwoSeeToSee/3.png'),
(5, 5, 'images/Projets/TwoSeeToSee/5.png'),
(6, 5, 'images/Projets/TwoSeeToSee/7.png'),
(7, 5, 'images/Projets/TwoSeeToSee/9.png');

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id_projet` int(11) NOT NULL,
  `titre_projet` varchar(255) NOT NULL,
  `texte_projet` varchar(3000) NOT NULL,
  `date_projet` date DEFAULT NULL,
  `url_projet` varchar(255) DEFAULT NULL,
  `urlGitHub_projet` varchar(255) DEFAULT NULL,
  `illustration_projet` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id_projet`, `titre_projet`, `texte_projet`, `date_projet`, `url_projet`, `urlGitHub_projet`, `illustration_projet`) VALUES
(1, 'MaMusique', 'Pour ce projet, j’ai conçu un site web mettant en avant les musiques, albums, groupes et artistes que j’apprécie.\r\nIl s’agit de mon premier projet intégrant une base de données (BDD). J’ai également développé une page d’administration permettant de supprimer, modifier et ajouter des données.\r\n\r\nPour modéliser cette BDD, j’ai d’abord réalisé un schéma relationnel, suivi d’un modèle entité-association.\r\n\r\nConcernant la partie front-end, et plus particulièrement le JavaScript, je n’étais pas autorisé à utiliser de librairies ou plugins externes. De plus, une liste précise d’interactions m’a été imposée. J’ai donc implémenté les fonctionnalités suivantes :\r\n\r\n- Carrousel sur la page d’accueil\r\n- Filtre avec listes déroulantes (pour les musiques, albums, groupes et artistes)\r\n- Fenêtres pop-up avec communication entre elles (pour un jeu intégré dans le footer)\r\n- Changement de thème\r\n\r\nJ’ai également découvert l’utilisation des variables CSS, qui m’ont grandement simplifié la mise en place du changement de thème en modifiant ces dernières.', '2024-04-05', 'https://mamusique.martin-delhaye.fr', 'https://github.com/MartinDelhaye/Mamusique', 'images/Projets/MaMusique/illustration-MaMusique.png'),
(2, 'Site Tonnerre 2 Zeus', 'Tonnerre 2 Zeus est mon premier site statique ayant pour objectif de présenter l\'attraction du même nom. Pour ce site j\'ai du réaliser un wireframe avec Figma. Mon site passe le test W3C. De plus pour qu\'il soit facilement modifiable j\'ai veiller à l\'organisation du code que j\'ai commenté.\nJ’ai implémenté une fonctionnalité permettant d’enregistrer les données d\'un formulaire dans un fichier texte, conformément à une contrainte imposée. Ces informations peuvent ensuite être extraites et affichées sous forme de statistiques, le tout en PHP.\nMême si ce projet était scolaire et que je devais de base rester sur de l\'HTML, du CSS et du PHP, afin de résoudre une problématique avec mes formulaires j\'ai pu commencer à faire du JS.\nEn conclusion, ce projet m’a permis de découvrir les bases du développement web', '2023-12-08', 'https://martindelhaye.github.io/Tonnerre_2_Zeus/', 'https://github.com/MartinDelhaye/Tonnerre_2_Zeus', 'images/Projets/Site Tonnerre 2 Zeus/illustration-Site Tonnerre 2 Zeus.png'),
(3, 'Site TheGuardian', 'Dans le cadre de ce projet, j\'ai conçu un site web interactif pour visualiser les données de mobilité électrique dans le Pas-de-Calais. Ce site intègre des graphiques animés et interactifs, en mettant l\'accent sur l’utilisation de Snap.js et GSAP pour enrichir l’expérience utilisateur.\n\nInteraction grâce à Snap.js\nPour la gestion des graphiques interactifs, j\'ai utilisé Snap.js, une librairie JavaScript permettant de manipuler les fichiers SVG de manière simple et efficace.\n\nStructure du fichier SVG : Avant d\'ajouter des interactions, j\'ai préparé mon fichier SVG avec une structure claire, en attribuant des ID uniques à chaque élément graphique (courbes, légendes, etc.), ce qui permet de cibler précisément chaque élément pour les manipulations interactives.\nMise en surbrillance au survol : Grâce à Snap.js, j\'ai implémenté un effet de mise en surbrillance des courbes lorsque l\'utilisateur passe la souris dessus. Cela permet à l\'utilisateur de mieux comprendre les tendances des données en rendant les éléments visuels plus visibles et accessibles.\nInteraction au clic : J\'ai également configuré l\'interaction au clic, où l\'utilisateur peut cliquer sur une courbe ou une légende pour maintenir l\'effet de surbrillance. Cette fonctionnalité permet de focaliser l\'attention sur une donnée spécifique et de faciliter l\'exploration du graphique.\nInteractivité supplémentaire : J\'ai ajouté une interaction via un bouton qui permet à l\'utilisateur de mettre en gras le texte du fichier SVG et de l\'enlever à tout moment, ce qui ajoute une couche d\'interactivité supplémentaire pour l\'utilisateur.\nInteraction grâce à GSAP\nEn complément de Snap.js, j\'ai utilisé GSAP pour apporter des animations fluides et dynamiques aux éléments de la page.\n\nAnimations au survol : J\'ai ajouté des animations sur les titres et les boutons. Par exemple, au survol des titres, une ligne animée apparaît pour souligner le texte.\nChargement de la page : J\'ai appliqué une apparition fluide de la page au chargement et le titre de mon article apparaît lettre par lettre\nInteraction combinée avec Snap.js et GSAP\nL\'intégration des deux librairies, Snap.js et GSAP, m\'a permis de créer une barre de navigation dynamique pour le site. Bien que cette barre ne soit pas encore parfaite, elle permet de visualiser clairement la taille de la page et d\'ajouter une dimension interactive à la navigation. La barre, animée par GSAP, réagit au survol des éléments, et Snap.js gère les interactions spécifiques aux éléments graphiques de la page.\n\nConclusion\nCe projet m’a permis de maîtriser l’utilisation combinée de Snap.js et GSAP pour créer des interactions complexes et fluides. En préparant soigneusement le fichier SVG, j\'ai pu exploiter pleinement ces deux librairies : Snap.js pour gérer les interactions directes avec les éléments graphiques, et GSAP pour les animations globales sur la page. Cette approche m’a permis de concevoir un site web à la fois interactif et visuellement dynamique, facili', '2024-10-02', 'https://martindelhaye.github.io/SAE303.2', 'https://github.com/MartinDelhaye/SAE303.2', 'Images/Projets/TheGuardian/illustration-TheQuardian.png'),
(4, 'Site ADPT', 'Il s\'agit de ma première expérience professisonnel. Effectivement Arnaud Deshamps, un coach sportif, m\'a confié la tâche de réalisé son site. Il s\'agit d\'un site vitrine, dynamique et bien sûr dynamique. Une page d\'administration permet à Arnuad de modifier tout le contenue de son site que ça soit les titres, textes, images, ordre d\'élément sur certaines pages, etc...', '2025-01-12', 'https://adpersonaltraining.fr', NULL, 'Images/Projets/Site ADPT/illustration-Site-ADPT.png'),
(5, 'TwoSeeToSee', 'TwoSeeToSee est un petit jeu fait en 1 semaine. Dans ce dernier j\'ai pu utiliser la librairie THREE.JS, qui permet de faire de la 3D, avec en plus un moteur physique Ammo.js\nPour créer ce jeu, je me suis inspiré de Super Paper Mario avec la mécanique de double caméra permettant de changer entre la 3D et la 2D (contrairement au jeu de base, le mien reste cependant en tout temps en 3D, c\'est seulement le point de vue qui change.\nPour le style, je suis sûr du cartoon car il me permettait d\'avoir un style simple pour ne pas perdre trop de temps sur cette partie au vu des délais que j\'avais.\nActuellement le jeu possède 3 niveaux, pour générer un niveau je charge un fichier JSON avec toutes les différentes plateformes qui vont ensuite être générées.', '2025-04-04', 'https://twoseetosee.martin-delhaye.fr/', NULL, 'Images/Projets/TwoSeeToSee/illustration-TwoSeeToSee.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `competences`
--
ALTER TABLE `competences`
  ADD PRIMARY KEY (`id_competence`),
  ADD KEY `fk_parent_competence` (`parent_id`);

--
-- Index pour la table `images_projet`
--
ALTER TABLE `images_projet`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `id_projet` (`id_projet`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id_projet`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `id_competence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `images_projet`
--
ALTER TABLE `images_projet`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id_projet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `competences`
--
ALTER TABLE `competences`
  ADD CONSTRAINT `fk_parent_competence` FOREIGN KEY (`parent_id`) REFERENCES `competences` (`id_competence`) ON DELETE SET NULL;

--
-- Contraintes pour la table `images_projet`
--
ALTER TABLE `images_projet`
  ADD CONSTRAINT `images_projet_ibfk_1` FOREIGN KEY (`id_projet`) REFERENCES `projets` (`id_projet`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
