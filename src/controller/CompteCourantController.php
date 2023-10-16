<?php

namespace Nathand\Doctrine\controller;

use Nathand\Doctrine\entities\CompteCourant;

class CompteCourantController
{
    private $entityManager;
    private $repository;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(CompteCourant::class);
    }

    public function create($solde, $autorisationDecouvert, $client)
    {
        $compteCourant = new CompteCourant();
        $compteCourant->setSolde($solde);
        $compteCourant->setAutorisationDecouvert($autorisationDecouvert);
        $compteCourant->setClient($client);

        $this->entityManager->persist($compteCourant);
        $this->entityManager->flush();

        return $compteCourant;
    }

    public function update($id, $solde = null, $autorisationDecouvert = null, $client = null)
    {
        $compteCourant = $this->repository->find($id);

        if ($compteCourant === null) {
            echo "no compte courant found";
            exit(1);
        }

        if ($solde !== null) {
            $compteCourant->setSolde($solde);
        }

        if ($autorisationDecouvert !== null) {
            $compteCourant->setAutorisationDecouvert($autorisationDecouvert);
        }

        if ($client !== null) {
            $compteCourant->setClient($client);
        }

        $this->entityManager->persist($compteCourant);
        $this->entityManager->flush();

        return $compteCourant;
    }

    public function delete($id)
    {
        $compteCourant = $this->repository->find($id);

        if ($compteCourant === null) {
            echo "no compte courant found";
            exit(1);
        }

        $this->entityManager->remove($compteCourant);
        $this->entityManager->flush();
    }
}
