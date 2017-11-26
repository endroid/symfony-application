# Tests

The application provides many kinds of tests and checks to improve the quality
and stability of the application. For each tagged version [Travis CI](https://travis-ci.org/endroid/symfony-application)
is used to create a build and perform all tests and checks.

You can run all tests and checks locally by executing the following command.

```
./check.sh
```

## Functional tests

These are performed using [Behat](http://behat.org/en/latest/) and include at
least some basic tests like visiting home, logging in and using the API. On top
of Behat we use a [Selenium](http://www.seleniumhq.org/) hub with a Chrome and
a Firefox node to run in-browser tests.

## Unit tests

Unit tests are written using [PHPUnit](https://phpunit.de/).

## Additional checks

Further we use [SensioLabs Security Checker](https://security.sensiolabs.org/)
to see if there are security issues, make sure the coding standards comply using
the [PHP Coding Standards Fixer](http://cs.sensiolabs.org/). And finally we use
Page Speed Insights to check the performance of the application.