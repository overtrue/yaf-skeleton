#!/bin/bash

# function for trim whithspace
trim() {
  local s2 s="$*"
  # note the tab character in the expressions of the following two lines when copying
  until s2="${s#[   ]}"; [ "$s2" = "$s" ]; do s="$s2"; done
  until s2="${s%[   ]}"; [ "$s2" = "$s" ]; do s="$s2"; done

  info "$s"
}

function fetch-changed-files {
    info "→ Fetching changed files... "

    if [[ $1 != "" ]]; then
        GIT_DIFF="git diff --name-only $1 $2"
    else
        GIT_DIFF="git diff --name-only HEAD^ HEAD"
    fi
    #GIT_DIFF=$(git diff --name-only $CI_BUILD_BEFORE_SHA $CI_BUILD_REF)
    #CI_BUILD_BEFORE_SHA = 00000000
    #This won't fix until gitlab 8.2 release
    #So change to git diff HEAD^ Please do notice this will
    #error for the first commit

    info "→ $GIT_DIFF "

    CHANGED_FILE=$($GIT_DIFF)
    info-line "CHANGED_FILE=$CHANGED_FILE " >&2

    #Concat all line into a string
    CHANGED_FILES=""
    for file in $CHANGED_FILE ; do
        if [[ $file == *.php ]] && [[ -e $file ]]; then
            CHANGED_FILES="$CHANGED_FILES $file"
        fi
    done
}

function info {
    echo -e "\033[0;49;32m~> $1\033[0m"
}

function info-line {
    echo -e "\033[0;49;32m~> $1\033[0m\n"
}

function error {
    echo -e "\033[0;49;31m~> $1\033[0m"
}
