
.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## Dev commands
.PHONY: install
install: ## Install project
	@docker-compose build

.PHONY: backend_start
backend_start: ## Start backend
	@docker-compose up -d

.PHONY: backend_stop
backend_stop: ## Stop backend
	@docker-compose stop

## Tests
.PHONY: backend_test
phpunit: ## Run PHPUnit
	@docker-compose exec php bin/phpunit --configuration phpunit.xml.dist --testsuite Functional tests

.PHONY: php-cs-fixer
php-cs-fixer: ## Run PHP CS Fixer
	@docker-compose exec php ./vendor/bin/php-cs-fixer fix -v

.PHONY: phpstan
phpstan: ## Run PHPStan
	@docker-compose exec php ./vendor/bin/phpstan analyse src tests

.PHONY: phpinsights
phpinsights: ## Run phpinsights
	@docker-compose exec php ./vendor/bin/phpinsights --no-interaction --min-quality=91 --min-architecture=84 --min-style=90

## Helper commands
.PHONY: sh
sh: ## Open sh on php container
	@docker-compose exec php sh
