<?php

namespace App\Entity;

use App\Repository\FavouriteAdvertisementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavouriteAdvertisementRepository::class)
 */
class FavouriteAdvertisement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Advertisement::class, inversedBy="favouriteAdvertisements")
     */
    private $advertisement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favouriteAdvertisements")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdvertisement(): ?Advertisement
    {
        return $this->advertisement;
    }

    public function setAdvertisement(?Advertisement $advertisement): self
    {
        $this->advertisement = $advertisement;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
