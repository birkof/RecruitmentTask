<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\PlatformType;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 * @UniqueEntity(fields="application_id", message="Application is already taken.")
 */
class Offer
{
    //region Properties
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="application_id", type="string", unique=true, nullable=false)
     */
    private $applicationId;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=3, nullable=false)
     */
    private $country;

    /**
     * @var float
     *
     * @ORM\Column(name="payout", type="decimal", scale=2, nullable=false)
     */
    private $payout;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var PlatformType
     *
     * @ORM\Column(name="platform", type="PlatformType", nullable=false)
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\PlatformType")
     */
    private $platform;
    //endregion

    //region Getters, Setters & Issers

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Offer
     */
    public function setId(int $id): Offer
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return empty($this->id);
    }

    /**
     * @return string
     */
    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    /**
     * @param string $applicationId
     *
     * @return Offer
     */
    public function setApplicationId(string $applicationId): Offer
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return Offer
     */
    public function setCountry(string $country): Offer
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return float
     */
    public function getPayout(): float
    {
        return $this->payout;
    }

    /**
     * @param float $payout
     *
     * @return Offer
     */
    public function setPayout(float $payout): Offer
    {
        $this->payout = $payout;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Offer
     */
    public function setName(string $name): Offer
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     *
     * @return Offer
     */
    public function setPlatform(string $platform): Offer
    {
        $this->platform = $platform;

        return $this;
    }
    //endregion
}
