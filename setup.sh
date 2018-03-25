#!/usr/bin/env bash

if [[ ! -e ".env" ]]
then
  #TODO fill .env file interactively
  echo "File .env does not exist, please use .env.dist as a starting point for your configuration"
fi

# Create DB
/usr/bin/env php bin/console doctrine:database:create

# Create DB structure
/usr/bin/env php bin/console doctrine:migrations:migrate

# TODO Scan directory for files
#/usr/bin/env php bin/console