<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionsExternesRepository")
 */
class QuestionsExternes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaAlta;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaBaja;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipusQE", inversedBy="questionsExternes")
     */
    private $tipus;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DafoTipusQE", mappedBy="questioExterna", cascade={"persist", "remove"})
     */
    private $tipusDafo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Binomio", mappedBy="QuestionExterna")
     */
    private $binomio;

    public function __construct()
    {
        $this->binomio = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaAlta(): ?\DateTimeInterface
    {
        return $this->fechaAlta;
    }

    public function setFechaAlta(\DateTimeInterface $fechaAlta): self
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    public function getFechaBaja(): ?\DateTimeInterface
    {
        return $this->fechaBaja;
    }

    public function setFechaBaja(\DateTimeInterface $fechaBaja): self
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    public function getTipus(): ?TipusQE
    {
        return $this->tipus;
    }

    public function setTipus(?TipusQE $tipus): self
    {
        $this->tipus = $tipus;

        return $this;
    }

    public function getTipusDafo(): ?DafoTipusQE
    {
        return $this->tipusDafo;
    }

    public function setTipusDafo(?DafoTipusQE $tipusDafo): self
    {
        $this->tipusDafo = $tipusDafo;

        // set (or unset) the owning side of the relation if necessary
        $newQuestioExterna = $tipusDafo === null ? null : $this;
        if ($newQuestioExterna !== $tipusDafo->getQuestioExterna()) {
            $tipusDafo->setQuestioExterna($newQuestioExterna);
        }

        return $this;
    }

    /**
     * @return Collection|Binomio[]
     */
    public function getBinomio(): Collection
    {
        return $this->binomio;
    }

    public function addBinomio(Binomio $binomio): self
    {
        if (!$this->binomio->contains($binomio)) {
            $this->binomio[] = $binomio;
            $binomio->setQuestionExterna($this);
        }

        return $this;
    }

    public function removeBinomio(Binomio $binomio): self
    {
        if ($this->binomio->contains($binomio)) {
            $this->binomio->removeElement($binomio);
            // set the owning side to null (unless already changed)
            if ($binomio->getQuestionExterna() === $this) {
                $binomio->setQuestionExterna(null);
            }
        }

        return $this;
    }
}
