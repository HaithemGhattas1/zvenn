<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
 */
class Produits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     * min=4,
     * max=10,
     * minMessage = "nom du produit doit etre au minimum {{ limit }} characters long",
     * minMessage = "nom du produit doit etre au maximum {{ limit }} characters long")
     */

    private $nom_produit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionp;


    /**
     * @ORM\Column(type="blob")
     */
    private $image_produit;

    private $rawPhoto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_image;



    public function getNomimage(): ?string
    {
        return $this->nom_image;
    }

    public function setNomimage(string $nom_image): self
    {
        $this->nom_image = $nom_image;

        return $this;
    }




    public function displayPhoto()
    {
        if(null === $this->rawPhoto) {
            $this->rawPhoto = "data:image/png;base64," . base64_encode(stream_get_contents($this->getimageproduit()));
        }

        return $this->rawPhoto;
    }

    /**
     * @ORM\Column(type="float")
     */
    private $prix_produit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_produit;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getnomproduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): self
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getdescriptionp(): ?string
    {
        return $this->descriptionp;
    }

    public function setDescriptionp(string $descriptionp): self
    {
        $this->descriptionp = $descriptionp;

        return $this;
    }



    public function getimageproduit(File $image = null)
    {
        return $this->image_produit;
    }



    public function setImageProduit($image_produit): self
    {
        $this->image_produit = $image_produit;

        return $this;
    }

    public function getprixproduit(): ?float
    {
        return $this->prix_produit;
    }

    public function setPrixProduit(float $prix_produit): self
    {
        $this->prix_produit = $prix_produit;

        return $this;
    }

    public function getTypeProduit(): ?string
    {
        return $this->type_produit;
    }

    public function setTypeProduit(string $type_produit): self
    {
        $this->type_produit = $type_produit;

        return $this;
    }
}
