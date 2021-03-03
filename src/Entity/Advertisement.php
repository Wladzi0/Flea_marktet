<?php

namespace App\Entity;

use App\Repository\AdvertisementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdvertisementRepository::class)
 */
class Advertisement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Subcategory::class, inversedBy="advertisements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @Gedmo\Timestampable (on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable (on="update")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="advertisement", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="advertisements")
     * @ORM\JoinColumn (nullable=false)
     */
    private  $user;
    /**
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $contactName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="integer", length=9)
     * @Assert\Regex(pattern="/[0-9]/", message="number_only")
     */
    private $telNumber;

    /**
     * @ORM\OneToMany(targetEntity=FavouriteAdvertisement::class, mappedBy="advertisement")
     */
    private $favouriteAdvertisements;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="advertisement")
     */
    private $comments;

    public function __construct() {

        $this->images = new ArrayCollection();
        $this->favouriteAdvertisements = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @param mixed $contactName
     */
    public function setContactName($contactName): void
    {
        $this->contactName = $contactName;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAdvertisement($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAdvertisement() === $this) {
                $image->setAdvertisement(null);
            }
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubcategory(): ?Subcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?Subcategory $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getTelNumber(): ?int
    {
        return $this->telNumber;
    }

    public function setTelNumber(int $telNumber): self
    {
        $this->telNumber = $telNumber;
        return $this;
    }

    public function isFavouritedByUser(User $user): bool
    {
        foreach ($this->favouriteAdvertisements as $favouriteAdvertisement) {
            if($favouriteAdvertisement->getUser() === $user){
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection|FavouriteAdvertisement[]
     */
    public function getFavouriteAdvertisements(): Collection
    {
        return $this->favouriteAdvertisements;
    }

    public function addFavouriteAdvertisement(FavouriteAdvertisement $favouriteAdvertisement): self
    {
        if (!$this->favouriteAdvertisements->contains($favouriteAdvertisement)) {
            $this->favouriteAdvertisements[] = $favouriteAdvertisement;
            $favouriteAdvertisement->setAdvertisement($this);
        }

        return $this;
    }

    public function removeFavouriteAdvertisement(FavouriteAdvertisement $favouriteAdvertisement): self
    {
        if ($this->favouriteAdvertisements->removeElement($favouriteAdvertisement)) {
            // set the owning side to null (unless already changed)
            if ($favouriteAdvertisement->getAdvertisement() === $this) {
                $favouriteAdvertisement->setAdvertisement(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAdvertisement($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAdvertisement() === $this) {
                $comment->setAdvertisement(null);
            }
        }

        return $this;
    }
}
