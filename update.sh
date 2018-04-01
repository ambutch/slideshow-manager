#!/usr/bin/env bash

git pull origin master

# Create DB structure
/usr/bin/env php bin/console doctrine:migrations:migrate

# Scan directory for files
/usr/bin/env php bin/console app:republish
