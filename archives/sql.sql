DROP DATABASE IF EXISTS surfwave;

CREATE DATABASE surfwave;

use surfwave;

-- 
-- tout dabord Focus sur la table EQUIPIER
--
--
CREATE TABLE UTILISATEURS (
    id_utilisateur INT(8) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    mdp VARCHAR(50) NOT NULL,
    droit tinyint NOT NULL DEFAULT '0',
    PRIMARY KEY (id_utilisateur),
    UNIQUE mail (mail)
);

CREATE TABLE EQUIPIER (
    codeEq VARCHAR(5) NOT NULL,
    surnomEq VARCHAR(15) NOT NULL,
    nomEq VARCHAR(50),
    fonctionEq VARCHAR(15) NOT NULL,
    PRIMARY KEY (codeEq)
);

CREATE TABLE CATPROD (
    categoProd VARCHAR(6) NOT NULL,
    libcategoProd VARCHAR(40) NOT NULL,
    PRIMARY KEY (categoProd)
);

CREATE TABLE DUREE (
    codeDuree VARCHAR(4) NOT NULL,
    libDuree VARCHAR(20) NOT NULL,
    PRIMARY KEY (codeDuree)
);

CREATE TABLE TARIFS (
    codeDuree VARCHAR(4) NOT NULL,
    categoProd VARCHAR(6) NOT NULL,
    prixLocation DECIMAL(5, 2),
    CONSTRAINT TARIF_FK1 FOREIGN KEY(codeDuree) REFERENCES DUREE(codeDuree),
    CONSTRAINT TARIF_FK2 FOREIGN KEY(categoProd) REFERENCES CATPROD(categoProd),
    PRIMARY KEY (codeDuree, categoProd)
);

INSERT INTO
    UTILISATEURS (nom, mail, mdp, droit)
VALUES
    ('Admin', 'Admin@admin.fr', 'Admin', 1);

INSERT INTO
    EQUIPIER
VALUES
    (
        'BOSS',
        'Gourou',
        'MARCON Emmanuel',
        'Directeur'
    ),
    (
        'DAN',
        'Dantel',
        'CASTOR Jean',
        'Commercial'
    ),
    (
        'DID',
        'Didi',
        'LAMBROUY Didier',
        'Commercial'
    ),
    ('PAT', 'Patou', NULL, 'Moniteur'),
    ('FRED', 'Fredo', NULL, 'Moniteur'),
    ('WIL', 'Will', 'SOVÉ Willy', 'Moniteur'),
    (
        'KIM',
        'Kimi',
        'GAGA Géralde',
        'e-commerce'
    ),
    (
        'ADJ',
        'Isa',
        'FONFEC Sophie',
        'e-commerce'
    ),
    ('FAN', 'Fany', NULL, 'e-commerce');

--
-- Et voici le reste du script
--
CREATE TABLE QUESTION (
    idQuest INT NOT NULL,
    libQuest VARCHAR(100) NOT NULL,
    PRIMARY KEY (idQuest)
);

CREATE TABLE QDP (
    codeEq VARCHAR(5) NOT NULL,
    idQuest INT NOT NULL,
    reponse VARCHAR(500),
    PRIMARY KEY (codeEq, idQuest),
    FOREIGN KEY (codeEq) REFERENCES EQUIPIER(codeEq),
    FOREIGN KEY (idQuest) REFERENCES QUESTION(idQuest)
);

--
-- data pour finir
INSERT INTO
    QUESTION
VALUES
    (1, "Ma qualité préférée chez les autres."),
    (2, "Mon idée du bonheur. "),
    (3, "La couleur que je préfère."),
    (4, "Le plat que je préfère."),
    (5, "En quoi je voudrais être réincarné.e.");

INSERT INTO
    QDP
VALUES
    ("BOSS", 1, "Présider et décider"),
    ("BOSS", 2, "Etre roi de ce pays"),
    ("BOSS", 3, "Jaune sable"),
    ("BOSS", 4, "La dinde de la cour"),
    ("BOSS", 5, "Louis XIV");

INSERT INTO
    CATPROD
VALUES
    ('PS', 'Planche de surf'),
    ('BB', 'Bodyboard'),
    ('CO', 'Combinaison');

INSERT INTO
    DUREE
