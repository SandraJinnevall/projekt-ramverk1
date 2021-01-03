Skapa en egen kontroller
==========================

I din installation finns en styleväljare som är definierad som en kontroller-klass. Du kan utgå från dess upplägg om du vill skapa en egen kontroller-klass.



Styleväljaren som kontroller
------------------------

Styleväljaren laddas som en route via filen `config/router/400_style-chooser.php`.

Det ser ut ungefär så här.

```php
return [
    "routes" => [
        [
            "info" => "Style chooser.",
            "mount" => "style",
            "handler" => "\Anax\StyleChooser\StyleChooserController",
        ],
    ]
];
```

Monteringspunkten är `style/` och kontrollerklassen är `\Anax\StyleChooser\StyleChooserController`.

Baserat på det upplägget kan du lägga till egna kontrollerklasser som route-hanterare.



Inkludera ramverkets standardsida i svaret
------------------------

Alla sidor som genereras utifrån markdown-data i katalogen `content`, och de andra kontroller som så väljer, kan använda sig av ramverkets standardlayout för en webbsida.

Grunden för standardlayouten är konfigurerad i `config/page.php` och utgörs av en sidlayout samt de vyer som adderas.

Man använder sedan denna grunduppsättning via klassen `Anax\Page\Page` som är laddad som en ramverkstjänst i `$di->get("page")`.

Som ett exempel kan vi studera delar av källkoden i styleväljaren för dess index-metod `indexAction()`.

```php
public function indexAction() : object
{
    $page->add("anax/stylechooser/index", $data);

    return $page->render([
        "title" => $title,
    ]);
}
```

Ovan kod lägger till en vy i en region och därefter returneras svaret via `$page->render()`.

Det handlar om att lägga till de vyer man vill ha, i de regioner som sidan har stöd för, och sedan returnera det renderade svaret.

Du kan studera, och modifiera, upplägget för klassen `Anax\Page\Page` då den ligger som en kopia i din katalog `src/Page/Page.php`.
