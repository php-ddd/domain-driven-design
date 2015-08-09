# Eventing System

As Greg Young (and many others) says: "An event is something that happened, it's in the past".

The Event system allows you to act on what happened on your application.  
It is thrown by the Domain (Aggregate roots).
 
It has many uses:
* send an email to a user when he subscribes to your website
* log every things that happened to your application
* do something on other aggregate roots when another BoundedContext changes its states
* ...

The main advantages over classic development is that everything is bound to something inside your Domain application.  


## How it works

1. Configuring the EventDispatcher
  1. Create an Event class (extending [`PhpDDD\DomainDrivenDesign\Event\AbstractEvent`](/src/Event/AbstractEvent.php)) - [example](tests/Event/Sample/TestEvent.php)
  2. Create an EventSubscriber (implementing [`PhpDDD\DomainDrivenDesign\Event\EventSubscriberInterface`](/src/Event/EventSubscriberInterface.php)) - [example](tests/Event/Sample/TestEventSubscriber.php)
  3. Attach your EventSubscriber to the EventDispatcher (you may need to instantiate it)
2. Publishing
  1. instantiate your Event
  2. publish it (`$eventDispatcher->publish(new Event());`)

