<?php
require __DIR__ . '/autoload.php';

function lire(string $invite): string
{
    echo $invite;
    return trim(fgets(STDIN));
}

function afficherMenu(): void
{
    echo "\n===== GESTION DE STOCK =====\n";
    echo "1. Ajouter un produit\n";
    echo "2. Lister le stock\n";
    echo "3. Réapprovisionner\n";
    echo "4. Nouvelle commande\n";
    echo "5. Produits en rupture ou sous seuil\n";
    echo "0. Quitter\n";
}

do {
    afficherMenu();
    $choix = lire("Votre choix : ");

    switch ($choix) {
        case '1':
            echo "[À faire] Ajouter un produit\n";
            break;
        case '2':
            echo "[À faire] Lister le stock\n";
            break;
        case '3':
            echo "[À faire] Réapprovisionner\n";
            break;
        case '4':
            echo "[À faire] Nouvelle commande\n";
            break;
        case '5':
            echo "[À faire] Produits en rupture ou sous seuil\n";
            break;
        case '0':
            echo "Au revoir.\n";
            break;
        default:
            echo "Choix invalide.\n";
    }
} while ($choix !== '0');