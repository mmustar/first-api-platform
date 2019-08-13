<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Owner
 * @package App\Entity
 * @ORM\Entity
 * @ApiResource(
 *     accessControl="is_granted('ROLE_USER')",
 *     itemOperations={"GET"={"normalization_context"={"groups"={"owner_read"} }},
 *                          "PUT"},
 *     collectionOperations={"GET"={"access_control"="is_granted('ROLE_USER')"},
 *              "POST"={"denormalization_context"={"groups"={"owner_write"} }}},
 * )
 */
class Owner implements UserInterface
{
    /**
     * @ORM\GeneratedValue()
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @Groups({"owner_read"})
     */
    private $id;
    /**
     *
     * @ORM\Column(type="string", nullable=false)
     * @Groups({"owner_read", "owner_write"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Quote", mappedBy="owner")
     * @Groups({"owner_read"})
     * @ApiSubresource()
     */
    private $quotes;

    /**
     * Owner constructor.
     */
    public function __construct()
    {
        $this->quotes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    /**
     * @param mixed $quotes
     */
    public function addQuote(Quote $quote): void
    {
        if(!$this->quotes->contains($quote)) {
            $quote->setOwner($this);
            $this->quotes->add($quote);
        }
    }

    public function removeQuote(Quote $quote)
    {
        $this->quotes->removeElement($quote);
        $quote->setOwner(null);
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @param mixed $quotes
     */
    public function setQuotes($quotes): void
    {
        $this->quotes = $quotes;
    }


    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return '$argon2i$v=19$m=65536,t=4,p=1$UnJpZEhDLjhnQkxiUHJodg$08iYncY22Gxbpoti0WSEnE6rRcv0sejA7rH27OiBCwk';
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getName();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}