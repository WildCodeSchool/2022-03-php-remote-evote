<?php

namespace App\Service;

use App\Entity\Voter;
use App\Entity\College;
use App\Entity\Company;
use App\Entity\Campaign;
use Symfony\Component\Uid\Uuid;
use App\Repository\CompanyRepository;
use App\Repository\CollegeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;

class VoterManager
{
    public function __construct(
        private DecoderInterface $decoderInterface,
        private EntityManagerInterface $entityManager,
        private CompanyRepository $companyRepository,
        private CollegeRepository $collegeRepository,
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
            $uuid = Uuid::v4();

            if (!empty($data['StructureRepresentée'])) {
                $company = $this->companyRepository->findOneByName($data['StructureRepresentée']);
                if (!$company) {
                    $company = new Company();
                    $company->setName($data['StructureRepresentée']);
                    $this->entityManager->persist($company);
                }
                $voter->setCompany($company);
            }
            if (!empty($data['College'])) {
                $college = $this->collegeRepository->findOneByName($data['College']);
                if (!$college) {
                    $college = new College();
                    $college->setName($data['College']);
                    $this->entityManager->persist($college);
                }
                $voter->setCollege($college);
            }
            $voter->setUuid($uuid->toRfc4122() . $key);
            $voter->setFullname($data['FullName']);
            $voter->setCampaign($campaign);
            $voter->setTelephone($data['Telephone']);
            $voter->setEmail($data['Email']);
            $voter->setNumberOfVote($data['NombreDeVoix']);
            $this->entityManager->persist($voter);
        }
        $this->entityManager->flush();
    }
}
