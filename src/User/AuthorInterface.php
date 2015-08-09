<?php

namespace PhpDDD\DomainDrivenDesign\User;

interface AuthorInterface
{
    /**
     * @return mixed The identifier of the author
     */
    public function getId();
}
