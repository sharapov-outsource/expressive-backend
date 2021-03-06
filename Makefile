# Import local environment overrides
$(shell touch .env)
include .env

# Project variables
PROJECT_NAME ?= ExpressiveBackend
ORG_NAME ?= ExpressiveBackend

# Release settings
export HTTP_PORT ?= 80
export HTTPS_PORT ?= 443
export API_SSL_PORT ?= 4235
export API_REG_PORT ?= 3423
export MYSQL_PORT ?= 3306
export DB_NAME ?= dev
export DB_USER ?= dev
export DB_PASSWORD ?= dev
export BUILD_ID ?=

include Makefile.settings

version:
	@ echo '{"Version": "$(APP_VERSION)"}'

status:
	${INFO} "Getting container status..."
	@ docker ps | grep $(PROJECT_NAME)

clean%test:
	${INFO} "Destroying test environment..."
	@ docker-compose $(TEST_ARGS) down -v || true

test:
	${INFO} "Building images..."
	@ docker-compose $(TEST_ARGS) build $(NOPULL_FLAG) webapi phpfpm mysql8
#
	${INFO} "Starting MySQL8..."
	@ docker-compose $(TEST_ARGS) up -d mysql8
	${INFO} "Start MySQL8 health check service..."
	@ $(call check_exit_code,$(TEST_ARGS),database)
#
	${INFO} "Starting PhpMyAdmin..."
	@ docker-compose $(TEST_ARGS) up -d phpmyadmin
	${INFO} "Start PhpMyAdmin health check service..."
	@ $(call check_exit_code,$(TEST_ARGS),phpmyadmin)
#
	${INFO} "Starting WebAPI service..."
	@ docker-compose $(TEST_ARGS) up -d webapi
	${INFO} "Start WebAPI health check service..."
	@ $(call check_exit_code,$(TEST_ARGS),webapi)
#
	${INFO} "Testing environment was created successfully"
	${INFO} "WebAPI running at     http://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),webapi,$(API_REG_PORT)) and https://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),webapi,$(API_SSL_PORT))"
	${INFO} "MySQL8 running at     http://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),mysql8,$(MYSQL_PORT))"
	${INFO} "PhpMyAdmin running at http://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),phpmyadmin,$(HTTP_PORT))"
	${INFO} "Testing complete"

testing: clean-test test

# if the command starts with "composer" or console, grab the arguments for the command
ifeq ($(firstword $(MAKECMDGOALS)), $(filter $(firstword $(MAKECMDGOALS)), console composer))
    # use the rest as arguments for our real command
    RUN_COMPOSER_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
    # turn them into null targets
    $(eval $(RUN_COMPOSER_ARGS):;@:)
endif

.PHONY: composer

composer:
	${INFO} "Running composer $(RUN_COMPOSER_ARGS)..."
	@ docker exec -it $(TEST_PROJECT)_phpfpm_container composer $(RUN_COMPOSER_ARGS)

init-test-database:
	${INFO} "Creating database schema..."
	@ docker exec -it $(TEST_PROJECT)_phpfpm_container $(APP_ORM_UPDATE_ARG)

init-test-database-fixtures:
	@( read -p "This operation will purge all the existing entries in database and load defaults. Are you sure?!? [y/N]: " sure && case "$$sure" in [yY]) true;; *) false;; esac )
	${INFO} "Loading database fixtures..."
	@ docker exec -it $(TEST_PROJECT)_phpfpm_container $(APP_BIXPRESSIVE) fixtures load

clear-cache:
	${INFO} "Clearing in-app cache..."
	@ docker exec -it $(TEST_PROJECT)_phpfpm_container $(APP_BIXPRESSIVE) cache clear
