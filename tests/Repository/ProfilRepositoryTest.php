<?php

namespace App\Tests\Repository;

use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilRepositoryTest extends WebTestCase
{
    private ProfilRepository $profilRepository;

    private mixed $em;


    protected function setUp(): void
    {
        self::bootKernel();

        $this->client = static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);


        $this->profilRepository = $this->em->getRepository(Profil::class);
    }

    public function testFindById()
    {
        // Créer un profil pour tester
        $profil = new Profil();
        $profil->setName('John Doe');
        $profil->setDescription('Jean Dupont');
        $this->em->persist($profil);
        $this->em->flush();

        // Récupérer l'ID du profil
        $profilId = $profil->getId();

        // Rechercher le profil par ID
        $foundProfil = $this->profilRepository->find($profilId);

        // Vérifier si le profil retrouvé correspond au profil créé
        $this->assertEquals('John Doe', $foundProfil->getName());
        $this->assertEquals('Jean Dupont', $foundProfil->getDescription());
    }

    public function testFindByExampleField()
    {
        // Créer plusieurs profils pour tester
        $profil1 = new Profil();
        $profil1->setName('Alice');
        $profil1->setDescription('Alice\'s profile');
        $this->em->persist($profil1);

        $profil2 = new Profil();
        $profil2->setName('Bob');
        $profil2->setDescription('Bob\'s profile');
        $this->em->persist($profil2);

        $this->em->flush();

        // Rechercher les profils par nom
        $foundProfils = $this->profilRepository->findBy(['name' => 'Alice']);

        // Vérifier si le bon profil a été trouvé
        $this->assertCount(1, $foundProfils);
        $this->assertEquals('Alice', $foundProfils[0]->getName());
        $this->assertEquals('Alice\'s profile', $foundProfils[0]->getDescription());
    }

    public function testFindOneBySomeField()
    {
        // Créer un profil pour tester
        $profil = new Profil();
        $profil->setName('John Doe');
        $profil->setDescription('Jean Dupont');
        $this->em->persist($profil);
        $this->em->flush();

        // Rechercher le profil par nom
        $foundProfil = $this->profilRepository->findOneBy(['name' => 'John Doe']);

        $this->assertEquals('John Doe', $foundProfil->getName());
        $this->assertEquals('Jean Dupont', $foundProfil->getDescription());
    }

    /**
     * @throws Exception
     */
    protected function tearDown(): void
    {
        parent::tearDown();


        $this->em->getConnection()->executeStatement('DELETE FROM profil');
        $this->em->close();

    }
}
