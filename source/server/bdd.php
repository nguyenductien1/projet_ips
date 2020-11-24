<?php

// connexion à la base de données SQL
function connexion() {
    $pdo = new PDO('sqlite:annonces.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// création une table au bon format, pour contenir les annonces
function creationTable() {
    $pdo = connexion();
    $requeteSQLCreation = 'CREATE TABLE "annonces" (
        "id" INTEGER PRIMARY KEY AUTOINCREMENT,
        "titre" TEXT,
        "description" TEXT,
        "categorie" TEXT,
        "pseudo" TEXT,
        "prix" INTEGER,
        "photo" TEXT,
        "rdv_lat" REAL,
        "rdv_lon" REAL,
        "date" INTEGER DEFAULT CURRENT_TIMESTAMP
    );';
    // exécution de la requête
    $pdo->query($requeteSQLCreation);
}

// insertions de 4 petites annonces d'exemple
function insertionDonneesExemple() {
    $pdo = connexion();
    $requeteSQLInsertion = "INSERT INTO annonces (titre, description, categorie, pseudo, prix, photo, rdv_lat, rdv_lon) VALUES
        ('Lot de 2 loutres en carton', 'Vends lot de deux loutres en carton, à construire soi-même.\nÉtat neuf.', 'decoration', 'Jean Talus', 17, 'https://p8.storage.canalblog.com/87/98/377716/28283932_p.jpg', 43.6175644, 3.8618377),
        ('gamos de daron tavu', 'paiement en liquide seulement', 'automobile', 'Louise Duschmoll', 39000, 'https://lautomobileancienne.com/wp-content/uploads/2020/03/Citroen-BX-GTI-4x4-2.jpg', 44.1256347, 4.0832189),
        ('Écrou de qualité supérieure', 'Vends écrou en inox de grande qualité, filetage ultrafin, couleur enchanteresse.\nPrix symbolique: 1€, pour cause de déménagement.\nPassionés uniquement, sur rendez-vous.', 'decoration', 'Camille Honnête', 1, 'https://www.pieces-de-motoculture.fr/images/Image/ecrou.jpg', 43.6697239, 3.8577369),
        ('Courgettes', 'À saisir (à la poêle !) 2 kg de courgettes craquantes et fondantes à la fois.\nProduction locale sans pesticides', 'cuisine', 'Amel Sosbesh', 5, 'https://www.biendecheznous.be/sites/default/files/ps_image/istock_courgettes.jpg', 46.8206397, 29.6003248)
    ";
    $stmt = $pdo->prepare($requeteSQLInsertion);
    // $stmt->debugDumpParams();
    return $stmt->execute();
}

// vidage dela table : suppression de toutes les annonces
function vidageTable() {
    $pdo = connexion();
    $requeteSQLVidage = "DELETE FROM annonces";
    $pdo->query($requeteSQLVidage);
}