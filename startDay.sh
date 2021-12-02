#!/usr/bin/env sh

echo "TODO : connexion"
exit

YEAR=$(date +"%Y")
if [ $# -eq 2 ]
then
  YEAR=$1
  DAY=$2
elif [ $# -eq 1 ]
then
  DAY=$1
else
  echo "Day : "
  read DAY
fi

DIR=$YEAR/day$DAY

mkdir -p $DIR
curl "https://adventofcode.com/$YEAR/day/$DAY/input" > $DIR/input
