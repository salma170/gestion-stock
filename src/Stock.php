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
        public function tous(): array
    {
        return array_values($this->produits);
    }

    public function compter(): int
    {
        return count($this->produits);
    }

     public function valeurTotale(): float
   {
       $total = 0.0;
       foreach ($this->produits as $p) {
           $total += $p->getPrix();   // BUG : additionne les prix, pas les valeurs de stock
       }
       return $total;
   }

    public function produitsEnRupture(): array
    {
        return array_values(array_filter(
            $this->produits,
            fn(Produit $p) => $p->getQuantite() === 0
        ));
    }

    public function produitsSousSeuil(int $seuil): array
    {
        return array_values(array_filter(
            $this->produits,
            fn(Produit $p) => $p->getQuantite() < $seuil   // strictement inférieur
        ));
    }
}