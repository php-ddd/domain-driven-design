<?php

namespace PhpDDD\DomainDrivenDesign\User;

final class Robot implements AuthorInterface
{
    /**
     * @return null A robot does not have an identifier.
     */
    public function getId()
    {
        return;
    }
}
