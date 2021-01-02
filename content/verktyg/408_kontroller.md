Kontroller
==========================

En kontroller är en speciell hanterare till en route. Det handlar om att montera en kontroller-klass på en monteringspunkt och alla routes under denna monteringspunkt kommer att dirigeras till kontrollerklassen som sedan kan välja om den vill hantera routen, eller inte.

Du kan se vilka routes som finns laddade via [dev/router](dev/router).



Exempel på routes med kontroller
------------------------

I filen `config/router/800_test.php` finns en router definerad som hanteras av ett exempel på en mer komplett kontroller-klass.

Konfigurationen av routern som matchas av kontroller-klassen ser ut så här.

```php
[
    "info" => "Sample controller.",
    "mount" => "controller",
    "handler" => "\Anax\Controller\SampleController",
],
```

Du kan studera källkoden till klassen i filen `src/Controller/SampleController`, antingen i din egen installation eller via [kursrepot på GitHub](https://github.com/dbwebb-se/ramverk1/blob/master/example/redovisa/src/Controller/SampleController.php).

Du kan testa dess routes här, de är monterade på `test/controller`.

* [controller/](test/controller) (the index action)
* [controller/dump-di](test/controller/dump-di) (dump content of \$di)
* [controller/info](test/controller/info)
* [controller/create](test/controller/create)
* [controller/argument/some-value](test/controller/argument/some-value) (method takes one argument)

These two routes are handled by the same method which accepts zero or one argument (using default value for the argument).

* [controller/default-argument](test/controller/default-argument) (no argument)
* [controller/default-argument/some-value](test/controller/default-argument/some-value) (one argument)

This action method takes two arguments where the second argument should be an integer.

* [controller/typed-argument/some-value/42](test/controller/typed-argument/some-value/42) (typed arguments)

Here is a action method taking a variadic parameter and can then take any amount of arguments.

* [controller/variadic](test/controller/variadic) (zero arguments)
* [controller/variadic/one](test/controller/variadic/one) (one arguments)
* [controller/variadic/one/two](test/controller/variadic/one/two) (two arguments)
* [controller/variadic/one/two/3](test/controller/variadic/one/two/3) (three arguments)
