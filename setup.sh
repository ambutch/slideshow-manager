#!/usr/bin/env bash

if [[ ! -e ".env" ]]
then
  echo "File .env does not exist, please use .env.dist as a starting point for your configuration"
  exit
fi

# Create DB
/usr/bin/env php bin/console doctrine:database:create

# Create DB structure
/usr/bin/env php bin/console doctrine:migrations:migrate

# Scan directory for files
/usr/bin/env php bin/console app:sync
