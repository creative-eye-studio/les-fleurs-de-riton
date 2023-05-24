<?php

namespace App\Entity;

use App\Repository\ServicesImagesRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesImagesRepository::class)]
class ServicesImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'servicesImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Services $serv_id = null;

    #[ORM\Column(length: 255)]
    private ?string $img_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServId(): ?Services
    {
        return $this->serv_id;
    }

    public function setServId(?Services $serv_id): self
    {
        $this->serv_id = $serv_id;

        return $this;
    }

    public function getImgName(): ?string
    {
        return $this->img_name;
    }

    public function setImgName(string $img_name): self
    {
        $this->img_name = $img_name;

        return $this;
    }
}
