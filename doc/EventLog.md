# Event Log

The Event Log use the tools we already defined (Domain, Event) to store all the events triggered in the application.  
You can see it as a partial example of how to implement a Bounded Context.

## What's included
* an aggregate ([EventLog](/src/EventLog/EventLog.php))
* an event subscriber ([LogAllEvents](/src/EventLog/EventSubscriber/LogAllEvents.php))
* a repository ([EventLogRepositoryInterface](/src/EventLog/Repository/EventLogRepositoryInterface.php))

## How to use it ?

First implement the repository.
Ex:

```php

use PhpDDD\DomainDrivenDesign\EventLog\EventLog;
use PhpDDD\DomainDrivenDesign\EventLog\Repository\EventLogRepository;

class EventLogRepository implements EventLogRepositoryInterface
{
    const FILE = '/tmp/events.log';

    public function save(EventLog $eventLog)
    {
        // here we choose to save it in a file
        file_put_contents(self::FILE, serialize($eventLog), FILE_APPEND);
    }
    
    /**
     * You might want to add your own method.
     * For instance, the load method is not used in the domain but you will probably need it.
     */
    public function load($eventLogId)
    {
        if (!file_exists(self::FILE)) {
            throw new Exception('There is no event log with the id given');
        }

        $eventLogs = file(self::FILE);
        
        if (count($eventLogs) < $eventLogId) {
            throw new Exception('There is no event log with the id given');
        }
        
        return unserialize($eventLogs[$eventLogId - 1]);
    }
}
```

Then add the LogAllEvents subscriber to the EventDispatcher

```php
$eventDispatcher = /* ... */;

$repository = new EventLogRepository();
$eventDispatcher->subscribe(new LogAllEvents($repository));

// Now each time an event is published in the event dispatcher, it will be saved in the file /tmp/events.log
```
