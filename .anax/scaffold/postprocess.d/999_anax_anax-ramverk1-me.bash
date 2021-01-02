#!/usr/bin/env bash
#
# anax/anax-ramverk1-me
#

# Include functions.bash
source .anax/scaffold/functions.bash

# # Set default build files
# cp vendor/anax/anax-ramverk1-me/.travis_default.yml .travis.yml
# cp vendor/anax/anax-ramverk1-me/.circleci/config_default.yml .circleci/config.yml

# Get/remove items from config/.
rsync -a vendor/anax/anax-ramverk1-me/config ./
rm -f config/navbar.php

# Get items from content/.
rsync -a vendor/anax/anax-ramverk1-me/content ./

# Remove items from content/.
rm -f content/{about,test}.md

# Get items from htdocs/.
rsync -a vendor/anax/anax-ramverk1-me/htdocs ./
rm htdocs/css/style.css

# Get/remove items from src/.
rsync -a vendor/anax/anax-ramverk1-me/src ./

# Copy the source for Controllers.
rsync -a vendor/anax/controller/src/Controller/{Development,ErrorHandler,FlatFileContent,Sample,SampleJson}Controller.php ./src/Controller/

# Add test for controllers
rsync -a vendor/anax/anax-ramverk1-me/test_sample/ ./test/

# Copy the source for Page.
rsync -a vendor/anax/page/src/Page/Page.php ./src/Page/

# Get the Makefile.
rsync -a vendor/anax/anax-ramverk1-me/Makefile ./

# Get own copy of view files.
rsync -a vendor/anax/view/view/anax/v2 ./view/anax/
rsync -a vendor/anax/anax-ramverk1-me/view ./

# Change baseTitle
sedi "s/ | Anax/ | ramverk1/g" config/page.php

# Remove htdocs/cimage/index.html to ease debugging
rm -f htdocs/cimage/index.html

# Get configuration for the cache.
# @TODO Move this to Anax Flat.
rsync -a vendor/anax/cache/config ./

# Get configuration for the flat file content.
# @TODO Move this to Anax Flat.
rsync -a vendor/anax/content/config ./
