<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Dto\SendQuoteDto;


/**
 * This is a dummy entity. Remove it!
 *
 * @ApiResource(
 *     paginationClientEnabled=true,
 *     denormalizationContext={"groups"={"Quote_write"}},
 *     normalizationContext={"groups"={"Quote_read"}},
 *     itemOperations={"GET", "PUT",
 *     "send_to_dom"={"input"=SendQuoteDto::class, "method"="PATCH", "output"=false, "status"=202, "path"="/quotes/{id}/sendToDom"},
 *     },
 *     collectionOperations={"GET"={"normalization_context"={"groups"={"quote_list"}}},
 *          "POST"}
 *  )
 * @ApiFilter(SearchFilter::class, properties={"value":"ipartial"})
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity()
 *
 */
class Quote
{
    /**
     * @var int The entity Id
     * @ORM\GeneratedValue()
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @Groups({"Quote_read"})
     *
     */
    private $id;
    /**
     * @ORM\Column(type="string", nullable=false)
     * @Groups({"Quote_write", "Quote_read", "quote_list"})
     * @Groups({"owner_read"})
     */
    private $value;
    /**
     * @ORM\ManyToOne(targetEntity="Owner", inversedBy="quotes")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false)
     * @Groups({"Quote_write", "Quote_read"})
     */
    private $owner;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner(?Owner $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


}
