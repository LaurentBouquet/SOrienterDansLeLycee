<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public const SALLE_22_REFERENCE = 'SALLE_22';
    public const PETIT_AMPHI_REFERENCE = 'PETIT_AMPHI';
    public const SALLE_136_REFERENCE = 'SALLE_136';
    public const SALLE_138_REFERENCE = 'SALLE_138';
    public const COULOIR_PRINCIPAL_DROITE_REFERENCE = 'COULOIR_PRINCIPAL_DROITE';
    public const COULOIR_PRINCIPAL_GAUCHE_REFERENCE = 'COULOIR_PRINCIPAL_GAUCHE';
    public const COULOIR_SECONDAIRE_HAUT_DROITE_REFERENCE = 'COULOIR_SECONDAIRE_HAUT_DROITE';
    public const CARREFOUR_DROITE_REFERENCE = 'CARREFOUR_DROITE';
    public const COULOIR_PRINCIPAL_DROITE_ETAGE_1_REFERENCE = 'COULOIR_PRINCIPAL_DROITE_ETAGE_1';
    public const COULOIR_PRINCIPAL_GAUCHE_ETAGE_1_REFERENCE = 'COULOIR_PRINCIPAL_GAUCHE_ETAGE_1';
    public const COULOIR_SECONDAIRE_HAUT_DROITE_ETAGE_1_REFERENCE = 'COULOIR_SECONDAIRE_HAUT_DROITE_ETAGE_1';
    public const CARREFOUR_DROITE_ETAGE_1_REFERENCE = 'CARREFOUR_DROITE_ETAGE_1';
    public const ESCALIER_DROITE_REFERENCE = 'ESCALIER_DROITE';
    public const ESCALIER_DROITE_ETAGE_1_REFERENCE = 'ESCALIER_DROITE_ETAGE_1';

    public function load(ObjectManager $manager): void
    {
        // Salles
        $salle22 = new Location();
        $salle22->setName('Salle 22');
        $salle22->setType('ROOM');
        $salle22->setFloor(0);
        $manager->persist($salle22);

        $petitAmphi = new Location();
        $petitAmphi->setName('Petit Amphi');
        $petitAmphi->setType('ROOM');
        $petitAmphi->setFloor(0);
        $manager->persist($petitAmphi);

        $salle136 = new Location();
        $salle136->setName('Salle 136');
        $salle136->setType('ROOM');
        $salle136->setFloor(1);
        $manager->persist($salle136);

        $salle138 = new Location();
        $salle138->setName('Salle 138');
        $salle138->setType('ROOM');
        $salle138->setFloor(1);
        $manager->persist($salle138);

        // Couloirs RDC
        $couloirPrincipalDroite = new Location();
        $couloirPrincipalDroite->setName('Couloir Principal Droite');
        $couloirPrincipalDroite->setType('CORRIDOR');
        $couloirPrincipalDroite->setFloor(0);
        $manager->persist($couloirPrincipalDroite);

        $couloirPrincipalGauche = new Location();
        $couloirPrincipalGauche->setName('Couloir Principal Gauche');
        $couloirPrincipalGauche->setType('CORRIDOR');
        $couloirPrincipalGauche->setFloor(0);
        $manager->persist($couloirPrincipalGauche);

        $couloirSecondaireHautDroite = new Location();
        $couloirSecondaireHautDroite->setName('Couloir Secondaire Haut Droite');
        $couloirSecondaireHautDroite->setType('CORRIDOR');
        $couloirSecondaireHautDroite->setFloor(0);
        $manager->persist($couloirSecondaireHautDroite);

        $carrefourDroite = new Location();
        $carrefourDroite->setName('Carrefour Droite');
        $carrefourDroite->setType('CORRIDOR');
        $carrefourDroite->setFloor(0);
        $manager->persist($carrefourDroite);

        // Couloirs Étage 1
        $couloirPrincipalDroiteEtage1 = new Location();
        $couloirPrincipalDroiteEtage1->setName('Couloir Principal Droite Étage 1');
        $couloirPrincipalDroiteEtage1->setType('CORRIDOR');
        $couloirPrincipalDroiteEtage1->setFloor(1);
        $manager->persist($couloirPrincipalDroiteEtage1);

        $couloirPrincipalGaucheEtage1 = new Location();
        $couloirPrincipalGaucheEtage1->setName('Couloir Principal Gauche Étage 1');
        $couloirPrincipalGaucheEtage1->setType('CORRIDOR');
        $couloirPrincipalGaucheEtage1->setFloor(1);
        $manager->persist($couloirPrincipalGaucheEtage1);

        $couloirSecondaireHautDroiteEtage1 = new Location();
        $couloirSecondaireHautDroiteEtage1->setName('Couloir Secondaire Haut Droite Étage 1');
        $couloirSecondaireHautDroiteEtage1->setType('CORRIDOR');
        $couloirSecondaireHautDroiteEtage1->setFloor(1);
        $manager->persist($couloirSecondaireHautDroiteEtage1);

        $carrefourDroiteEtage1 = new Location();
        $carrefourDroiteEtage1->setName('Carrefour Droite Étage 1');
        $carrefourDroiteEtage1->setType('CORRIDOR');
        $carrefourDroiteEtage1->setFloor(1);
        $manager->persist($carrefourDroiteEtage1);

        // Escaliers
        $escalierDroite = new Location();
        $escalierDroite->setName('Escalier Droite');
        $escalierDroite->setType('STAIRS');
        $escalierDroite->setFloor(0);
        $manager->persist($escalierDroite);

        $escalierDroiteEtage1 = new Location();
        $escalierDroiteEtage1->setName('Escalier Droite Étage 1');
        $escalierDroiteEtage1->setType('STAIRS');
        $escalierDroiteEtage1->setFloor(1);
        $manager->persist($escalierDroiteEtage1);

        $manager->flush();

        $this->addReference(self::SALLE_22_REFERENCE, $salle22);
        $this->addReference(self::PETIT_AMPHI_REFERENCE, $petitAmphi);
        $this->addReference(self::SALLE_136_REFERENCE, $salle136);
        $this->addReference(self::SALLE_138_REFERENCE, $salle138);
        $this->addReference(self::COULOIR_PRINCIPAL_DROITE_REFERENCE, $couloirPrincipalDroite);
        $this->addReference(self::COULOIR_PRINCIPAL_GAUCHE_REFERENCE, $couloirPrincipalGauche);
        $this->addReference(self::COULOIR_SECONDAIRE_HAUT_DROITE_REFERENCE, $couloirSecondaireHautDroite);
        $this->addReference(self::CARREFOUR_DROITE_REFERENCE, $carrefourDroite);
        $this->addReference(self::COULOIR_PRINCIPAL_DROITE_ETAGE_1_REFERENCE, $couloirPrincipalDroiteEtage1);
        $this->addReference(self::COULOIR_PRINCIPAL_GAUCHE_ETAGE_1_REFERENCE, $couloirPrincipalGaucheEtage1);
        $this->addReference(self::COULOIR_SECONDAIRE_HAUT_DROITE_ETAGE_1_REFERENCE, $couloirSecondaireHautDroiteEtage1);
        $this->addReference(self::CARREFOUR_DROITE_ETAGE_1_REFERENCE, $carrefourDroiteEtage1);
        $this->addReference(self::ESCALIER_DROITE_REFERENCE, $escalierDroite);
        $this->addReference(self::ESCALIER_DROITE_ETAGE_1_REFERENCE, $escalierDroiteEtage1);
    }
}
