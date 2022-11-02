#!/usr/bin/env bash

git fetch --all
git checkout --force "origin/develop"
screen -dmS schedule php artisan schedule:work
screen -dmS queue php artisan queue:work
