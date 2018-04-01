#!/usr/bin/env bash

git pull origin master

# Create DB structure
bin/console doctrine:migrations:migrate

bin/console cache:clear

# Scan directory for files
bin/console app:republish