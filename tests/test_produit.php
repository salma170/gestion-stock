<?php
// Garde la ligne require_once (ou l'autoload) que tu as déjà corrigée en haut du fichier.

// ----- Constructeur -----
$p = new Produit('P001', 'Clavier', 150, 10);
verifier($p->getReference() === 'P001', 'La référence est P001');
verifier($p->getNom() === 'Clavier', 'Le nom est Clavier');
verifier(abs($p->getPrix() - 150) < 0.001, 'Le prix est 150');
verifier($p->getQuantite() === 10, 'La quantité initiale est 10');

$p2 = new Produit('P002', 'Souris', 50);
verifier($p2->getQuantite() === 0, 'La quantité par défaut est 0');

$p3 = new Produit('P003', 'Cable', 0);
verifier(abs($p3->getPrix()) < 0.001, 'Un prix de 0 est accepté');

try {
    new Produit('P004', 'Ecran', -10, 5);
    verifier(false, 'Prix négatif refusé');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Prix négatif refusé');
}

try {
    new Produit('P005', 'Cable', 10, -1);
    verifier(false, 'Quantité négative refusée');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Quantité négative refusée');
}

// ----- ajouterQuantite -----
$p = new Produit('P001', 'Clavier', 150, 10);
$p->ajouterQuantite(5);
verifier($p->getQuantite() === 15, 'Après ajout de 5, il y en a 15');

try {
    $p->ajouterQuantite(0);
    verifier(false, 'Ajout de 0 refusé');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Ajout de 0 refusé');
}

try {
    $p->ajouterQuantite(-3);
    verifier(false, 'Ajout négatif refusé');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Ajout négatif refusé');
}

// ----- retirerQuantite -----
$p = new Produit('P001', 'Clavier', 150, 10);
$p->retirerQuantite(3);
verifier($p->getQuantite() === 7, 'Après retrait de 3, il en reste 7');

$p->retirerQuantite(7);
verifier($p->getQuantite() === 0, 'On peut retirer tout le stock');

$p = new Produit('P001', 'Clavier', 150, 10);
try {
    $p->retirerQuantite(11);
    verifier(false, 'Retrait supérieur au stock refusé');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Retrait supérieur au stock refusé');
}
verifier($p->getQuantite() === 10, 'Le stock reste à 10 après un retrait refusé');

try {
    $p->retirerQuantite(-2);
    verifier(false, 'Retrait négatif refusé');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Retrait négatif refusé');
}

// ----- valeurStock -----
$p = new Produit('P001', 'Clavier', 150, 10);
verifier(abs($p->valeurStock() - 1500) < 0.001, 'La valeur du stock vaut 10 x 150');

$p->ajouterQuantite(5);
$p->retirerQuantite(3);
verifier(abs($p->valeurStock() - 1800) < 0.001, 'Après modifications, la valeur vaut 12 x 150');

$vide = new Produit('P002', 'Souris', 50);
verifier(abs($vide->valeurStock()) < 0.001, 'Un stock vide vaut 0');