VALUES
    ('H1', '1 heure'),
    ('H2', '2 heures'),
    ('H3', '3 heures'),
    ('H4', '4 heures'),
    ('J1', '1 jour'),
    ('J2', '2 jours'),
    ('J3', '3 jours'),
    ('J4', '4 jours'),
    ('J5', '5 jours'),
    ('J6', '6 jours');

INSERT INTO
    TARIFS
VALUES
    ('H1', 'PS', '10.00'),
    ('H2', 'PS', '15.00'),
    ('H3', 'PS', '20.00'),
    ('H4', 'PS', '25.00'),
    ('J1', 'PS', '35.00'),
    ('J2', 'PS', '45.00'),
    ('J3', 'PS', '55.00'),
    ('J4', 'PS', '65.00'),
    ('J5', 'PS', '75.00'),
    ('J6', 'PS', '85.00'),
    ('H1', 'BB', '35.00'),
    ('H2', 'BB', '35.00'),
    ('H3', 'BB', '35.00'),
    ('H4', 'BB', '35.00'),
    ('J1', 'BB', '35.00'),
    ('J2', 'BB', '35.00'),
    ('J3', 'BB', '35.00'),
    ('J4', 'BB', '35.00'),
    ('J5', 'BB', '35.00'),
    ('J6', 'BB', '35.00'),
    ('H1', 'CO', '35.00'),
    ('H2', 'CO', '35.00'),
    ('H3', 'CO', '35.00'),
    ('H4', 'CO', '35.00'),
    ('J1', 'CO', '35.00'),
    ('J2', 'CO', '35.00'),
    ('J3', 'CO', '35.00'),
    ('J4', 'CO', '35.00'),
    ('J5', 'CO', '35.00'),
    ('J6', 'CO', '35.00');

--AFFICHAGE DES TARIFS
-- requete a prevoir select *, libDuree from tarifs inner join duree on duree.codeDuree=tarifs.codeDuree order by tarifs.codeDuree ASC, categoProd DESC; 
-- Nouvelle version 
select
    distinct tarifs.codeDuree,
    tarifs.*,
    libDuree
from
    tarifs
    inner join duree on tarifs.codeDuree = duree.codeDuree
order by
    tarifs.codeDuree asc,
    case
        when (tarifs.categoProd LIKE "PS") then 1
        when tarifs.categoProd LIKE "BB" then 2
        when tarifs.categoProd LIKE "CO" then 3
    end --Le distinct ne marche pas mieux ici 
    -- Nouvelle version deux tables
select
    prixLocation,
    libDuree
from
    tarifs
    inner join duree on tarifs.codeDuree = duree.codeDuree
order by
    tarifs.codeDuree asc,
    case
        when (tarifs.categoProd LIKE "PS") then 1
        when tarifs.categoProd LIKE "BB" then 2
        when tarifs.categoProd LIKE "CO" then 3
    end -- Nouvelle version trois tables
select
    prixLocation,
    libDuree,
    libcategoProd
from
    tarifs
    inner join duree on tarifs.codeDuree = duree.codeDuree
    inner join catProd on tarifs.categoProd = catProd.categoProd
order by
    tarifs.codeDuree asc,
    case
        when tarifs.categoProd LIKE "PS" then 1
        when tarifs.categoProd LIKE "BB" then 2
        when tarifs.categoProd LIKE "CO" then 3
    end ---Requêtes à la con pour vérifier que tout fonctionne bien 
UPDATE
    catprod
set
    libCategoProd = 'Combinaison'
where
    categoProd = 'CO';

---REQUETES DE MODIFS DE TARIFS
use surfwave;



update
    tarifs
set
    prixLocation = 98.00
where
    categoProd = 'PS'
    and codeDuree = 'H1'
    ---2 ca marche aussi quand les chiffres sont 
UPDATE
        tarifs
set
    prixLocation = '418'
where
    categoProd = 'CO'
    and codeDuree = 'h1' 
    ---DELETE
   delete from tarifs where categoProd = 'BB' and codeDuree = 'H1'
delete from tarifs where codeDuree='h1' and categoProd='BB';
--- reparer
INSERT INTO tarifs (codeDuree, categoProd, prixLocation) VALUES ('H1', 'PS', '10.00');