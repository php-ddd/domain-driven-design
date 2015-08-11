# Command System

When it comes to change the state of an aggregate whether it's an addition, a deletion or a modification,  
it's probably a better idea not to have the same flow as when we read it.
In fact, read access should be as fast as possible. And what is often the slowest part of an application is the data access.
In read process we want to avoid heavy things like join queries.

But let's get back to the purpose of the Command System.

The Command system we suggest you to use is the C part of the Command Query Responsibility Segregation (CQRS) design pattern.
It's the write part of your application.

Requests from your user is transformed into a Plain Old PHP Object, a Command then dispatched through a CommandDispatcher to a CommandHandler that will know how to process it.

Let's decompose this a bit. We have:
- A command with some properties and no logic. In fact Commands contains only public properties (why bother having private with getters and setters if we know what we are doing ?).
- A CommandHandler is a simple class that knows how to handle a Command.
- A CommandDispatcher links Command and CommandHandler so that when a Command appears, the right CommandHandler is called.

## Inside the CommandHandler

What's not in this framework is your domain logic so let's clarify what you should do in a CommandHandler.  
First, get the right aggregate root according to the Command data. If the command is about letting one user making some  
changes in his settings, then the command should probably contain an identification of this user.  
Once you get the aggregate root, then you'll be able to apply the corresponding action by calling the right method in  
the user with the parameters coming from the command.
Now that the aggregate changed, your CommandHandler is able to save the new states of the user.

Note: if you use the Event mechanism, you might also wants to do one of the following:
- add the aggregate roots back to the Command so you will be able to pull the events from outside of the Command world
- or pull events directly from the aggregate root and publish them.

For some example on how to declare a command handler, you might want to have a look at our [tests classes](/tests/Command/Sample).
