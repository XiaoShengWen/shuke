.PHONY: run-web 

PWD := $(shell pwd)
USER := $(shell id -u)
GROUP := $(shell id -g)
MONGO_ID := $(shell sudo docker ps -a | grep 'mongo' | awk '{print $$1}')

all: run-web

run-web: 
	cd docker && sudo docker-compose up

rm-web: 
	cd docker && sudo docker-compose rm

npm:
	sudo docker run -it --rm \
	    -u $(USER):$(GROUP) \
	    -v $(PWD)/www:/var/www/html/www \
	    -w /var/www/html/www \
	    wzy.cloud/library/webpack \
	    npm $(cli) 

webpack:
	sudo docker run -it --rm \
	    -u $(USER):$(GROUP) \
	    -v $(PWD)/www:/var/www/html/www \
	    -w /var/www/html/www \
	    wzy.cloud/library/webpack \
	    webpack $(cli) 

mongo-export:
	sudo docker exec -it \
	    $(MONGO_ID) \
		mongoexport -d wall-breaker -c novels -o ./var/www/mongo/backup.json

