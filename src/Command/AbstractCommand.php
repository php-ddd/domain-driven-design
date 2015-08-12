<?php

namespace PhpDDD\DomainDrivenDesign\Command;

use PhpDDD\DomainDrivenDesign\Domain\AbstractAggregateRoot;
use PhpDDD\DomainDrivenDesign\User\Author;
use PhpDDD\Utils\PopulatePropertiesTrait;

/**
 * Base class for your Command.
 * The only pre-defined property is the author because we assume that a command will always be triggered
 * by somebody or something. If not set, we'll use the "robot" author.
 *
 * A command is a Plain Old PHP Object. There should be no logic and no business rules.
 *
 * Every properties should be public because data should come from your own application and you should not
 * rely on user data without checking their input.
 * It will be the responsibility of the Aggregate to validate the data coming from the Command.
 */
abstract class AbstractCommand
{
    use PopulatePropertiesTrait;

    /**
     * List of aggregate root impacted by this command.
     * This should be set by the CommandHandler when it get all the aggregate roots according to the command's data.
     * You'll probably manage only one aggregate root per command. It's an array just in case you need more.
     *
     * See CommandHandler for more details on the purpose of this.
     *
     * @var AbstractAggregateRoot[]
     */
    public $aggregateRoots = [];

    /**
     * The command requester.
     * We use the same object type (Author) as for an event in order to keep the track of the Command Requester
     * in the Event ($author).
     *
     * @var Author
     */
    public $requester;

    /**
     * @param array $data An array ['propertyName' => 'value', ...]
     */
    public function __construct(array $data = [])
    {
        $data['requester'] = isset($data['requester']) ? $data['requester'] : Author::robot();
        $this->populate($data);
    }

    /**
     * @param AbstractAggregateRoot $abstractAggregateRoot
     */
    public function addAggregateRoot(AbstractAggregateRoot $abstractAggregateRoot)
    {
        $this->aggregateRoots[] = $abstractAggregateRoot;
    }
}
