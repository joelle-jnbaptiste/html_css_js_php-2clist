-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 31 oct. 2018 à 12:16
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `toseelist`
--

-- --------------------------------------------------------

--
-- Structure de la table `acteur`
--

DROP TABLE IF EXISTS `acteur`;
CREATE TABLE IF NOT EXISTS `acteur` (
  `idacteur` int(11) NOT NULL AUTO_INCREMENT,
  `prenomacteur` text NOT NULL,
  `nomacteur` text NOT NULL,
  PRIMARY KEY (`idacteur`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `acteur`
--

INSERT INTO `acteur` (`idacteur`, `prenomacteur`, `nomacteur`) VALUES
(1, 'Uma', 'Thurman'),
(2, 'Bruce', 'Willis'),
(3, 'John', 'Travolta'),
(4, 'Samuel L.', 'Jackson'),
(5, 'David', 'Carradine'),
(6, 'Daryl', 'Hannah'),
(7, 'Lucy', 'Liu'),
(9, 'Justin', 'Long'),
(10, 'Thymothy', 'Olyphant'),
(11, 'Leonardo', 'DiCaprio'),
(12, 'Jean', 'Dujardin'),
(13, 'Jonah', 'Hill'),
(14, 'Margo', 'Robbie'),
(15, 'Clovis', 'Cornillac'),
(16, 'Bruno', 'Salomone'),
(17, 'Elodie', 'Bouchez'),
(18, 'Kate', 'Winslet'),
(19, 'Ellen', 'Page'),
(20, 'Ken', 'Watanabe'),
(21, 'Marion', 'Cotillard'),
(22, 'Daniel', 'Radcliffe'),
(23, 'Rupert', 'Grint'),
(24, 'Emma', 'Watson'),
(25, 'Robbie', 'Coltrane'),
(26, 'Mia', 'Wasikowska'),
(27, 'Johnny', 'Depp'),
(28, 'Helena', 'Boham Carter'),
(29, 'Anne', 'Hathaway'),
(30, 'Orlando', 'Bloom'),
(31, 'Keira', 'Knightley'),
(32, 'Geoffrey', 'Rush'),
(33, 'Kristen', 'Bell'),
(34, 'Idina', 'Menzel'),
(35, 'Jonathan', 'Groff'),
(36, 'Josh', 'Gad'),
(37, 'Ginnifer', 'Goodwin'),
(38, 'Jason', 'Bateman'),
(39, 'Idris', 'Elba'),
(40, 'J. K.', 'Simmons'),
(41, 'Tom', 'Hardy'),
(42, 'Michelle', 'Williams'),
(43, 'Riz', 'Ahmed'),
(44, 'Bérénice', 'Bejo'),
(45, 'Suzanne', 'Clément'),
(46, 'Stéphane', 'De Groodt'),
(47, 'Julien', 'Doré'),
(48, 'Amel', 'Bent'),
(49, 'Oxmo', 'Puccino'),
(50, 'Kev', 'Adams'),
(51, 'Jamel', 'Debbouze'),
(52, 'Vanessa', 'Guide');

-- --------------------------------------------------------

--
-- Structure de la table `acteurfilm`
--

DROP TABLE IF EXISTS `acteurfilm`;
CREATE TABLE IF NOT EXISTS `acteurfilm` (
  `idacteurfilm` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) NOT NULL,
  `idacteur` int(11) NOT NULL,
  PRIMARY KEY (`idacteurfilm`),
  KEY `ACTEURFILM_fk0` (`idfilm`),
  KEY `ACTEURFILM_fk1` (`idacteur`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `acteurfilm`
--

INSERT INTO `acteurfilm` (`idacteurfilm`, `idfilm`, `idacteur`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 1, 1),
(4, 1, 2),
(5, 5, 5),
(6, 5, 6),
(7, 5, 1),
(8, 6, 2),
(9, 6, 9),
(10, 6, 10),
(11, 7, 11),
(12, 7, 12),
(13, 7, 13),
(14, 8, 12),
(15, 8, 15),
(16, 7, 14),
(17, 8, 16),
(18, 8, 17),
(19, 9, 11),
(20, 9, 18),
(21, 10, 11),
(22, 10, 19),
(23, 10, 20),
(24, 10, 21),
(25, 11, 22),
(26, 11, 23),
(27, 11, 24),
(28, 11, 25),
(29, 12, 26),
(30, 12, 27),
(31, 12, 28),
(32, 12, 29),
(33, 13, 27),
(34, 13, 30),
(35, 13, 31),
(36, 13, 32),
(37, 14, 33),
(38, 14, 34),
(39, 14, 35),
(40, 14, 36),
(41, 15, 37),
(42, 15, 38),
(43, 15, 39),
(44, 15, 40),
(45, 16, 41),
(46, 16, 42),
(47, 16, 43),
(48, 17, 44),
(49, 17, 45),
(50, 17, 46),
(51, 18, 47),
(52, 18, 48),
(53, 18, 49),
(54, 19, 50),
(55, 19, 51),
(56, 19, 52);

-- --------------------------------------------------------

--
-- Structure de la table `avoir`
--

DROP TABLE IF EXISTS `avoir`;
CREATE TABLE IF NOT EXISTS `avoir` (
  `idavoir` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idavoir`),
  KEY `AVOIR_fk0` (`idfilm`),
  KEY `AVOIR_fk1` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `idfavoris` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idfavoris`),
  KEY `FAVORIS_fk0` (`idfilm`),
  KEY `FAVORIS_fk1` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `idfilm` int(11) NOT NULL AUTO_INCREMENT,
  `titre` text NOT NULL,
  `resume` text NOT NULL,
  `affiche` varchar(255) NOT NULL,
  `isenfant` tinyint(1) NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`idfilm`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`idfilm`, `titre`, `resume`, `affiche`, `isenfant`, `date`) VALUES
(1, 'Pulp Fiction', 'Dans un café restaurant de Los Angeles, dans la matinée, un couple de jeunes braqueurs, Pumpkin (appelé Ringo par Jules) et Yolanda (Tim Roth et Amanda Plummer), discutent des risques que comporte leur activité. Ils se décident finalement à attaquer le lieu, afin de pouvoir dévaliser à la fois l\'établissement et les clients.', 'pulpfiction.png', 0, '1994-10-01'),
(5, 'Kill Bill Volume 1', '\r\nDans la petite chapelle de Two Pines perdue au milieu du désert, à El Paso (Texas), alors que se déroule la répétition d\'une cérémonie de mariage, des assassins surgissent et tirent impitoyablement et sans raison apparente sur toutes les personnes présentes. La Mariée, qui est enceinte, survit à ses blessures mais sombre dans le coma. Toutefois, la Mariée n\'est pas une personne ordinaire. Autrefois tueuse à gages dans une organisation secrète, Détachement International des Vipères Assassines, elle est une combattante hors pair. Sortant du coma quatre années plus tard, elle n\'a plus qu\'un seul but, se venger de ses anciens complices, dans lesquels elle a reconnu les assassins de Two Pines, et surtout, tuer Bill, leur chef, qui est également le père de l\'enfant qu\'elle portait et qu\'elle croit avoir perdu à la suite de l\'attaque dans la chapelle.', 'killbill.png', 0, '2003-10-01'),
(6, 'Die Hard 4', 'Des hackers s\'attaquent aux différentes infrastructures des États-Unis dans le but d\'entamer une liquidation des biens américains. L\'attaque débute par la coupure des communications et le piratage du système informatique du FBI. Les cybercriminels s\'en prennent ensuite aux marchés boursiers, et pour finir, ils sabotent les installations électriques et de gaz.\r\n\r\nMais ces attaques terroristes ne sont en réalité qu\'un leurre destiné à masquer les véritables intentions des hackers (ce qui n\'est pas sans rappeler l\'intrigue du précédent volet de la saga). Malheureusement pour eux, leur plan savamment orchestré sera chamboulé par l\'intervention impromptue du lieutenant de police John McClane, escorté cette fois de Matt Farrell, le jeune hacker (et cryptographe) qu\'il a été chargé d\'arrêter…', 'diehard4.png', 0, '2007-06-01'),
(7, 'Le loup de Wall Street', 'Dans les années 1980, Jordan Belfort commence à travailler en tant que courtier en bourse, dans une entreprise nommée L.F. Rothschild, à Wall Street. Il rencontre Mark Hanna qui le prend sous son aile, ce dernier lui donne sa vision du métier. Le 19 octobre 1987, alors que Jordan vient d\'obtenir sa licence de courtier, l\'entreprise fait faillite à la suite du krach boursier, et Jordan est licencié. Ce jour sera appelé Le Lundi Noir. La femme de Jordan, Teresa, lui montre l\'annonce d\'une petite compagnie de courtage à Long Island, où un courtier est recherché. En arrivant, Jordan se rend compte que l\'entreprise ne vend que des actions à trois sous, qui n\'ont absolument aucune valeur. Il utilise alors dans cette entreprise tout le savoir qu\'il a acquis à Wall Street et commence à bien gagner sa vie.', 'leloupdewallstreet.png', 0, '2013-12-01'),
(8, 'Brice de Nice', 'Brice Agostini mène la belle vie à Nice. Il est fan du film Point Break et en particulier de son personnage principal Bodhi joué par Patrick Swayze. Il attend chaque jour qu\'une vague géante déferle sur les rives de Nice, comme cela a eu lieu une fois, en 1979.\r\n\r\nAinsi, il ne se déplace jamais sans sa planche de surf. En attendant, aucune vague à Nice ne permet de surfer. Son passe-temps est d\'organiser des soirées festives assez \"select\", appelées \"Yellow\" où il participe à des joutes verbales dont le perdant (toujours l\'autre) est jeté dans la piscine.', 'bricedenice.png', 1, '2005-04-01'),
(9, 'Titanic', 'En septembre 1996, Brock Lovett est le coordinateur d\'une équipe qui fouille méticuleusement l\'épave du Titanic, paquebot géant réputé insubmersible qui connut pourtant un destin tragique. Lors d\'une plongée en sous-marin miniature, il espère mettre enfin la main sur le Cœur de l\'Océan, un bijou unique à la valeur inestimable, porté par Louis XVI, dont la découverte lui apporterait la gloire (ce bijou est inspiré du diamant bleu de la Couronne). Mais il remonte des profondeurs un coffre-fort qui se révèle ne contenir qu\'un dessin représentant une jeune fille nue portant le bijou en pendentif.\r\n\r\nÀ des milliers de kilomètres de là, une vieille dame, Rose Calvert, découvre ce dessin sur l\'écran de son téléviseur. Elle contacte Lovett et lui affirme qu\'elle est la jeune fille en question. Étant l\'une des rares personnes à avoir survécu au naufrage du Titanic encore en vie, elle est amenée sur le bateau de l\'équipe de Lovett et leur raconte la croisière inaugurale du paquebot, son naufrage, ainsi que l\'histoire d\'amour qu\'elle a vécue avec Jack Dawson, un artiste voyageant en troisième classe.', 'titanic.png', 0, '1998-01-01'),
(10, 'Inception', 'Dans un futur proche, les États-Unis ont développé ce qui est appelé le « rêve partagé », une méthode permettant d\'influencer l\'inconscient d\'une victime pendant qu\'elle rêve, donc à partir de son subconscient. Des « extracteurs » s\'immiscent alors dans ce rêve, qu\'ils ont préalablement modelé et qu\'ils peuvent contrôler, afin d\'y voler des informations sensibles stockées dans le subconscient de la cible. C\'est dans cette nouvelle technique que se sont lancés Dominic Cobb et sa femme, Mal. Ensemble, ils ont exploré les possibilités de cette technique et l\'ont améliorée, leur permettant d\'emboîter les rêves les uns dans les autres, accentuant la confusion et donc diminuant la méfiance de la victime. Mais l\'implication du couple dans ce projet a été telle que Mal a un jour perdu le sens de la réalité ; pensant être en train de rêver, elle s\'est suicidée, croyant ainsi revenir à sa vision de la réalité. Soupçonné de son meurtre, Cobb est contraint de fuir les États-Unis et d\'abandonner leurs enfants à ses beaux-parents. Il se spécialise dans l\'« extraction », en particulier dans le domaine de l\'espionnage industriel ; mercenaire et voleur, il est embauché par des multinationales pour obtenir des informations de leurs concurrents commerciaux.', 'inception.png', 0, '2010-07-01'),
(11, 'Harry Potter à l\'école des sorciers', 'Après la mort tragique de Lily et James Potter, leur fils Harry est recueilli par sa tante Pétunia, la sœur de Lily et son oncle Vernon. Son oncle et sa tante, possédant une haine féroce envers les parents de Harry, le maltraitent et laissent leur fils Dudley l\'humilier. Harry ne sait rien sur ses parents. On lui a toujours dit qu’ils étaient morts dans un accident de voiture.\r\n\r\nUn jour de juillet, peu avant son onzième anniversaire, Harry reçoit une lettre de Poudlard, l\'école de magie et de sorcellerie, l\'invitant à s\'y présenter pour la rentrée des classes, mais son oncle la lui confisque avant qu\'il ne puisse la lire, ne voulant pas que Harry devienne sorcier.', 'harrypotter1.png', 1, '2001-12-01'),
(12, 'Alice au pays des merveilles', 'Lors d\'une réception, Alice Kingsleigh (Mia Wasikowska), qui a désormais 19 ans, est demandée en mariage par Hamish Ascot, un lord arrogant et très peu séduisant. C\'est alors qu\'elle aperçoit un étrange lapin blanc qui possède une montre à gousset et lui fait signe de la suivre. Alice s\'enfuit, prétendant que « cette demande en mariage arrive un peu trop rapidement » et part à la poursuite du lapin. Elle arrive devant un curieux arbre mort au tronc détruit. Entre ses racines se trouve un terrier plongé dans l\'obscurité. S\'en approchant trop près, Alice tombe et atterrit, après une longue chute mouvementée, au Pays des Merveilles.', 'aliceaupaysdesmerveilles.png', 1, '2010-03-01'),
(13, 'Pirates des caraibes 1', 'La fille du gouverneur Swann, Elizabeth, promise au commodore James Norrington, est éprise d\'un forgeron nommé William Turner qu\'elle a sauvé des eaux étant enfant et qui ignore sa filiation de pirate. Lorsque les pirates d\'Hector Barbossa attaquent Port Royal pour retrouver le dernier médaillon aztèque manquant du trésor maudit, Elizabeth est embarquée à bord du Black Pearl. William Turner part à sa recherche avec un autre pirate : le capitaine Jack Sparrow. L\'équipage du Black Pearl est hanté par la malédiction de l\'or aztèque, qui change toutes les âmes au cœur impur (celles qui seraient donc amenées à toucher ce trésor maudit) en squelettes, immortels et méprisés. Ceux-ci n\'ont alors plus aucune sensation corporelle ou gustative, c\'est pourquoi ils cherchent à inverser la malédiction. Au cours de cette quête pour retrouver le dernier médaillon, le capitaine Barbossa est prêt à tout pour empêcher le capitaine Jack Sparrow de récupérer le Black Pearl, qu\'il a perdu à la suite d\'une mutinerie.', 'piratesdescaraibes1.png', 1, '2003-08-01'),
(14, 'La reine des neiges', 'Elsa et Anna sont deux sœurs, princesses du royaume d\'Arendelle, qui ont respectivement huit et cinq ans1. Elles sont les filles du roi et de la reine d’Arendelle. Elsa, la grande sœur, possède le pouvoir de faire de la neige et de la glace d’un geste de la main ou du pied. Ensemble, elles s’amusent de cette magie dans la salle du trône faisant des bonhommes de neige et des glissades. Mais un jour Elsa blesse sa sœur Anna en lui jetant accidentellement une boule de neige à la tête. Après cet incident, Anna aura une mèche blanche dans les cheveux.\r\n\r\nLes parents emportent leurs deux filles, Anna et Elsa, chez les trolls. Là, le sage des trolls guérit Anna et lui enlève par précaution tous les souvenirs de la magie pour qu’elle ne demande plus à Elsa de faire des tours. Il prévient Elsa que ses pouvoirs ne feront que croître et qu’elle doit apprendre à les contrôler. La peur sera sa pire ennemie.', 'lareinedesneiges.png', 1, '2013-11-01'),
(15, 'Zootopie', 'Zootopie est une ville cosmopolite où ne vivent que des mammifères et où chaque espèce cohabite avec les autres ; qu’on soit un prédateur ou une proie, tout le monde est accepté à Zootopie. Judy Hopps est une lapine de 9 ans qui vit à la campagne avec ses parents. Alors que tous les membres de sa famille sont cultivateurs, Judy annonce pendant son spectacle d\'école qu\'elle veut vivre à Zootopie la grande métropole et devenir officier de police, ce qui affole ses parents qui estiment ce métier trop dangereux pour un lapin. En sortant du spectacle, Judy intervient en voyant Gideon Grey, un renard voyou, en train de racketter ses camarades. Gideon réagit violemment, griffant Judy à la joue, et se moque de son rêve de devenir lapin flic avant de s\'en aller. Judy en sort traumatisée, mais encore plus déterminée à combattre le crime.', 'zootopie.png', 1, '2016-02-01'),
(16, 'Venom', 'Lors d\'une expédition d\'exploration, un vaisseau spatial de la Life Foundation (en) retourne sur Terre avec à son bord quatre échantillons de symbiotes extraterrestres. Mais durant l\'entrée dans l\'atmosphère terrestre, le vaisseau connaît une avarie et s\'écrase dans l\'est de la Malaisie. Depuis son immense complexe à San Francisco, le savant Carlton Drake, puissant et mystérieux PDG de la fondation, gère les opérations. Il parvient à faire rapatrier trois des quatre échantillons. Le quatrième s\'est enfui en prenant possession d\'un corps.', 'venom.png', 0, '2018-10-01'),
(17, 'Le jeu', 'Le temps d’un diner, des couples d’amis décident de jouer à un « jeu » : chacun doit poser son téléphone portable au milieu de la table et chaque SMS, appel téléphonique, mail, message Facebook, etc. devra être partagé avec les autres. Il ne faudra pas attendre bien longtemps pour que ce « jeu » se transforme en cauchemar.', 'lejeu.png', 0, '2018-10-01'),
(18, 'Yeti & Compagnie', 'Vivant dans un petit village reculé, un jeune et intrépide yéti découvre une créature étrange qui, pensait-il jusque-là, n\'existait que dans les contes : un humain ! Si c\'est pour lui l\'occasion de connaître la célébrité – et de conquérir la fille de ses rêves –, cette nouvelle sème le trouble dans la communauté yéti. Car qui sait les surprises que leur réserve encore le vaste monde ?', 'yeti&compagnie.png', 1, '2018-10-01'),
(19, 'Alad\'2', 'Après avoir libéré Bagdad de l’emprise de son terrible Vizir, Aladin s’ennuie au palais et ne s’est toujours pas décidé à demander en mariage la princesse. Mais un terrible dictateur, Shah Zaman, s’invite au Palais et annonce qu’il est venu prendre la ville et épouser la Princesse. Aladin n’a pas d’autre choix que de s’enfuir du Palais… Il va tenter de récupérer son ancien Génie et revenir en force pour libérer la ville et récupérer sa promise.', 'alad2.png', 1, '2018-10-01');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `idgenre` int(11) NOT NULL AUTO_INCREMENT,
  `nomgenre` text NOT NULL,
  PRIMARY KEY (`idgenre`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`idgenre`, `nomgenre`) VALUES
(1, 'Gangster'),
(2, 'Comédie'),
(5, 'Action'),
(6, 'Biopic'),
(7, 'Drame'),
(8, 'Romance'),
(9, 'Science Fiction'),
(10, 'Fantastique'),
(11, 'Animation'),
(12, 'Aventure');

-- --------------------------------------------------------

--
-- Structure de la table `genrefilm`
--

DROP TABLE IF EXISTS `genrefilm`;
CREATE TABLE IF NOT EXISTS `genrefilm` (
  `idgenrefilm` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) NOT NULL,
  `idgenre` int(11) NOT NULL,
  PRIMARY KEY (`idgenrefilm`),
  KEY `GENREFILM_fk0` (`idfilm`),
  KEY `GENREFILM_fk1` (`idgenre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genrefilm`
--

INSERT INTO `genrefilm` (`idgenrefilm`, `idfilm`, `idgenre`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 5, 5),
(4, 6, 5),
(5, 7, 6),
(6, 7, 7),
(7, 8, 2),
(8, 9, 7),
(9, 9, 8),
(10, 10, 9),
(11, 11, 10),
(12, 12, 11),
(13, 12, 10),
(14, 13, 12),
(15, 13, 10),
(16, 14, 11),
(17, 14, 10),
(18, 11, 2),
(19, 16, 5),
(20, 16, 9),
(21, 17, 7),
(22, 17, 2),
(23, 18, 11),
(24, 18, 12),
(25, 19, 2);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `idnote` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idnote`),
  KEY `NOTE_fk0` (`idfilm`),
  KEY `NOTE_fk1` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `realfilm`
--

DROP TABLE IF EXISTS `realfilm`;
CREATE TABLE IF NOT EXISTS `realfilm` (
  `idrealfilm` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) NOT NULL,
  `idreal` int(11) NOT NULL,
  PRIMARY KEY (`idrealfilm`),
  KEY `REALFILM_fk0` (`idfilm`),
  KEY `REALFILM_fk1` (`idreal`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `realfilm`
--

INSERT INTO `realfilm` (`idrealfilm`, `idfilm`, `idreal`) VALUES
(1, 1, 1),
(2, 5, 1),
(3, 6, 3),
(4, 7, 4),
(5, 8, 5),
(6, 9, 6),
(7, 10, 7),
(8, 11, 8),
(9, 12, 9),
(10, 12, 10),
(11, 13, 11),
(12, 14, 11),
(13, 15, 12),
(14, 16, 13),
(15, 16, 14),
(16, 17, 15),
(17, 18, 15),
(18, 19, 16),
(19, 7, 17),
(20, 8, 18),
(21, 11, 19),
(22, 12, 20),
(23, 13, 21),
(24, 14, 22),
(25, 15, 23),
(26, 18, 24);

-- --------------------------------------------------------

--
-- Structure de la table `realisateur`
--

DROP TABLE IF EXISTS `realisateur`;
CREATE TABLE IF NOT EXISTS `realisateur` (
  `idreal` int(11) NOT NULL AUTO_INCREMENT,
  `prenomreal` text NOT NULL,
  `nomreal` text NOT NULL,
  PRIMARY KEY (`idreal`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `realisateur`
--

INSERT INTO `realisateur` (`idreal`, `prenomreal`, `nomreal`) VALUES
(1, 'Quentin', 'Tarantino'),
(3, 'Len', 'Wiseman'),
(4, 'Martin', 'Scorsese'),
(5, 'James', 'Huth'),
(6, 'James', 'Cameron'),
(7, 'Christopher', 'Nolan'),
(8, 'Chris', 'Colombus'),
(9, 'Tim', 'Burton'),
(10, 'Gore', 'Verbinski'),
(11, 'Chris', 'Buck'),
(12, 'Byron', 'Howard'),
(13, 'Ruben', 'Fleischer'),
(14, 'Fred', 'Cavayé'),
(15, 'Karey', 'Kirkpatrick'),
(16, 'Lionel', 'Steketee'),
(17, 'Terence', 'Winter'),
(18, 'Jean', 'Dujardin'),
(19, 'Steven', 'Kloves'),
(20, 'Linda', 'Woolverton'),
(21, 'Ted', 'Elliot'),
(22, 'Jennifer', 'Lee'),
(23, 'Rich', 'Moore'),
(24, 'Jason A.', 'Reisig');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `nomuser` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`iduser`, `nomuser`, `password`) VALUES
(1, 'ZDAZDAZFEBF', 'DADZDAZDA'),
(2, 'sileinart@gmail.com', 'AZEAZFAZFZFAZFAZF'),
(4, 'misssileina@gmail.com', 'fezfefzef'),
(9, 'zadzdazdaz', 'dzaddazda'),
(10, 'miaou', 'ouhfoauv'),
(11, 'miaoux', 'mmmmmmmm'),
(12, 'miaous', 'window.location.replace(...)'),
(13, 'miaoug', 'tttttttt'),
(14, 'miaoul', 'uuuuuuuu'),
(15, 'miaoup', 'eeeeeeee'),
(16, 'miou', 'llllllll'),
(18, 'grahou', 'grahougrahou');

-- --------------------------------------------------------

--
-- Structure de la table `vue`
--

DROP TABLE IF EXISTS `vue`;
CREATE TABLE IF NOT EXISTS `vue` (
  `idvue` int(11) NOT NULL AUTO_INCREMENT,
  `idfilm` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idvue`),
  KEY `VUE_fk0` (`idfilm`),
  KEY `VUE_fk1` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `acteurfilm`
--
ALTER TABLE `acteurfilm`
  ADD CONSTRAINT `ACTEURFILM_fk0` FOREIGN KEY (`idfilm`) REFERENCES `film` (`idfilm`),
  ADD CONSTRAINT `ACTEURFILM_fk1` FOREIGN KEY (`idacteur`) REFERENCES `acteur` (`idacteur`);

--
-- Contraintes pour la table `avoir`
--
ALTER TABLE `avoir`
  ADD CONSTRAINT `AVOIR_fk0` FOREIGN KEY (`idfilm`) REFERENCES `film` (`idfilm`),
  ADD CONSTRAINT `AVOIR_fk1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `FAVORIS_fk0` FOREIGN KEY (`idfilm`) REFERENCES `film` (`idfilm`),
  ADD CONSTRAINT `FAVORIS_fk1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Contraintes pour la table `genrefilm`
--
ALTER TABLE `genrefilm`
  ADD CONSTRAINT `GENREFILM_fk0` FOREIGN KEY (`idfilm`) REFERENCES `film` (`idfilm`),
  ADD CONSTRAINT `GENREFILM_fk1` FOREIGN KEY (`idgenre`) REFERENCES `genre` (`idgenre`);

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `NOTE_fk0` FOREIGN KEY (`idfilm`) REFERENCES `film` (`idfilm`),
  ADD CONSTRAINT `NOTE_fk1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Contraintes pour la table `realfilm`
--
ALTER TABLE `realfilm`
  ADD CONSTRAINT `REALFILM_fk0` FOREIGN KEY (`idfilm`) REFERENCES `film` (`idfilm`),
  ADD CONSTRAINT `REALFILM_fk1` FOREIGN KEY (`idreal`) REFERENCES `realisateur` (`idreal`);

--
-- Contraintes pour la table `vue`
--
ALTER TABLE `vue`
  ADD CONSTRAINT `VUE_fk0` FOREIGN KEY (`idfilm`) REFERENCES `film` (`idfilm`),
  ADD CONSTRAINT `VUE_fk1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
