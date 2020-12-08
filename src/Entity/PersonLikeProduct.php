<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\PersonLikeProduct
 *
 * @ORM\Entity(repositoryClass="App\Repository\PersonLikeProductRepository")
 * @ORM\Table(name="person_like_product")
 */
class PersonLikeProduct
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="personLikeProduct")
     */
    private $person;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="personLikeProduct")
     */
    private $product;

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param mixed $person
     */
    public function setPerson($person): void
    {
        $this->person = $person;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }
}