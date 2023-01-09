<?php
namespace App\Entity;
use App\Repository\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: PublisherRepository::class)]
class Publisher {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;
  #[ORM\Column(length: 100)]
  private ?string $name = NULL;

  #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'publishers')]
  private Collection $authors;

  #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'publishers')]
  private Collection $books;

  public function __construct()
  {
      $this->authors = new ArrayCollection();
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
          $author->addPublisher($this);
      }

      return $this;
  }

  public function removeAuthor(Author $author): self
  {
      if ($this->authors->removeElement($author)) {
          $author->removePublisher($this);
      }

      return $this;
  }

  /**
   * @return Collection<int, Book>
   */
  public function getBooks(): Collection
  {
      return $this->books;
  }

  public function addBook(Book $book): self
  {
      if (!$this->books->contains($book)) {
          $this->books->add($book);
      }

      return $this;
  }

  public function removeBook(Book $book): self
  {
      $this->books->removeElement($book);

      return $this;
  }

}
