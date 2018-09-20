<?php


namespace App\GraphQL\Exception;


use Overblog\GraphQLBundle\Error\UserErrors;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class AppGraphQLException extends UserErrors
{

    public static function fromString($message): self
    {
        return new self([$message]);
    }

    public static function fromFormErrors(FormInterface $form): self
    {
        return new self(self::getPlainErrors($form));
    }

    public static function fromValidatorErrors(ConstraintViolationListInterface $violationList): self
    {
        $errors = [];

        foreach ($violationList as $error) {
            $errors[] = $error->getMessage();
        }

        return new self($errors);
    }

    public static function getPlainErrors(FormInterface $form)
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors = array_merge($errors, static::getPlainErrors($child));
            }
        }

        return $errors;
    }
}
