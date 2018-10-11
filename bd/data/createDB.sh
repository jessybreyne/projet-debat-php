#!/usr/bin/env bash

sqlite3 data.sqlite3 < debat-creation.sql
sqlite3 data.sqlite3 < debat-instances.sql
