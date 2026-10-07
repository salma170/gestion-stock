<?php
$p = new Produit("P001", "Clavier", 150, 10);
verifier($p->getQuantite() === 10, "La quantite initiale est 10");
$p->retirerQuantite(3);
verifier($p->getQuantite() === 7, "Apres retrait de 3, il en reste 7");
verifier(abs($p->valeurStock() - 1050) < 0.001, "La valeur du stock vaut 7 x 150");
