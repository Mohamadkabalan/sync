<?php
namespace App\Entity;
use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;
  #[ORM\Column(length: 100)]
  private ?string $name = NULL;

  #[ORM\ManyToMany(targetEntity: Publisher::class, inversedBy: 'authors')]
  private Collection $publishers;

  #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'authors')]
  private Collection $books;

  public function __construct()
  {
      $this->publishers = new ArrayCollection();
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
      }

      return $this;
  }

  public function removePublisher(Publisher $publisher): self
  {
      $this->publishers->removeElement($publisher);

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
