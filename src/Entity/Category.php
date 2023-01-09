<?php
namespace App\Entity;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;
  #[ORM\Column(length: 100)]
  private ?string $name = NULL;

  #[ORM\OneToMany(targetEntity: Category::class, mappedBy: "parent")]
  private $subCategories;

  #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: "subCategories")]
  private $parent;

  #[ORM\OneToMany(targetEntity: Book::class, mappedBy:"category")]
  private $books;

  public function __construct() {
    $this->subCategories = new ArrayCollection();
    $this->books = new ArrayCollection();
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getName(): ?string {
    return $this->name;
  }

  public function setName(string $name): self {
    $this->name = $name;
    return $this;
  }

  public function getSubCategories(): Collection
  {
    return $this->subCategories;
  }

  public function addSubCategory(Category $subCategory): self
  {
    if (!$this->subCategories->contains($subCategory)) {
      $this->subCategories[] = $subCategory;
    }

    return $this;
  }

  public function removeSubCategory(Category $subCategory): self
  {
    if ($this->subCategories->contains($subCategory)) {
      $this->subCategories->removeElement($subCategory);
    }

    return $this;
  }

}
