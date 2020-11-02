<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="idCategorie", columns={"idCategorie"}), @ORM\Index(name="idAdmin", columns={"idAdmin"})})
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="idArticle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idarticle;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=25, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=25, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=25, nullable=false)
     */
    private $thumbnail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date", nullable=false)
     */
    private $created;

    /**
     * @var \Administrator
     *
     * @ORM\ManyToOne(targetEntity="Administrator")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAdmin", referencedColumnName="idAdmin")
     * })
     */
    private $idadmin;

    /**
     * @var \Categoriesarticle
     *
     * @ORM\ManyToOne(targetEntity="Categoriesarticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategorie", referencedColumnName="idCategorie")
     * })
     */
    private $idcategorie;

    public function getIdarticle(): ?int
    {
        return $this->idarticle;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getIdadmin(): ?Administrator
    {
        return $this->idadmin;
    }

    public function setIdadmin(?Administrator $idadmin): self
    {
        $this->idadmin = $idadmin;

        return $this;
    }

    public function getIdcategorie(): ?Categoriesarticle
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?Categoriesarticle $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }


}
