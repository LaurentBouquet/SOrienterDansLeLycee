<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Connection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlgoTestFixtures extends Fixture
{
    /**
     * Charge des données de test pour l'algorithme de cheminement.
     * 
     * Le graphe créé est conçu pour tester divers scénarios d'itinéraires,
     * y compris des cul-de-sacs, des chemins alternatifs, et des connexions
     * avec différents poids (distances).
     * 
     * Schéma du graphe (vue simplifiée) :
     * 
     *         A
     *        / \
     *       B   C
     *       |   |
     *       E---F---J
     *      / \ /    |
     *     G   H     L
     *         |     |
     *         I     M
     * 
     * Légende :
     * - Les lettres représentent les Locations (Noeuds).
     * - Les lignes représentent les Connections (Arêtes) avec des poids variés.
     * - Certains points (G, D, M) sont des cul-de-sacs pour tester les retours.
     * 
     * @WARNING CODE GENERER PAR IA - NE PAS UTILISER DIRECTEMENT EN PRODUCTION
     */
    public function load(ObjectManager $manager): void
    {
        // 1. Création des Noeuds (Locations A à M)
        $nodes = [];
        $letters = range('A', 'M'); // ['A', 'B', ... 'M']

        foreach ($letters as $letter) {
            $location = new Location();
            $location->setName("Point $letter");
            $location->setType('TEST_NODE');
            $location->setFloor(0);
            $location->setImage("$letter.jpg"); // Image fictive pour le test
            
            $manager->persist($location);
            
            // On stocke l'entité dans un tableau pour créer les liens facilement après
            $nodes[$letter] = $location;
        }

        // 2. Définition des Connexions (Arêtes) selon ton schéma
        // Format: [PointDepart, PointArrivee, Poids (Distance visuelle)]
        $connections = [
            // Départ A
            ['A', 'B', 10],
            ['A', 'C', 10],
            
            // Branche Gauche (via B)
            ['B', 'E', 8],
            ['E', 'G', 6], // G est un cul-de-sac
            
            // Branche Centre-Bas (via C et D)
            ['C', 'F', 6],
            ['D', 'F', 6], // D est un cul-de-sac
            
            // Le "Cluster" central (E, F, H, I)
            ['E', 'F', 8],
            ['E', 'H', 4],
            ['F', 'H', 10], // Diagonale
            ['H', 'I', 5], // Lien court horizontal
            
            // Connexions vers la droite (J, K, L)
            ['F', 'J', 10],
            ['H', 'K', 8],
            ['J', 'L', 8],
            ['K', 'L', 12], // Long lien horizontal
            
            // Fin du graphe (M)
            ['L', 'M', 6]  // M est un cul-de-sac
        ];

        // 3. Création des entités Connection
        foreach ($connections as $edge) {
            [$startKey, $endKey, $weight] = $edge;

            $connection = new Connection();
            $connection->setLocationA($nodes[$startKey]);
            $connection->setLocationB($nodes[$endKey]);
            $connection->setWeight($weight);
            $connection->setPmr(true); // Accessible par défaut
            
            // Instructions génériques pour le test
            $connection->setInstructionAtoB("Aller du point $startKey au point $endKey");
            $connection->setInstructionBtoA("Aller du point $endKey au point $startKey");

            $manager->persist($connection);
        }

        $manager->flush();
    }
}