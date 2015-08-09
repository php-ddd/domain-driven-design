<?php

namespace PhpDDD\DomainDrivenDesign\Event;

use DateTime;
use PhpDDD\DomainDrivenDesign\User\Author;
use PhpDDD\Utils\PopulatePropertiesTrait;

/**
 * Base class for every event.
 */
abstract class AbstractEvent
{
    use PopulatePropertiesTrait;

    /**
     * @var Author
     */
    public $author;

    /**
     * @var DateTime
     */
    public $date;

    /**
     * @param array $data The list of properties values. The key represent the property name.
     */
    public function __construct(array $data = [])
    {
        // Enforce the date property to be set.
        // Should not rely on the one given by the user.
        $data['date'] = new DateTime();
        $this->populate($data);
    }
}
