DBDUMP=../dbdump.sql.gz
LOCALSQL=../local.sql

include .env
export $(shell sed 's/=.*//' .env)

DOCKER_SHELL=docker-compose exec web su -l
DOCKER=$(DOCKER_SHELL) www-data -c
DOCKER_MYSQL_NOTTY=docker-compose exec -T db mysql -uroot magento

default: sh

up:
	docker-compose down
	docker-sync stop
	docker-sync clean
	docker-sync-stack start

sh:
	$(DOCKER_SHELL) www-data

root:
	$(DOCKER_SHELL) root

composer:
	$(DOCKER) 'composer install --no-dev'

upgrade:
	$(DOCKER) 'bin/magento setup:upgrade'

compile:
	$(DOCKER) 'bin/magento setup:di:compile'
	$(DOCKER) 'composer dumpautoload -o'

build: composer upgrade compile

static:
	$(DOCKER) 'bin/magento setup:static-content:deploy -f en_AU en_US'

index:
	$(DOCKER) 'bin/magento index:reindex'

ccall:
	$(DOCKER) 'redis-cli -h cache flushall'

clean: cc

cc:
	$(DOCKER) 'bin/magento cache:flush'

buildall: ccall build static index cc

db:
	$(DOCKER) 'mysql -hdb -uroot magento'

dbload:
	$(DOCKER_MYSQL_NOTTY)

dbnew:
	$(DOCKER_MYSQL_NOTTY) -e"drop database magento; create database magento;"

log:
	-$(DOCKER_SHELL) root -c '( test -h /var/log/apache2/error.log && rm -f /var/log/apache2/error.log && service apache2 reload )'
	$(DOCKER) 'mkdir -p var/log && touch var/log/{system,exception,debug}.log'
	$(DOCKER) 'tail -f var/log/*.log /var/log/apache2/error.log'

open:
	Open http://$(COMPOSE_PROJECT_NAME).localhost:$(HTTP_PORT)/

local: $(DBDUMP) $(LOCALSQL) dbnew
	gzip -cd $(DBDUMP) | $(MAKE) dbload
	$(MAKE) dbload < $(LOCALSQL)
	$(MAKE) build

