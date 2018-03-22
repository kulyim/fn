#!/bin/bash
PU='vendor/bin/phpunit'
AUTO='--bootstrap vendor/autoload.php'
CMD="$PU $AUTO ${1+"$@"} $2"
if [ "$#" -ne "1" ]; then
    echo "Usage $0 testfoldername"
    exit
fi
$CMD
