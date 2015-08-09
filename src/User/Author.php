<?php

namespace PhpDDD\DomainDrivenDesign\User;

final class Author
{
    /**
     * @var mixed
     */
    public $identifier;

    /**
     * @var string
     */
    public $type;

    /**
     * Do not let user instantiate the class directly.
     * Use static method instead.
     * You can still edit public properties afterwards.
     *
     * @param mixed  $identifier
     * @param string $type
     */
    private function __construct($identifier, $type)
    {
        $this->identifier = $identifier;
        $this->type       = $type;
    }

    /**
     * @param AuthorInterface $author
     *
     * @return Author
     */
    public static function fromObject(AuthorInterface $author)
    {
        return new self($author->getId(), get_class($author));
    }

    /**
     * @return Author
     */
    public static function robot()
    {
        return self::fromObject(new Robot());
    }
}
