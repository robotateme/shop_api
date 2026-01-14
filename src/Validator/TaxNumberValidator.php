<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class TaxNumberValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var TaxNumber $constraint */

        if ($value === null || $value === '') {
            return;
        }

        if (!$this->isValidTaxNumber($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    /**
     * @param $value
     * @return bool
     */
    private function isValidTaxNumber($value): bool
    {
        $pattern = '/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Z]{2}\d{9})$/';

        return preg_match($pattern, $value) === 1;
    }
}
