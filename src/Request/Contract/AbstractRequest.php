<?php

namespace App\Request\Contract;

use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\VarExporter\Hydrator;
use TypeError;

abstract class AbstractRequest
{
    /**
     * @var array<string, mixed>
     */
    protected array $requestData = [];
    /**
     * @var Constraint|null
     */
    protected Constraint|null $constraints = null;

    /**
     * @var array<string, string>
     */
    protected array $errors = [];

    /**
     * @param Request $request
     * @return static
     */
    abstract public static function fromHttpRequest(Request $request): static;

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $validator = Validation::createValidator();
        if (empty($this->requestData)) {
            $reflectionClass = new ReflectionClass($this);
            foreach ($reflectionClass->getProperties() as $reflectionProperty) {
                if ($reflectionProperty->isPublic()) {
                    $this->requestData[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
                }
            }
        }

        if (!$this->constraints) {
            $this->constraints = new Assert\Collection([]);
            $reflectionClass = new ReflectionClass($this);
            foreach ($reflectionClass->getProperties() as $reflectionProperty) {
                if ($reflectionProperty->isPublic()) {
                    $reflectionAttributes = $reflectionProperty->getAttributes();
                    $propertyConstraints = [];
                    foreach ($reflectionAttributes as $reflectionAttribute) {
                        $instance = $reflectionAttribute->newInstance();
                        if ($instance instanceof Constraint) {
                            $propertyConstraints[] = $instance;
                        }
                    }
                    $this->constraints->fields[$reflectionProperty->getName()] = new Assert\Required($propertyConstraints);
                }
            }
        }

        $violations = $validator->validate($this->requestData, $this->constraints);

        if ($violations->count() > 0) {
            $this->setErrorsFromViolations($violations);
            return false;
        }

        try {
            Hydrator::hydrate($this, $this->requestData);
        } catch (TypeError $e) {
            $this->addError('attribute_error', $e->getMessage());
        }



        return true;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @param string $attributeName
     * @param string $errorMessage
     * @return void
     */
    public function addError(string $attributeName, string $errorMessage): void
    {
        $this->errors[$attributeName] = $errorMessage;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return void
     */
    public function setErrorsFromViolations(ConstraintViolationListInterface $errors): void
    {
        foreach ($errors as $error) {
            $this->addError($error->getPropertyPath(), $error->getMessage());
        }
    }
}
