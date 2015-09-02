<?php

namespace PhpDDD\DomainDrivenDesign\Event;

use DateTime;
use PhpDDD\DomainDrivenDesign\Command\AbstractCommand;
use PhpDDD\DomainDrivenDesign\Domain\AbstractAggregateRoot;
use PhpDDD\DomainDrivenDesign\User\Author;
use PhpDDD\Utils\PopulatePropertiesTrait;
use Serializable;

/**
 * Base class for every event.
 */
abstract class AbstractEvent implements Serializable
{
    use PopulatePropertiesTrait;

    /**
     * Get the aggregate root from which is the event is triggered.
     *
     * @var AbstractAggregateRoot
     */
    public $aggregateRoot;

    /**
     * @var Author
     */
    public $author;

    /**
     * @var DateTime
     */
    public $date;

    /**
     * Get commands to execute after dispatch event.
     *
     * @var AbstractCommand[]
     */
    public $commands = [];

    /**
     * @param array $data The list of properties values. The key represent the property name.
     */
    public function __construct(array $data = [])
    {
        // Enforce the date property to be set.
        // Should not rely on the one given by the user.
        $data['date']   = new DateTime();
        $data['author'] = isset($data['author']) ? $data['author'] : Author::robot();
        $this->populate($data);
    }
}
