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
    and codeDuree = 'H1' ---2 ca marche aussi quand les chiffres sont 
UPDATE
    tarifs
set
    prixLocation = '418'
where
    categoProd = 'CO'
    and codeDuree = 'h1' ---DELETE
delete from
    tarifs
where
    categoProd = 'BB'
    and codeDuree = 'H1'
delete from
    tarifs
where
    codeDuree = 'h1'
    and categoProd = 'BB';

--- reparer
INSERT INTO
    tarifs (codeDuree, categoProd, prixLocation)
VALUES
    ('H1', 'PS', '10.00');

---TROUVER LES VALEURS MANQUANTES
---Toutes les possibilités
SELECT
    concat(codeDuree, categoprod) as con
from
    duree
    inner join catProd ---seulement les possibilités qui sont absentesz dans "tarifs"
SELECT
    concat(codeDuree, categoprod) as tarifManquant
from
    duree
    inner join catProd
where
    concat(codeDuree, categoprod) not in (
        SELECT
            concat(tarifs.codeDuree, tarifs.categoprod) as con
        from
            tarifs
    ) ---deux champs séparés ça va être plus facile a traiter
SELECT
    codeDuree,
    categoProd
from
    duree
    inner join catProd
where
    concat(codeDuree, categoprod) not in (
        SELECT
            concat(tarifs.codeDuree, tarifs.categoprod) as con
        from
            tarifs
    )