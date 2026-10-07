<?php
class Commande
{
    private int $numero;
    private array $lignes = [];   // chaque ligne : ['produit' => Produit, 'quantite' => int]
    private bool $validee = false;

    public function __construct(int $numero)
    {
        $this->numero = $numero;
    }

    public function ajouterLigne(Produit $p, int $quantite): void
    {
        if ($quantite <= 0) {
            throw new InvalidArgumentException("La quantité doit être positive.");
        }
        if ($quantite > $p->getQuantite()) {
            throw new InvalidArgumentException("Quantité supérieure au stock disponible.");
        }
        $this->lignes[] = ['produit' => $p, 'quantite' => $quantite];
    }

    public function total(): float
    {
        $somme = 0.0;
        foreach ($this->lignes as $l) {
            $somme += $l['produit']->getPrix() * $l['quantite'];
        }
        return $somme;
    }

    public function valider(): void
    {
        if (empty($this->lignes)) {
            throw new LogicException("Commande vide.");
        }
        if ($this->validee) {
            throw new LogicException("Commande déjà validée.");
        }
        foreach ($this->lignes as $l) {
            $l['produit']->retirerQuantite($l['quantite']);
        }
        $this->validee = true;
    }

    public function estValidee(): bool
    {
        return $this->validee;
    }

    public function afficher(): string
    {
        $out = "=== Facture commande n°{$this->numero} ===\n";
        foreach ($this->lignes as $l) {
            $p = $l['produit'];
            $out .= sprintf("%s x%d @ %.2f = %.2f\n",
                $p->getNom(), $l['quantite'], $p->getPrix(), $p->getPrix() * $l['quantite']);
        }
        $out .= sprintf("TOTAL : %.2f\n", $this->total());
        $out .= $this->validee ? "Statut : validée\n" : "Statut : en attente\n";
        return $out;
    }
}