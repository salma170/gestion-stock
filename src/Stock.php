<?php

class Stock
{
    /** @var Produit[] indexés par référence */
    private array $produits = [];

    public function ajouter(Produit $p): void
    {
        if (isset($this->produits[$p->getReference()])) {
            throw new InvalidArgumentException(
                "La référence " . $p->getReference() . " existe déjà."
            );
        }
        $this->produits[$p->getReference()] = $p;
    }

    public function trouver(string $reference): ?Produit
    {
        return $this->produits[$reference] ?? null;
    }
}