<?php
require __DIR__ . '/autoload.php';

function lire(string $invite): string
{
    echo $invite;
    $ligne = fgets(STDIN);
    return $ligne === false ? '' : trim($ligne);
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

function afficherProduits(array $produits): void
{
    if (empty($produits)) {
        echo "(aucun produit)\n";
        return;
    }
    foreach ($produits as $p) {
        printf("%-8s %-20s %10.2f x %4d = %10.2f\n",
            $p->getReference(), $p->getNom(), $p->getPrix(),
            $p->getQuantite(), $p->valeurStock());
    }
}

$stock = new Stock();
$numeroCommande = 1;

do {
    afficherMenu();
    $choix = lire("Votre choix : ");

    try {
        switch ($choix) {
            case '1':
                $ref = lire("Référence : ");
                $nom = lire("Nom : ");
                $prix = (float) lire("Prix : ");
                $qte = (int) lire("Quantité : ");
                $stock->ajouter(new Produit($ref, $nom, $prix, $qte));
                echo "Produit ajouté.\n";
                break;

            case '2':
                afficherProduits($stock->tous());
                printf("Produits : %d | Valeur totale : %.2f\n",
                    $stock->compter(), $stock->valeurTotale());
                break;

            case '3':
                $p = $stock->trouver(lire("Référence : "));
                if ($p === null) {
                    echo "Produit introuvable.\n";
                    break;
                }
                $p->ajouterQuantite((int) lire("Quantité à ajouter : "));
                echo "Nouveau stock : " . $p->getQuantite() . "\n";
                break;

            case '4':
                $commande = new Commande($numeroCommande);
                do {
                    $p = $stock->trouver(lire("Référence (vide pour terminer) : "));
                    if ($p === null) {
                        break;
                    }
                    try {
                        $commande->ajouterLigne($p, (int) lire("Quantité : "));
                        echo "Ligne ajoutée.\n";
                    } catch (InvalidArgumentException $e) {
                        echo "Erreur : " . $e->getMessage() . "\n";
                    }
                } while (true);

                $commande->valider();
                echo $commande->afficher();
                $numeroCommande++;
                break;

            case '5':
                echo "--- En rupture ---\n";
                afficherProduits($stock->produitsEnRupture());
                $seuil = (int) lire("Seuil : ");
                echo "--- Sous le seuil de $seuil ---\n";
                afficherProduits($stock->produitsSousSeuil($seuil));
                break;

            case '0':
                echo "Au revoir.\n";
                break;

            default:
                echo "Choix invalide.\n";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage() . "\n";
    }
} while ($choix !== '0');