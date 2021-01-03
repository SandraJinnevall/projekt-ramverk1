Scaffolding
==========================

Scaffolding handlar om att generera källkod, moduler och/eller kompletta installationer av en programvara. Det handlar om att automatisera sånt man gör ofta.

Exempelkatalogen `example/redovisa` är scaffoldad fram.



Scaffolda ramverk1-me-v2
--------------------------

Så här kan du själv scaffolda en version av den webbplats som ligger på `example/redovisa`. Du kan göra det för att testa hur det fungerar och bekanta dig med processen för scaffolding.

Först kollar vi detaljer om den template som används för att scaffolda webbplatsen.

```text
anax list ramverk1-me-v2 
```

Sedan kan vi scaffolda en webbplats baserat på den templaten till katalogen `redovisa2`.

```text
anax create redovisa2 ramverk1-me-v2 
```

När processen är klar kan du öppna webbläsaren mot `redovisa2/htdocs`.
