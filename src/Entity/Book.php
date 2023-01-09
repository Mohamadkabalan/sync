<?php
namespace App\Entity;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;
  #[ORM\Column(length: 255)]
  private ?string $title = NULL;

  #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
  private Collection $authors;

  #[ORM\ManyToMany(targetEntity: Publisher::class, mappedBy: 'books')]
  private Collection $publishers;


  #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: "books")]
  #[ORM\JoinColumn(nullable: false)]
  private $category;

  public function __construct()
  {
      $this->authors = new ArrayCollection();
      $this->publishers = new ArrayCollection();
  }


  public function getId(): ?int {
    return $this->id;
  }

  public function getTitle(): ?string {
    return $this->title;
  }

  public function setTitle(string $title): self {
    $this->title = $title;
    return $this;
  }

  /**
   * @return Collection<int, Author>
   */
  public function getAuthors(): Collection
  {
      return $this->authors;
  }

  public function addAuthor(Author $author): self
  {
      if (!$this->authors->contains($author)) {
          $this->authors->add($author);
          $author->addBook($this);
      }

      return $this;
  }

  public function removeAuthor(Author $author): self
  {
      if ($this->authors->removeElement($author)) {
          $author->removeBook($this);
      }

      return $this;
  }

  /**
   * @return Collection<int, Publisher>
   */
  public function getPublishers(): Collection
  {
      return $this->publishers;
  }

  public function addPublisher(Publisher $publisher): self
  {
      if (!$this->publishers->contains($publisher)) {
          $this->publishers->add($publisher);
          $publisher->addBook($this);
      }

      return $this;
  }

  public function removePublisher(Publisher $publisher): self
  {
      if ($this->publishers->removeElement($publisher)) {
          $publisher->removeBook($this);
      }

      return $this;
  }

}
