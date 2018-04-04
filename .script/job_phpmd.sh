#!/bin/bash

source "$SCRIPT_DIR/common.sh"

PHPMD_CMD="./vendor/bin/phpmd ./app/ text ./vendor/sora/phpmd-rulesets/phpmd_ruleset.xml"

info "executing: $PHPMD_CMD"

$PHPMD_CMD
