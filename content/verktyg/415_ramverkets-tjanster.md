Ramverkets tjänster
==========================

Ramverket är uppbyggt av en DI-kontainer som innehåller en samling av tjänster som kan användas generellt i ramverket. Konceptet kallas dependency injection.



Modulen anax/di
------------------------

Du kan studera källkoden bakom [modulen `anax/di` på repot på GitHub](https://github.com/canax/di). Modulen är också [publicerad på packagist](https://packagist.org/packages/anax/di).

Modulen är implementerad enligt [PHP FIG PSR-11](https://www.php-fig.org/psr/psr-11/).



Tjänster i $di
------------------------

Kontainern `$di` initieras som en av de första händelserna i botstrappingen av ramverket. Du kan se hur det ser ut i filen [`htdocs/index.php`](https://github.com/dbwebb-se/ramverk1/blob/master/example/redovisa/htdocs/index.php).

De rader som aktiverar $di ser ut så här.

```php
// Add all framework services to $di
$di = new Anax\DI\DIFactoryConfig();
$di->loadServices(ANAX_INSTALL_PATH . "/config/di");
```

Tjänsterna är _lazy loading_ vilket innebär att de ligger vilande tills de aktiveras och används.



Tjänster i $di
------------------------

När $di skapas så laddas tjänsterna via konfigurationsfiler som ligger i `config/di`. Varje tjänst som laddas in i $di har en konfigurationsfil som definierar tjänsten.

I konfigurationsfilen finns också, eller kan finnas, en sekvens av kod som körs när tjänsten aktiveras. Där är det till exempel normalt att tjänsten kan konfigurera sig självt genom att läsa in specifika konfigurationsfiler från `config/` katalogen.
