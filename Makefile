#!/bin/bash
DOCKER_COMPOSE_PATH = .docker
DOCKER_COMPOSE_FILE = ${DOCKER_COMPOSE_PATH}/docker-compose.yml

 ifneq (,$(wildcard ${DOCKER_COMPOSE_PATH}/.env))
    include ${DOCKER_COMPOSE_PATH}/.env
    export
endif

DOCKER_PHP = ${APP_NAME}_php
DOCKER_NGINX = ${APP_NAME}_nginx

COMPOSER=$(shell grep alias\ composer= ./alias.sh | awk -F"'" '{print $$2}')
SF=$(shell grep alias\ sf= ./alias.sh | awk -F"'" '{print $$2}')

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

rebuild: ## Rebuilds images docker
	U_ID=${UID} docker-compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_FILE} build

ci: ## Run CI commands
	@echo 'Running CI in ${APP_NAME}'
	@echo 'GIT PULL  ------------------------------------------------------------------|'
	git pull
	@echo 'COMPOSER INSTALL  ----------------------------------------------------------|'
	$(COMPOSER) install
	@echo 'SYMFONY MIGRATE  -----------------------------------------------------------|'
	$(SF) do:mi:mi -n

#Run by default RUN option
.DEFAULT_GOAL := run