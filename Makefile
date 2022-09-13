#!/bin/bash
DOCKER_COMPOSE_PATH = .docker
DOCKER_COMPOSE_FILE = ${DOCKER_COMPOSE_PATH}/docker-compose.yml

 ifneq (,$(wildcard ${DOCKER_COMPOSE_PATH}/.env))
    include ${DOCKER_COMPOSE_PATH}/.env
    export
endif

DOCKER_PHP = ${APP_NAME}_php

UID = $(shell id -u)

help: ## Show this help message
	@echo 'Welcome to ${APP_NAME} make'
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Start the containers
	docker network create puyu-network || true
	U_ID=${UID} docker-compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_FILE} up -d
	@echo 'http://localhost:9191'

stop: ## Stop the containers
	U_ID=${UID} docker-compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_FILE} stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

rebuild: ## Rebuilds all the containers
	U_ID=${UID} docker-compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_FILE} build

nginx-logs: ## Tails the Symfony dev log
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_PHP} tail -f /var/log/nginx/project_access.log
# End backend commands

ssh-php: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_PHP} bash

code-style: ## Runs php-cs to fix code styling following Symfony rules
	cd ${DOCKER_PATH}/ && U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_PHP} php-cs-fixer fix src --rules=@Symfony