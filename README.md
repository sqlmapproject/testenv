# SQL injection test environment

A collection of web pages vulnerable to SQL injection flaws and more:
* `conf/` - operating system configuration files used by `deployment.sh`.
* `dbs/` - standalone databases for some database management systems (e.g. Microsoft Access).
* `libs/` - web API libraries to connect to the database management system, perform the provided statement and return its output.
* `schema/` - SQL used to create the test database, a test table and populate it with test entries.
* Other directories - vulnerable pages for each database management system.
* `deployment.sh` - A bash script to deploy from scratch a fully-fledged Linux (Debian or Ubuntu) machine with all the relevant database management systems installed and configured, ready to be targeted.
