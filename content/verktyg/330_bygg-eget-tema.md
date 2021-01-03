Bygg eget tema
=========================

I din redovisa/ finns en katalog `theme/` som innehåller grunden för det tema som används på dbwebb.se. Du kan välja att jobba med det temat och anpassa det till din webbplats.

När vi säger tema så motsvarar det i sammanhanget namnet på en stylesheet.



Installera utvecklingsmiljön för temat
-------------------------

Tema-katalogen `theme/` är en kopia av repot [`desinax/theme-dbwebb.se`](https://github.com/desinax/theme-dbwebb.se)

För att kompilera temat behöver du installera en utvecklingsmiljö i katalogen, du gör så här.

```text
cd theme
make install
```

Stöd för att jobba med temat finns via Makefilen och make. Skriv kommandot `make` för att se vad du kan göra.

```text
make
```



Bygg temat i theme/
-------------------------

I katalogen `theme/` kan du bygga (kompilera) temat med följande kommando.

```text
# Stå i katalogen theme/
make build
```

Från källkoden i `src/` genereras stylesheets som byggs i katalogen `build/` och slutligen, när kompileringen gått igenom, så placeras resultatet i `htdocs/css/`.

Det genereras en fil `.css` och en minifierad variant som döps till `.min.css`.



Bygg temat redovisa/
-------------------------

Din makefil i `redovisa/` har ett target som bygger ditt tema och kopierar de kompilerade stylesheeten till `redovisa/htdocs/css` så att de kan användas direkt.

Så här bygger du temat direkt i din redovisa.

```text
# Stå i katalogen redovisa/
make theme
```

Makefilen går in i katalogen `theme/` och kör `make build` och om det går bra så kopieras filerna från `theme/htdocs/css` till `htdocs/css`.

Du kan aktivera stylen via [styleväljaren](style).



Skapa eget tema
-------------------------

Temats huvudsakliga stylesheet(s) finns i `theme/src/[temafil].less`. Du kan lägga till egna stylesheets genom att lägga till nya filer överst i katalogen `theme/src`.

Katalogen `theme/src` innehåller underkataloger där det finns less-moduler som kan inkluderas i temat.

Du kan skapa nya tema-filer, till exempel `src/temafil1.less` och `src/temafil2.less`.



Välj standard stylesheet i webbplatsen
-------------------------

Du kan välja ditt eget tema som standard style i din webbplats genom att redigera `config/page.php`.
