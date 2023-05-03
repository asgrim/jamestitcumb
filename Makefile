.PHONY: *

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

test: build ## run phpunit test suite
	docker compose run --rm web vendor/bin/phpunit --do-not-cache-result

cs-check: build ## check coding standards
	docker compose run --rm --no-deps web vendor/bin/phpcs --no-cache

cs-fix: build ## fix coding standards
	docker compose run --rm --no-deps web vendor/bin/phpcbf

static-analysis: build ## check for static analysis errors
	docker compose run --rm --no-deps web vendor/bin/psalm

build: clean
	docker compose build

run: build ## Run the docker environment enabling you to browse the site locally (note: need ports in docker-compose.override.yml)
	docker compose up -d
	docker compose exec web php app.php index-posts
	docker compose exec web php app.php cache-ratings

clean: ## clean the stuff
	docker compose down --remove-orphans

ci: cs-check static-analysis test ## Run all the tests

index-posts: ## index the posts (note: need to run make run first)
	docker compose exec web php app.php index-posts

cache-ratings: ## index the posts (note: need to run make run first)
	docker compose exec web php app.php cache-ratings

update-static-analysis-baseline: ## bump static analysis baseline issues, reducing set of allowed failures
	docker compose run --rm --no-deps web vendor/bin/psalm --update-baseline

reset-static-analysis-baseline: ## reset static analysis baseline issues to current HEAD
	docker compose run --rm --no-deps web vendor/bin/psalm --set-baseline=.psalm-baseline.xml
