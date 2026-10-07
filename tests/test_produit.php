<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Produit.php';

class ProduitTest extends TestCase
{
    // ----- Constructeur -----

    public function testCreationValide(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $this->assertSame("P001", $p->getReference());
        $this->assertSame("Clavier", $p->getNom());
        $this->assertSame(150.0, $p->getPrix());
        $this->assertSame(10, $p->getQuantite());
    }

    public function testQuantiteParDefautEstZero(): void
    {
        $p = new Produit("P002", "Souris", 50.0);

        $this->assertSame(0, $p->getQuantite());
    }

    public function testPrixNegatifLeveException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Produit("P003", "Ecran", -10.0, 5);
    }

    public function testQuantiteNegativeLeveException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Produit("P004", "Cable", 10.0, -1);
    }

    // ----- ajouterQuantite -----

    public function testAjouterQuantite(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $p->ajouterQuantite(5);

        $this->assertSame(15, $p->getQuantite());
    }

    public function testAjouterQuantiteZeroLeveException(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $this->expectException(InvalidArgumentException::class);

        $p->ajouterQuantite(0);
    }

    public function testAjouterQuantiteNegativeLeveException(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $this->expectException(InvalidArgumentException::class);

        $p->ajouterQuantite(-3);
    }

    // ----- retirerQuantite -----

    public function testRetirerQuantite(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $p->retirerQuantite(4);

        $this->assertSame(6, $p->getQuantite());
    }

    public function testRetirerToutLeStock(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $p->retirerQuantite(10);

        $this->assertSame(0, $p->getQuantite());
    }

    public function testRetirerPlusQueLeStockLeveException(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Stock insuffisant.");

        $p->retirerQuantite(11);
    }

    public function testRetirerQuantiteNegativeLeveException(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $this->expectException(InvalidArgumentException::class);

        $p->retirerQuantite(-2);
    }

    public function testStockInchangeApresUneErreur(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        try {
            $p->retirerQuantite(100);
        } catch (InvalidArgumentException $e) {
            // On ignore l'erreur : on veut seulement vérifier le stock après
        }

        $this->assertSame(10, $p->getQuantite());
    }

    // ----- valeurStock -----

    public function testValeurStock(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);

        $this->assertSame(1500.0, $p->valeurStock());
    }

    public function testValeurStockVide(): void
    {
        $p = new Produit("P002", "Souris", 50.0);

        $this->assertSame(0.0, $p->valeurStock());
    }

    public function testValeurStockApresModifications(): void
    {
        $p = new Produit("P001", "Clavier", 150.0, 10);
        $p->ajouterQuantite(5);
        $p->retirerQuantite(3);

        $this->assertSame(1800.0, $p->valeurStock());
    }
}