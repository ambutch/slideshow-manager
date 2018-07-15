#!/usr/bin/env bash

# Server
java -jar bin/swagger-codegen-cli.jar generate -l php-symfony -c server_api_config.json -o bundles/ -i api.swagger.yaml

sed -i -e 's/services:/services:\n    _defaults: { public: true }\n/g' bundles/SymfonyBundle-php/Resources/config/services.yml
sed -i -e 's/Api\\Api\\/Api\\/g' bundles/SymfonyBundle-php/Resources/config/services.yml
sed -i -e 's/class: %api.serializer%/class: "%api.serializer%"/g' bundles/SymfonyBundle-php/Resources/config/services.yml
sed -i -e 's/class: %api.validator%/class: "%api.validator%"/g' bundles/SymfonyBundle-php/Resources/config/services.yml

sed -ri 's/@(var|return|param)([[:space:]]+)Api/@\1\2\\Api/g' bundles/SymfonyBundle-php/*Interface.php
sed -ri 's/@(var|return|param)([[:space:]]+)Api/@\1\2\\Api/g' bundles/SymfonyBundle-php/Controller/*.php
sed -ri 's/@(var|return|param)([[:space:]]+)Api/@\1\2\\Api/g' bundles/SymfonyBundle-php/Model/*.php

sed -ri 's/(@return[[:space:]]+\\Api\\Model\\[[:alnum:]]+)\[\]/\1/g' bundles/SymfonyBundle-php/*Interface.php

sed -ri 's/^([[:space:]]+_controller:[[:space:]]+)([^:]+):([[:alnum:]]+)/\1\2::\3/g' bundles/SymfonyBundle-php/Resources/config/routing.yml

git add bundles/SymfonyBundle-php

composer dump

#Client
java -jar bin/swagger-codegen-cli.jar generate -l typescript-angular -c client_api_config.json -o frontend/src/api -i api.swagger.yaml

git add frontend/src/api