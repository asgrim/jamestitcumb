#!/usr/bin/env bash

set -euxo pipefail

WAITFORIT_NO_BUSYTIMEFLAG=1 wait-for-it elastic.asgrim:9200 --timeout=120

/app/app.php index-posts

php-fpm --allow-to-run-as-root
