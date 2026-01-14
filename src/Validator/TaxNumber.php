<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class TaxNumber extends Constraint
{
    public string $message = 'The string "{{ value }}" contains an illegal characters.';
}
