[![Build Status](https://travis-ci.com/SandraJinnevall/projekt-ramverk1.svg?branch=main)](https://travis-ci.com/SandraJinnevall/projekt-ramverk1)
[![CircleCI](https://circleci.com/gh/SandraJinnevall/projekt-ramverk1.svg?style=svg)](https://app.circleci.com/pipelines/github/SandraJinnevall/projekt-ramverk1)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SandraJinnevall/projekt-ramverk1/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/SandraJinnevall/projekt-ramverk1/?branch=main)

Checka ut och installera din egna version.
===================================

**Ladda ner mappen genom att trycka på den gröna "Code" knappen**

Stå i roten på din nya mapp. 
Kör följande kommandon först:

    composer install
    chmod 777 cache/*
    make install

Kör följande kommandon för att instrallera anax- textfilter, htmlfrom och database-active-record:

    composer require anax/textfilter
    composer require anax/htmlform
    composer require anax/database-active-record
    
Kör följande kommandon för att få igång databasen:

    chmod 777 data
    sqlite3 data/db.sqlite # gör exit via ctrl-d direkt
    chmod 666 data/db.sqlite
    sqlite3 data/db.sqlite < sql/ddl/user_sqlite.sql

**Nu ska projektet funka på din dator.**

Mappens struktur
===================================

Det finns några filer/mappar som är viktiga att hålla koll på för att man ska förstå projektets-uppbyggnad.

**config/di/forumDatabase.php** innehåller våra tabeller från databasen. Den här filen gör det enkelt för oss att kalla på en tabell genom tex 

    $this->di->get("userdatabase");

**config/router/100_user-controller** och **config/router/100_forum-controller** innehåller våra routes som i sin tur kör våra kontroller i src-mappen.

    src/QandA/User/UserController.php
    src/QandA/Forum/ForumController.php

**src/QandA/Forum/** och **src/QandA/User/** innehåller klasser samt HTMLForm som skapar endel av våra formulärer. 

**view/forum/** innehåller våra view-filer som visas på sidan.

**sql/ddl/user_sqlite.sql** innehåller vår databas med alla tabeller.
