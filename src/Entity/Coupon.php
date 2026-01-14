<?php

namespace App\Entity;

use App\Enum\CouponTypesEnum;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\Column(enumType: CouponTypesEnum::class)]
    private ?CouponTypesEnum $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?CouponTypesEnum
    {
        return $this->type;
    }

    public function setType(CouponTypesEnum $type): static
    {
        $this->type = $type;

        return $this;
    }
}
