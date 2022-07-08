<?php

namespace App\Service;

use App\Entity\Voter;
use App\Entity\College;
use App\Entity\Company;
use App\Entity\Campaign;
use Symfony\Component\Uid\Uuid;
use App\Repository\VoterRepository;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class VoterManager
{
    public function __construct(
        private DecoderInterface $decoderInterface,
        private EntityManagerInterface $entityManager,
    ) {
    }
    public function importVoter(Campaign $campaign, UploadedFile $file): void
    {
        if ($file->guessClientExtension() !== 'csv') {
            return;
        }

        $filePath = $file->getRealPath(); //chemin vers le fichier pour le lire
        $context = [
            CsvEncoder::DELIMITER_KEY => ';',
            CsvEncoder::ENCLOSURE_KEY => '"',
            CsvEncoder::ESCAPE_CHAR_KEY => '\\',
            CsvEncoder::KEY_SEPARATOR_KEY => ';',
        ];
        //appeler le decoderInterface pour decoder CSV contents
        $csv = $this->decoderInterface->decode(file_get_contents($filePath), 'csv', $context);
        //parcours-moi le tableau $csv et considère que chaque ligne s'appellera $data dt l'index s'appelera $key
        foreach ($csv as $key => $data) {
            $voter = new Voter();
            $company = new Company();
            $uuid = Uuid::v4();
            $voter->setCompany($company);
            $voter->setUuid($uuid->toRfc4122() . $key);
            $voter->setFullname($data['FullName']);
            $voter->setCampaign($campaign);
            $voter->setTelephone($data['Telephone']);
            $voter->setEmail($data['Email']);
            $voter->setNumberOfVote($data['NombreDeVoix']);
            $this->entityManager->persist($company);
            //$this->entityManager->persist($college);
            $this->entityManager->persist($voter);
        }
        $this->entityManager->flush();
    }
}
