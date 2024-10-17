<?php

namespace App\DataFixtures;

use App\Entity\Folder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FolderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Utilisation de Faker pour générer des données aléatoires
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            // Création d'une nouvelle instance de Folder
            $folder = new Folder();
            
            // Assignation de valeurs aléatoires à chaque champ
            $folder->setUrbaPermissionNumber($faker->regexify('[A-Z]{2}-[0-9]{4}-[A-Z]{2}')) // Ex : AB-1234-CD
                   ->setPetitionerName($faker->name) // Nom du pétitionnaire
                   ->setAddressOfWorks($faker->address) // Adresse des travaux
                   ->setDetailsOfWorks($faker->sentence(10)); // Détails des travaux

            // Enregistrement de l'objet Folder
            $manager->persist($folder);
        }

        // Envoi des objets dans la base de données
        $manager->flush();
    }
}
