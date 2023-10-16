<?php

namespace Nathand\Doctrine\controller;

use Doctrine\ORM\EntityManagerInterface;
use Nathand\Doctrine\entities\Client;

class ClientController
{
    private static $instance = null;
    private $entityManager;
    private $repository;

    private function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('Nathand\Doctrine\entities\Client');
    }

    public static function getInstance(EntityManagerInterface $entityManager)
    {
        if (self::$instance == null) {
            self::$instance = new ClientController($entityManager);
        }

        return self::$instance;
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

    public function get($id = null, $name = null, $mail = null)
    {
        $attributes = array_filter([
            'id' => $id,
            'name' => $name,
            'mail' => $mail
        ]);

        return $this->repository->findBy($attributes);
    }

    public function create($name, $mail)
    {
        $client = new Client();
        $client->setName($name);
        $client->setMail($mail);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    public function update($id, $name = null, $mail = null)
    {
        $client = $this->repository->find($id);

        if ($client === null) {
            echo "no client found";
            exit(1);
        }

        if ($name !== null) {
            $client->setName($name);
        }

        if ($mail !== null) {
            $client->setMail($mail);
        }

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    public function delete($id)
    {
        $client = $this->repository->find($id);

        if ($client === null) {
            echo "no client found";
            exit(1);
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}
