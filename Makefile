.PHONY: *

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

unit: ## run unit tests
	docker-compose run --rm php-fpm vendor/bin/phpunit --do-not-cache-result

cs-check: ## check coding standards
	docker-compose run --rm php-fpm vendor/bin/phpcs --no-cache

static-analysis: ## check static analysis
	docker-compose run --rm php-fpm vendor/bin/psalm

build: cs-check unit static-analysis
