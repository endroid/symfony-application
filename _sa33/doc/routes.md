# Routes

Update: route annotations zitten tegenwoordig in symfony/framework

Symfony offers different methods of defining routes. The most popular being the
configuration file (routing.yml) and the annotation (@Route). To make a good
choice I list the advantages of each approach here.

### Advantages of using configuration files

* All routes are available in one overview
* More widely supported than annotations
* Does not require the SensioFrameworkExtraBundle to be installed

### Advantages of using annotations

* Shorter syntax: no need to specify (or update) the action name
* Available in the same file where you define your action
* Deleting an action also deletes the route declaration

## In libraries

In libraries you want to offer a method that is most supported and not require
someone to install SensioFrameworkExtraBundle or write his own routing file to
make it work. So in this scenario I think it is best to go with routing files.

## In this application

In this application the SensioFrameworkExtraBundle is already installed so
there are no real advantages of routing files over annotations anymore but you
can still use both.
