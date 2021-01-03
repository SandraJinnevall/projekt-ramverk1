Bootstrapping
==========================

Bootstrapping av ramverket innebär den sekvens där ramverket tar emot en request och startar upp sig självt för att hantera den requesten.



En request-cykel i ramverket
------------------------

Du kan se hur en request-cykel ser ut i filen [`htdocs/index.php`](https://github.com/dbwebb-se/ramverk1/blob/master/example/redovisa/htdocs/index.php).

Man kan dela in koden i tre delar, bootstrapping av ramverket och dess tjänster (1) och därefter hantering av requesten (2) och slutligen rendering av svaret på requesten (3).

Det handlar inte om så många rader så vi kan titta på dem här.

Först har vi de delar som är relaterade till bootstrappingen.

```php
/**
 * Bootstrap the framework and handle the request and send the response.
 */

// Were are all the files?
define("ANAX_INSTALL_PATH", realpath(__DIR__ . "/.."));

// Set development/production environment and error reporting
require ANAX_INSTALL_PATH . "/config/commons.php";

// Get the autoloader by using composers version.
require ANAX_INSTALL_PATH . "/vendor/autoload.php";

// Add all framework services to $di
$di = new Anax\DI\DIFactoryConfig();
$di->loadServices(ANAX_INSTALL_PATH . "/config/di");
```

Nu had vi de viktiga sökvägarna på plats, diverse grundinställningar är gjorda och autoloadern är laddad.

Alla ramverkets tjänster är laddade och redo, dock ej nödvändigtvis aktiverade, i tjänstekontainern `$di`.

När ramverket är uppstartat så sker (2) och (3) i en sekvens i följande kod.

```php
// Send the response that the router returns from the route handler
$di->get("response")->send(
    $di->get("router")->handle(
        $di->get("request")->getRoute(),
        $di->get("request")->getMethod()
    )
);
```

Routern hanterar den request som kommer via metoden `$router->handle()` som tar request-metoden och request-urlen som parametrar.

Routern har i sin konfiguration ett antal routes och om någon, eller flera av dem, matchar, så kommer slutligen ett svar i form av text eller en instans av en response-klass.

Svaret renderas med response-klassens `send()`.

Det är allt.

Bootstrap, request, router, hanterare, response.
