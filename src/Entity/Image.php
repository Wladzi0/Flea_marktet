<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Advertisement::class, inversedBy="images")
     *@ORM\JoinColumn(nullable=false)
     */
    private $advertisement;

    /**
     * @return mixed
     */
    public function getAdvertisement()
    {
        return $this->advertisement;
    }

    /**
     * @param mixed $advertisement
     */
    public function setAdvertisement($advertisement): void
    {
        $this->advertisement = $advertisement;
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
