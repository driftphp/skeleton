#!/bin/bash

cd /var/www/app
rm -Rf var
php vendor/bin/server run 0.0.0.0:8000