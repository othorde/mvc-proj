<?php

namespace App\Entity;

use App\Repository\YatzyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=YatzyRepository::class)
 */
class Yatzy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ettor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tvaor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $treor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fyror;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $femmor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sexor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $summa;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bonus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $par;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parpar;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tretal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fyrtal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $straight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sstraight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kak;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $chans;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yatzy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEttor(): ?int
    {
        return $this->ettor;
    }

    public function setEttor(?int $ettor): self
    {
       
        $this->ettor = $ettor;

        return $this;
    }

    public function getTvaor(): ?int
    {
        return $this->tvaor;
    }

    public function setTvaor(?int $tvaor): self
    {
        $this->tvaor = $tvaor;

        return $this;
    }

    public function getTreor(): ?int
    {
        return $this->treor;
    }

    public function setTreor(?int $treor): self
    {
        $this->treor = $treor;

        return $this;
    }

    public function getFyror(): ?int
    {
        return $this->fyror;
    }

    public function setFyror(?int $fyror): self
    {
        $this->fyror = $fyror;

        return $this;
    }

    public function getFemmor(): ?int
    {
        return $this->femmor;
    }

    public function setFemmor(?int $femmor): self
    {
        $this->femmor = $femmor;

        return $this;
    }

    public function getSexor(): ?int
    {
        return $this->sexor;
    }

    public function setSexor(?int $sexor): self
    {
        $this->sexor = $sexor;

        return $this;
    }

    public function getSumma(): ?int
    {
        return $this->summa;
    }

    public function setSumma(?int $summa): self
    {
        $this->summa = $summa;

        return $this;
    }

    public function getBonus(): ?int
    {
        return $this->bonus;
    }

    public function setBonus(?int $bonus): self
    {
        $this->bonus = $bonus;

        return $this;
    }

    public function getPar(): ?int
    {
        return $this->par;
    }

    public function setPar(?int $par): self
    {
        $this->par = $par;

        return $this;
    }

    public function getParpar(): ?int
    {
        return $this->parpar;
    }

    public function setParpar(?int $parpar): self
    {
        $this->parpar = $parpar;

        return $this;
    }

    public function getTretal(): ?int
    {
        return $this->tretal;
    }

    public function setTretal(?int $tretal): self
    {
        $this->tretal = $tretal;

        return $this;
    }

    public function getFyrtal(): ?int
    {
        return $this->fyrtal;
    }

    public function setFyrtal(?int $fyrtal): self
    {
        $this->fyrtal = $fyrtal;

        return $this;
    }

    public function getStraight(): ?int
    {
        return $this->straight;
    }

    public function setStraight(?int $straight): self
    {
        $this->straight = $straight;

        return $this;
    }

    public function getSstraight(): ?int
    {
        return $this->sstraight;
    }

    public function setSstraight(?int $sstraight): self
    {
        $this->sstraight = $sstraight;

        return $this;
    }

    public function getKak(): ?int
    {
        return $this->kak;
    }

    public function setKak(?int $kak): self
    {
        $this->kak = $kak;

        return $this;
    }

    public function getChans(): ?int
    {
        return $this->chans;
    }

    public function setChans(?int $chans): self
    {
        $this->chans = $chans;

        return $this;
    }

    public function getYatzy(): ?int
    {
        return $this->yatzy;
    }

    public function setYatzy(?int $yatzy): self
    {
        $this->yatzy = $yatzy;

        return $this;
    }

    public function getTotalt(): ?int
    {
        return $this->totalt;
    }

    public function setTotalt(?int $totalt): self
    {
        $this->totalt = $totalt;

        return $this;
    }
}
