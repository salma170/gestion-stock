<?php
$stock = new Stock();
$stock->ajouter(new Produit('P001', 'Clavier', 150, 10));

verifier($stock->trouver('P001') !== null, 'Stock : trouver() retourne le produit ajouté');
verifier($stock->trouver('XXX') === null, 'Stock : trouver() retourne null si inconnu');

$doublon = false;
try {
    $stock->ajouter(new Produit('P001', 'Autre', 10, 1));
} catch (InvalidArgumentException $e) {
    $doublon = true;
}
verifier($doublon, 'Stock : référence en double refusée');
$stock->ajouter(new Produit('P002', 'Souris', 40, 0));
$stock->ajouter(new Produit('P003', 'Ecran', 800, 3));

verifier($stock->compter() === 3, 'Stock : compter() vaut 3');
verifier(count($stock->tous()) === 3, 'Stock : tous() retourne 3 produits');
// 150*10 + 40*0 + 800*3 = 3900
verifier(abs($stock->valeurTotale() - 3900) < 0.001, 'Stock : valeurTotale() vaut 3900');   
verifier(count($stock->produitsEnRupture()) === 1, 'Stock : 1 produit en rupture');
verifier($stock->produitsEnRupture()[0]->getReference() === 'P002', 'Stock : P002 est en rupture');
verifier(count($stock->produitsSousSeuil(5)) === 2, 'Stock : 2 produits sous le seuil 5');
verifier(count($stock->produitsSousSeuil(3)) === 1, 'Stock : seuil strict (3 n\'est pas < 3)');