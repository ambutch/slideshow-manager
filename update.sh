#!/usr/bin/env bash

git pull origin master

# Create DB structure
bin/console doctrine:migrations:migrate

# Scan directory for files
bin/console app:republish

bin/console cache:clear