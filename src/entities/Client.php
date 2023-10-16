#!/usr/bin/env php
<?php

namespace Nathand\Doctrine\entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity]
#[ORM\Table(name: 'Client')]
class Client
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private ?string $name;

    #[ORM\Column(type: 'string')]
    private ?string $mail;

    #[ORM\OneToMany(targetEntity: "CompteCourant", mappedBy: "client")]
    private ?PersistentCollection $comptesCourants = null;

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
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of mail
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of comptesCourant
     */
    public function getComptesCourant()
    {
        return $this->comptesCourants;
    }

    /**
     * Set the value of comptesCourant
     *
     * @return  self
     */
    public function setComptesCourant($comptesCourants)
    {
        $this->comptesCourants = $comptesCourants;

        return $this;
    }

    public function addCompteCourant(CompteCourant $compteCourant): self
    {
        if(!$this->comptesCourants){
            $this->comptesCourants = new ArrayCollection();
        }
        if (!$this->comptesCourants->contains($compteCourant)) {
            $this->comptesCourants[] = $compteCourant;
            $compteCourant->setClient($this);
        }

        return $this;
    }

    public function removeCompteCourant(CompteCourant $compteCourant): self
    {
        if ($this->comptesCourants->removeElement($compteCourant)) {
            // set the owning side to null (unless already changed)
            if ($compteCourant->getClient() === $this) {
                $compteCourant->setClient(null);
            }
        }
        if($this->comptesCourants->isEmpty()){
            $this->comptesCourants=null;
        }

        return $this;
    }
}
