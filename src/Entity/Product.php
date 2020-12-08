<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Product
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $info;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $publicDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonLikeProduct", mappedBy="product", orphanRemoval=true)
     */
    private $personLikeProduct;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info): void
    {
        $this->info = $info;
    }

    /**
     * @return mixed
     */
    public function getPublicDate()
    {
        return $this->publicDate;
    }

    /**
     * @param mixed $publicDate
     */
    public function setPublicDate($publicDate): void
    {
        $this->publicDate = $publicDate;
    }

    /**
     * @return mixed
     */
    public function getPersonLikeProduct()
    {
        return $this->personLikeProduct;
    }

    /**
     * @param mixed $personLikeProduct
     */
    public function setPersonLikeProduct($personLikeProduct): void
    {
        $this->personLikeProduct = $personLikeProduct;
    }
}