# Endroid State

# Rules

## Separate view and view data

A view can either be generated client side using view data and React classes
but it should also be possible to create views using Twig. To support most use
cases it is good practice to separate view and view data.

## Data providers, observers and monitors
 
Generation of view data can take place at various moments.

* Directly after changing the state (sync)
    * advantage: handling of success / failure can take place immediately
    * disadvantage: slower because of the need to wait for the update
* Some time later when a process is notified or inspects the state (async)
    * advantage: no need to wait for response
    * disadvantage: no success guaranteed client side
* When the view data is requested
    * advantage: no overhead during insert
    * disadvantage: aggregation of data often consumes much time
    
The ideal system should support all these modes. We will call any of these
variations "state provider". These are intentionally not called "view data
providers" because this data can be used for other than views.

Note that data providers are not necessarily entity managers or repositories as
they could retrieve their data from anywhere and even combine different sources.

## Observers, monitors and the change observer

The processes that observe the data via listeners or regular intervals are not
responsible for providing the data but only for handling changes. Processes
that are notified via events are called "observers" and processes that are run
explicitly (i.e. by invoking a command via cron) are called "monitors". Both
run async to the application thread.

When all observers need to inspect the 

Sometimes you need to create a specific up-to-date view after 

## Support different types of back ends

State data can be stored and read in different ways.

* Single data store for read and write
    * advantage: writes can sometimes be blocking for reads
    * disadvantage: data aggregation takes place upon query and costs time
* Separate data stores for read and write
    * advantage: speed up reads by maintaining a view ready representation
    * disadvantage: added complexity
    
Note that View data is considered redundant. Therefore we should be able to
reliably rebuild it from the central state storage at any point in time.
    
## Central state storage

In the central state store we have several ways to update the central
representation of the state.

* Store all deltas (and derive the represenation when needed)
    * advantage: extremely fast if we don't need the result yet
    * advantage: monitoring changes is easier
    * disadvantage: no real representation to work with
* Maintain a structured representation of the current state
    * advantage: generally more easy to validate and query
    * disadvantage: monitoring processes need to detect what changed
    * disadvantage: takes more time than just storing the delta
* Do both
    * disadvantage: overhead of updating the structured representation
    * advantage: advantages of both

In the last scenario we could even keep the increased performance by having
a separate process that calculates the deltas asynchronously and

## Events vs. deltas

An event triggers some logic anywhere in your application, while a delta is
purely a change in your data structure. In our central data store we only need
the deltas.

@todo build replay mechanism and check if we can handle this purely through
state and ignoring events and commands
 
For instance when a change should result in a mail being sent, the state should
be changed so the application is in the state where a mail should still be sent
(i.e. via a property "shouldSendMail").

## Logging



## Compatibility with React

### Rules

* Make most calls one-direction to keep user interaction fast
    * Separate retrieving view data and updating the state
    * Use loaders to indicate long waiting times

## Example implementation

While each application has its own best solution, my favorite approach is that
where we store each change directly in the structured data structure and use
an asynchronous 

That way structural integrity of the data can be determined immediately.

# Scenarios

Consider the situation where we have a system with tasks, assignees and tags.




## Scenario 1 - Only retrieve tags

Simply because we don't need more in his part of the interface.

* Return all tags without having to return the complete state including all
tasks and assignees.

## Reduce the number of calls to build the state client side

We should be able to retrieve the 

Note: a complete refresh should also reinitialize the state of the application
to make sure the current view does not 

## Never require the complete state to be retrieved at once

In a system with many tasks we don't want to retrieve all tasks and historical
data but only relevant information. This means we should be able to page through
the results or filter on specific criteria.