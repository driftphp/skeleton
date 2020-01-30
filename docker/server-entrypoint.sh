#!/bin/bash

cd /var/www
rm -Rf var
php vendor/bin/server watch 0.0.0.0:8000