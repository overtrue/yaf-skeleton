#!/bin/bash

source "$SCRIPT_DIR/common.sh"

PHPCS_CMD="php ./sora cs"

info "executing: $PHPCS_CMD"

$PHPCS_CMD
