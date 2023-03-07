#!/bin/bash
set -e

echo "Deployment started ..."

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "Deployment finished!"
