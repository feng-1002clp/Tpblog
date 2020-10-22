#!/bin/bash
git add -A
git commit -m $1
git pull origin master --no-edit
git push origin master:master
