<?php

namespace Nathand\Doctrine\entities;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: "compte_courant")]
class CompteCourant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private ?float $solde = null;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private ?float $autorisationDecouvert = null;

    #[ORM\ManyToOne(targetEntity: 'Client', inversedBy: 'comptesCourant')]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private $client;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of solde
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set the value of solde
     *
     * @return  self
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get the value of autorisationDecouvert
     */
    public function getAutorisationDecouvert()
    {
        return $this->autorisationDecouvert;
    }

    /**
     * Set the value of autorisationDecouvert
     *
     * @return  self
     */
    public function setAutorisationDecouvert($autorisationDecouvert)
    {
        $this->autorisationDecouvert = $autorisationDecouvert;

        return $this;
    }

    /**
     * Get the value of client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the value of client
     *
     * @return  self
     */
    public function setClient($client)
    {
        // If the compte courant is already associated with a client, remove it
        if ($this->client !== null) {
            $this->client->removeCompteCourant($this);
        }

        // Associate the compte courant with the new client
        $this->client = $client;

        // If a client is provided, add the compte courant to the client's list
        if ($client !== null) {
            $client->addCompteCourant($this);
        }

        return $this;
    }
}
