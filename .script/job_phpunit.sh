#!/bin/bash

source "$SCRIPT_DIR/common.sh"

# alias php="php -n -c /tmp/php"
# already set in .gitlab-ci.yml
PHPUNIT_CMD="php ./sora test --coverage-text --coverage-html=./coverage --colors=never"

info "executing: $PHPUNIT_CMD"

$PHPUNIT_CMD
