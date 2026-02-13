<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ConnectionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        // Get all locations needed for the path
        $salle22 = $this->getReference(LocationFixtures::SALLE_22_REFERENCE, Location::class);
        $couloirPrincipalDroite = $this->getReference(LocationFixtures::COULOIR_PRINCIPAL_DROITE_REFERENCE, Location::class);
        $carrefourDroite = $this->getReference(LocationFixtures::CARREFOUR_DROITE_REFERENCE, Location::class);
        $escalierDroite = $this->getReference(LocationFixtures::ESCALIER_DROITE_REFERENCE, Location::class);
        $escalierDroiteEtage1 = $this->getReference(LocationFixtures::ESCALIER_DROITE_ETAGE_1_REFERENCE, Location::class);
        $couloirSecondaireHautDroiteEtage1 = $this->getReference(LocationFixtures::COULOIR_SECONDAIRE_HAUT_DROITE_ETAGE_1_REFERENCE, Location::class);
        $salle136 = $this->getReference(LocationFixtures::SALLE_136_REFERENCE, Location::class);

        // Connection 1: Salle 22 -> Couloir Principal Droite
        $connection1 = new Connection();
        $connection1->setLocationA($salle22);
        $connection1->setLocationB($couloirPrincipalDroite);
        $connection1->setWeight(5); // Marche
        $connection1->setPmr(true);
        $connection1->setInstructionAtoB('Sortir de la salle et tourner à droite');
        $connection1->setInstructionBtoA('Entrer dans la Salle 22');
        $manager->persist($connection1);

        // Connection 2: Couloir Principal Droite -> Carrefour Droite
        $connection2 = new Connection();
        $connection2->setLocationA($couloirPrincipalDroite);
        $connection2->setLocationB($carrefourDroite);
        $connection2->setWeight(5); // Marche
        $connection2->setPmr(true);
        $connection2->setInstructionAtoB('Avancer tout droit jusqu\'au carrefour');
        $connection2->setInstructionBtoA('Retourner vers le couloir principal');
        $manager->persist($connection2);

        // Connection 3: Carrefour Droite -> Escalier Droite
        $connection3 = new Connection();
        $connection3->setLocationA($carrefourDroite);
        $connection3->setLocationB($escalierDroite);
        $connection3->setWeight(5); // Marche
        $connection3->setPmr(true);
        $connection3->setInstructionAtoB('Tourner à gauche vers l\'escalier');
        $connection3->setInstructionBtoA('Tourner à droite vers le carrefour');
        $manager->persist($connection3);

        // Connection 4: Escalier Droite -> Escalier Droite Étage 1
        $connection4 = new Connection();
        $connection4->setLocationA($escalierDroite);
        $connection4->setLocationB($escalierDroiteEtage1);
        $connection4->setWeight(10); // Escalier
        $connection4->setPmr(false);
        $connection4->setInstructionAtoB('Monter l\'escalier jusqu\'à l\'étage 1');
        $connection4->setInstructionBtoA('Descendre l\'escalier jusqu\'au rez-de-chaussée');
        $manager->persist($connection4);

        // Connection 5: Escalier Droite Étage 1 -> Couloir Secondaire Haut Droite Étage 1
        $connection5 = new Connection();
        $connection5->setLocationA($escalierDroiteEtage1);
        $connection5->setLocationB($couloirSecondaireHautDroiteEtage1);
        $connection5->setWeight(5); // Marche
        $connection5->setPmr(true);
        $connection5->setInstructionAtoB('Tourner à droite et avancer dans le couloir');
        $connection5->setInstructionBtoA('Retourner vers l\'escalier');
        $manager->persist($connection5);

        // Connection 6: Couloir Secondaire Haut Droite Étage 1 -> Salle 136
        $connection6 = new Connection();
        $connection6->setLocationA($couloirSecondaireHautDroiteEtage1);
        $connection6->setLocationB($salle136);
        $connection6->setWeight(5); // Marche
        $connection6->setPmr(true);
        $connection6->setInstructionAtoB('Avancer tout droit jusqu\'à la Salle 136');
        $connection6->setInstructionBtoA('Sortir de la salle et retourner dans le couloir');
        $manager->persist($connection6);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
        ];
    }
}
