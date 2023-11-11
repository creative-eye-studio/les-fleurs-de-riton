<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?int $pos = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'serv_id', targetEntity: ServicesImages::class)]
    private Collection $servicesImages;

    public function __construct()
    {
        $this->servicesImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPos(): ?int
    {
        return $this->pos;
    }

    public function setPos(int $pos): self
    {
        $this->pos = $pos;

        return $this;
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

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, ServicesImages>
     */
    public function getServicesImages(): Collection
    {
        return $this->servicesImages;
    }

    public function addServicesImage(ServicesImages $servicesImage): self
    {
        if (!$this->servicesImages->contains($servicesImage)) {
            $this->servicesImages->add($servicesImage);
            $servicesImage->setServId($this);
        }

        return $this;
    }

    public function removeServicesImage(ServicesImages $servicesImage): self
    {
        if ($this->servicesImages->removeElement($servicesImage)) {
            // set the owning side to null (unless already changed)
            if ($servicesImage->getServId() === $this) {
                $servicesImage->setServId(null);
            }
        }

        return $this;
    }
}
