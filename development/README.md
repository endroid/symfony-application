# Symfony Application

## Development guidelines



# Domain

The core of the application. Any other layer can connect with the domain but
the domain itself does not connect to outer layers. Instead it should depend
on abstractions like interfaces which are implemented by outer layers.

* Entities
* Entity repositories (interface)

# Application

The application layer contains all commands and command handlers. These
commands should only contain primitive type values to make commands can be used
in different locations in the application and logic is encapsulated.

* Commands
* Command handlers

# Infrastructure

The infrastructure connects the application to the outside world. It makes sure
HTTP requests are transformed to commands, data is persisted by implementing
the repository interfaces. Further it handles things like sending mails and
sending data to external systems.

* Controllers
* Command and query bus
* Entity repositories (ORM)
