#!/usr/bin/env bash

git fetch --all
git checkout --force "origin/develop"
screen -XS horizon_fintech quit
screen -XS queue_fintech quit
screen -dmS schedule_fintech php artisan schedule:work
screen -dmS horizon_fintech php artisan horizon
