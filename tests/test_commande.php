<?php
$p = new Produit('P001', 'Clavier', 150, 10);
$c = new Commande(1);
$c->ajouterLigne($p, 2);
verifier(abs($c->total() - 300) < 0.001, 'Le total vaut 2 x 150');
verifier($c->estValidee() === false, 'La commande n\'est pas validée au départ');
$c->valider();
verifier($p->getQuantite() === 8, 'Après validation, le stock passe à 8');
verifier($c->estValidee() === true, 'La commande est validée');

try { $c->valider(); verifier(false, 'Double validation refusée'); }
catch (LogicException $e) { verifier(true, 'Double validation refusée'); }

try { (new Commande(2))->ajouterLigne($p, 100); verifier(false, 'Dépassement du stock refusé'); }
catch (InvalidArgumentException $e) { verifier(true, 'Dépassement du stock refusé'); }