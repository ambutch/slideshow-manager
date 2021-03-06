#!/usr/bin/env bash

if [[ ! -e ".env" ]]
then
  echo "File .env does not exist, please use .env.dist as a starting point for your configuration"
  exit
fi

composer install

# Create DB
bin/console doctrine:database:create

# Create DB structure
bin/console doctrine:migrations:migrate

# Scan directory for files
bin/console app:sync

# Build the frontend
cd frontend
ng build
cd ..