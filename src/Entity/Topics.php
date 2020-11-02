<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topics
 *
 * @ORM\Table(name="topics", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idCategorie", columns={"idCategorie"})})
 * @ORM\Entity(repositoryClass="App\Repository\TopicsRepository")
 */
class Topics
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTopics", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtopics;

    /**
     * @var string
     *
     * @ORM\Column(name="topics", type="string", length=25, nullable=false)
     */
    private $topics;

    /**
     * @var \Categoriesforum
     *
     * @ORM\ManyToOne(targetEntity="Categoriesforum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategorie", referencedColumnName="idCategorie")
     * })
     */
    private $idcategorie;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;

    public function getIdtopics(): ?int
    {
        return $this->idtopics;
    }

    public function getTopics(): ?string
    {
        return $this->topics;
    }

    public function setTopics(string $topics): self
    {
        $this->topics = $topics;

        return $this;
    }

    public function getIdcategorie(): ?Categoriesforum
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?Categoriesforum $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
