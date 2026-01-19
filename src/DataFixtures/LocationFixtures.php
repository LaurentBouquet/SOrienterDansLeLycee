<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $salles = [
            'Salle 22',
            'Petit Amphi',
            'Salle 136',
            'Salle 138',
        ];
        foreach ($salles as $salle) {
            $location = new Location();
            $location->setName($salle);
            $location->setType('ROOM');
            if ($salle === 'Petit Amphi' || $salle === 'Salle 22') {
                $location->setFloor(0);
            } else {
                $location->setFloor(1);
            }
            $manager->persist($location);
        }

        $couloirRDC = [
            'Couloir Principal Droite',
            'Couloir Principal Gauche',
            'Couloir Secondaire Haut Droite',
            'Carrefour Droite',
        ];
        foreach ($couloirRDC as $couloir) {
            $location = new Location();
            $location->setName($couloir);
            $location->setType('CORRIDOR');
            $location->setFloor(0);
            $manager->persist($location);
        }

        $couloirEtage1 = [
            'Couloir Principal Droite Étage 1',
            'Couloir Principal Gauche Étage 1',
            'Couloir Secondaire Haut Droite Étage 1',
            'Carrefour Droite Étage 1',
        ];
        foreach ($couloirEtage1 as $couloir) {
            $location = new Location();
            $location->setName($couloir);
            $location->setType('CORRIDOR');
            $location->setFloor(1);
            $manager->persist($location);
        }

        $escaliers = [
            'Escalier Droite',
            'Escalier Droite Étage 1',
        ];
        foreach ($escaliers as $escalier) {
            $location = new Location();
            $location->setName($escalier);
            $location->setType('STAIRS');
            if ($escalier === 'Escalier Droite') {
                $location->setFloor(0);
            } else {
                $location->setFloor(1);
            }
            $manager->persist($location);
        }

        $manager->flush();
    }
}
