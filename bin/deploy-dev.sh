#!/bin/bash

set -ex

CONTAINER_USER="sail"
COMPOSE_CMD="/usr/local/bin/docker-compose -f docker-compose.cloud.yml"
EXEC_CMD="$COMPOSE_CMD exec -T --user $CONTAINER_USER app"

# Build image and (re)create containers
$COMPOSE_CMD up -d --force-recreate --build --pull always

# Deploy app
$EXEC_CMD npm install
$EXEC_CMD ./artisan down --render="maintenance"
$EXEC_CMD composer install --optimize-autoloader
$EXEC_CMD ./artisan migrate:fresh --seed --force
$EXEC_CMD ./artisan view:clear
$EXEC_CMD ./artisan storage:link
$EXEC_CMD ./artisan google-fonts:fetch
$EXEC_CMD ./artisan icons:clear
$EXEC_CMD ./artisan icons:cache
$EXEC_CMD ./artisan route:cache
$EXEC_CMD ./artisan config:cache
$EXEC_CMD ./artisan up
