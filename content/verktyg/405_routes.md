Routes
==========================

Här finns information om hur du kommer igång att skapa en route och hur du ser vilka routes som är laddade i ramverket.



Modulen anax/router
------------------------

Du kan studera källkoden bakom [modulen `anax/router` på repot på GitHub](https://github.com/canax/router). Modulen är också [publicerad på packagist](https://packagist.org/packages/anax/router).



Konfiguration av routes
------------------------

Man konfigurerar de routes som ramverket svarar på i katalogen `config/router`. 

Alla filerna läses in när ramverket botstrappas. Filerna läses in i ordning de listas i katalogen så namnge dem så att dess innehåll laddas på rätt position i router-kedjan.

Du kan se vilka routes som finns laddade via [dev/router](dev/router).



Exempel på routes
------------------------

Följande routes är konfigurerade i filen `config/router/800_test.php`.

Här finns ett par exempel på routes som ger svar utan att inkludera webbplatsens standardlayout för webbsidor.

* [Say Hi](test/hi)
* [Say No! with a status code of 500](test/no)
* [Say Hi using JSON](test/json)

Följande routes är till för felhantering och används för att visa hur ramverket beteer sig när en routes hanterare kastar ett exception.

* [exception](test/exception) throwing a general exception.
* [403](test/403) throwing a ForbiddenException.
* [404](test/404) throwing a NotFoundException.
* [500](test/500) throwing a InternalErrorException.
