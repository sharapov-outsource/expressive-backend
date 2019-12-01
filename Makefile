# Import local environment overrides
$(shell touch .env)
include .env

# Project variables
PROJECT_NAME ?= ExpressiveBackend
ORG_NAME ?= ExpressiveBackend

# Release settings
export HTTP_PORT ?= 8000
export HTTPS_PORT ?= 4433
export API_PORT ?= 8000
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
	@ docker-compose $(TEST_ARGS) build $(NOPULL_FLAG) webapi phpfpm
	# mysql8
#
#	${INFO} "Starting MySQL8..."
#	@ docker-compose $(TEST_ARGS) up -d mysql8
#	${INFO} "Start MySQL8 health check service..."
#	@ $(call check_exit_code,$(TEST_ARGS),database)
#
#	${INFO} "Starting PhpMyAdmin..."
#	@ docker-compose $(TEST_ARGS) up -d phpmyadmin
#	${INFO} "Start PhpMyAdmin health check service..."
#	@ $(call check_exit_code,$(TEST_ARGS),phpmyadmin)
#
	${INFO} "Starting WebAPI service..."
	@ docker-compose $(TEST_ARGS) up -d webapi
	${INFO} "Start WebAPI health check service..."
	@ $(call check_exit_code,$(TEST_ARGS),webapi)
#
#	${INFO} "Starting composer service..."
#	@ docker-compose $(TEST_ARGS) up -d composer

	${INFO} "Testing environment was created successfully"
	${INFO} "WebAPI running at     http://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),webapi,$(HTTP_PORT)) and https://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),webapi,$(HTTPS_PORT))"
#	${INFO} "MySQL8 running at     http://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),mysql8,$(MYSQL_PORT))"
#	${INFO} "PhpMyAdmin running at http://$(DOCKER_HOST_IP):$(call get_port_mapping,$(TEST_ARGS),phpmyadmin,$(HTTP_PORT))"
	${INFO} "Testing complete"

testing: clean-test test
