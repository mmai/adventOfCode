#!/usr/bin/env bash

YEAR=$(date +"%Y")
if [ $# -eq 2 ]
then
  YEAR="${1}"
  DAY="${2}"
elif [ $# -eq 1 ]
then
  DAY="${1}"
else
  echo "Day : "
  read DAY
fi

DIR=$YEAR/day$DAY
AOC_SESSION_COOKIE=$(pass web/adventOfCodeCookie)

mkdir -p $DIR
curl "https://adventofcode.com/$YEAR/day/$DAY/input" -H "cookie: session=${AOC_SESSION_COOKIE}" > $DIR/input
