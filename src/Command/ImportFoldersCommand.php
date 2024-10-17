<?php

namespace App\Command;

use App\Entity\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;

#[AsCommand(
    name: 'urbanisme:importFolders',
    description: 'Importe les dossiers depuis un fichier CSV',
)]
class ImportFoldersCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('pathCSV', InputArgument::REQUIRED, 'Chemin vers le fichier CSV')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $pathCSV = $input->getArgument('pathCSV');

        if (!file_exists($pathCSV)) {
            $io->error("Le fichier CSV spécifié n'existe pas.");
            return Command::FAILURE;
        }

        $file = fopen($pathCSV, 'r');
        if ($file === false) {
            $io->error("Impossible d'ouvrir le fichier CSV.");
            return Command::FAILURE;
        }

        // Compter le nombre total de lignes dans le fichier CSV
        $lineCount = 0;
        while (!feof($file)) {
            fgets($file);
            $lineCount++;
        }
        rewind($file); // Revenir au début du fichier

        // Ignorer la ligne d'en-tête
        $header = fgetcsv($file);
        $lineCount--; // Ne pas compter la ligne d'en-tête

        $progressBar = new ProgressBar($output, $lineCount);
        $progressBar->start();

        while (($data = fgetcsv($file)) !== FALSE) {
            // S'assurer que le tableau $data a au moins 4 éléments
            $data = array_pad($data, 4, null);

            // Utiliser trim pour enlever les espaces blancs
            $urbaPermissionNumber = isset($data[0]) ? trim($data[0]) : null;
            $petitionerName = isset($data[1]) ? trim($data[1]) : null;
            $addressOfWorks = isset($data[2]) ? trim($data[2]) : null;
            $detailsOfWorks = isset($data[3]) ? trim($data[3]) : null;

            // Vérifier si les quatre champs sont vides ou nuls
            if (empty($urbaPermissionNumber) && empty($petitionerName) && empty($addressOfWorks) && empty($detailsOfWorks)) {
                $progressBar->advance();
                continue; // Passer à la ligne suivante sans persister
            }

            $folder = new Folder();
            $folder->setUrbaPermissionNumber($urbaPermissionNumber !== '' ? $urbaPermissionNumber : null);
            $folder->setPetitionerName($petitionerName !== '' ? $petitionerName : null);
            $folder->setAddressOfWorks($addressOfWorks !== '' ? $addressOfWorks : null);
            $folder->setDetailsOfWorks($detailsOfWorks !== '' ? $detailsOfWorks : null);

            // Persister l'objet dans la base de données
            $this->entityManager->persist($folder);

            // Mettre à jour la barre de progression
            $progressBar->advance();
        }

        fclose($file);

        // Sauvegarder les changements dans la base de données
        $this->entityManager->flush();

        $progressBar->finish();
        $io->newLine(2);
        $io->success(sprintf('Les données ont été importées avec succès depuis %s', $pathCSV));

        return Command::SUCCESS;
    }
}