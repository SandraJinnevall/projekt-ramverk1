Tjänster i en kontroller
==========================

Följande visar hur en kontroller-klass blir injectad med tjänstekontainern `$di` så att alla ramverkets tjänster kan användas i kontrollern.



Dependency injection
------------------------

Kontainern `$di` blir automatiskt injectad av routern in i alla kontroller-klasser som implementerar interfacet [`Anax\Commons\ContainerInjectableInterface`](https://github.com/canax/commons/blob/master/src/Commons/ContainerInjectableInterface.php).

Enklaste sättet att implementera det interfacet är via traitet [`Anax\Commons\ContainerInjectableTrait`](https://github.com/canax/commons/blob/master/src/Commons/ContainerInjectableTrait.php).

Därför ser många kontroller ut så här i inledningen, se specifikt hur interfacet och traitet används.

```php
namespace Anax\StyleChooser;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * Style chooser controller loads available stylesheets from a directory and
 * lets the user choose the stylesheet to use.
 */
class StyleChooserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
```

Routern känner själv av, via reflection, att kontrollern vill bli injectad med `$di` och anropar den metod `setDI()` som interfacet och traitet etablerar i kontrollerklassen. 

När man sedan är i kontrollerklassen kommer man åt DI-kontainern via `$this->di`.



Att nå ramverkets tjänster vi $di
------------------------

I inledningen av styleväljarens metod `indexAction()` ser vi hur man väljer att hämta ett par av ramverkets tjänster och lagra dem i variabler för att enklare accessa dem upprepade gånger i samma metod.

```php
public function indexAction() : object
{
    $page = $this->di->get("page");
    $session = $this->di->get("session");
```
