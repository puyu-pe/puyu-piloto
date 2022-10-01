#!/bin/bash
DOCKER_COMPOSE_PATH='.docker'
source ${DOCKER_COMPOSE_PATH}/.env
DOCKER_PHP="${APP_NAME}_php"

# PHP
alias php='U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php';

# Composer
alias composer='U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} composer';

# Symfony
alias sf='U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php /var/www/html/bin/console';

# PHPUnit
alias test='U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php /var/www/html/bin/phpunit';

# ECS - Easy Coding Standard (Sniffer & Fixers)
alias ecs='U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php vendor/bin/ecs';

# PHPStan - Static Analyses Tool
alias stan='U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php vendor/bin/phpstan';