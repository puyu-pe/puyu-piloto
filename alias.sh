#!/bin/bash
DOCKER_COMPOSE_PATH=".docker"
source ${DOCKER_COMPOSE_PATH}/.env
DOCKER_PHP="${APP_NAME}_php"

# php
alias php="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php";

# composer
alias composer="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} composer";

# symfony - bin/consoleconfig/packages/sensio_framework_extra.yaml
# shellcheck disable=SC2139
alias sf="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php /var/www/html/bin/console";