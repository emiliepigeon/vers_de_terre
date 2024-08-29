<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)] // Ajout de la propriété slug
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
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

    // Getter pour slug
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    // Setter pour slug
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    // Méthode __toString pour afficher le titre de la catégorie
    public function __toString(): string
    {
        return $this->title ?? 'Catégorie sans titre'; // Retourne le titre ou un message par défaut
    }
}
