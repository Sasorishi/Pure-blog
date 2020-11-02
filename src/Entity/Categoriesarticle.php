<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoriesarticle
 *
 * @ORM\Table(name="categoriesArticle")
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesArticleRepository")
 */
class Categoriesarticle
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCategorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=25, nullable=false)
     */
    private $label;

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }


}
