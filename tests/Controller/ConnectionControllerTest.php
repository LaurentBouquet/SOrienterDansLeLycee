<?php

namespace App\Tests\Controller;

use App\Entity\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ConnectionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $connectionRepository;
    private string $path = '/connection/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->connectionRepository = $this->manager->getRepository(Connection::class);

        foreach ($this->connectionRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Connection index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'connection[weight]' => 'Testing',
            'connection[pmr]' => 'Testing',
            'connection[instructionAtoB]' => 'Testing',
            'connection[instructionBtoA]' => 'Testing',
            'connection[locationA]' => 'Testing',
            'connection[locationB]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->connectionRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Connection();
        $fixture->setWeight('My Title');
        $fixture->setPmr('My Title');
        $fixture->setInstructionAtoB('My Title');
        $fixture->setInstructionBtoA('My Title');
        $fixture->setLocationA('My Title');
        $fixture->setLocationB('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Connection');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Connection();
        $fixture->setWeight('Value');
        $fixture->setPmr('Value');
        $fixture->setInstructionAtoB('Value');
        $fixture->setInstructionBtoA('Value');
        $fixture->setLocationA('Value');
        $fixture->setLocationB('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'connection[weight]' => 'Something New',
            'connection[pmr]' => 'Something New',
            'connection[instructionAtoB]' => 'Something New',
            'connection[instructionBtoA]' => 'Something New',
            'connection[locationA]' => 'Something New',
            'connection[locationB]' => 'Something New',
        ]);

        self::assertResponseRedirects('/connection/');

        $fixture = $this->connectionRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getWeight());
        self::assertSame('Something New', $fixture[0]->getPmr());
        self::assertSame('Something New', $fixture[0]->getInstructionAtoB());
        self::assertSame('Something New', $fixture[0]->getInstructionBtoA());
        self::assertSame('Something New', $fixture[0]->getLocationA());
        self::assertSame('Something New', $fixture[0]->getLocationB());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Connection();
        $fixture->setWeight('Value');
        $fixture->setPmr('Value');
        $fixture->setInstructionAtoB('Value');
        $fixture->setInstructionBtoA('Value');
        $fixture->setLocationA('Value');
        $fixture->setLocationB('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/connection/');
        self::assertSame(0, $this->connectionRepository->count([]));
    }
}
