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