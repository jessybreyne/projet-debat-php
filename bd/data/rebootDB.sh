#!/usr/bin/env bash

sqlite3 data.sqlite3 < debat-creation.sql
sqlite3 data.sqlite3 < debat-instances.sql
chmod 777 data.sqlite3
chmod 777 .
