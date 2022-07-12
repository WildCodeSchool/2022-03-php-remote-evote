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
        foreach ($csv as $data) {
            if (empty($data['FullName']) || empty($data['Email']) || empty($data['Telephone'])) {
                continue;
            }
            $voter = new Voter();
            $uuid = Uuid::v4();

            $this->setCompany($voter, $data);
            $this->setCollege($voter, $data, $campaign);

            $voter->setUuid($uuid->toRfc4122());
            $voter->setFullname($data['FullName']);
            $voter->setCampaign($campaign);
            $voter->setTelephone($data['Telephone']);
            $voter->setEmail($data['Email']);
            $voter->setNumberOfVote(intval($data['NombreDeVoix']));
            $this->entityManager->persist($voter);
        }
        $this->entityManager->flush();
    }

    private function setCompany(Voter $voter, array $data): void
    {
        if (!empty($data['StructureRepresentee'])) {
            $company = $this->companyRepository->findOneByName($data['StructureRepresentee']);
            if (!$company) {
                $company = new Company();
                $company->setName($data['StructureRepresentee']);
                $this->entityManager->persist($company);
                $this->entityManager->flush();
            }
            $voter->setCompany($company);
        }
    }

    private function setCollege(Voter $voter, array $data, Campaign $campaign): void
    {
        if (!empty($data['College'])) {
            $college = $this->collegeRepository->findOneByName($data['College']);
            if (!$college) {
//  @todo implement vote percentage by csv
                $college = new College();
                $college->setCompany($campaign->getCompany());
                $college->setName($data['College']);
                $this->entityManager->persist($college);
                $this->entityManager->flush();
            }
            $voter->setCollege($college);
        }
    }
}
