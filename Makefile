install:
	@echo "mulai fresh install"
	copy .env.example .env
	docker-compose -f local.yml build
	docker-compose -f local.yml run --rm php composer install --ignore-platform-reqs --prefer-dist --no-interaction --ansi
	docker-compose -f local.yml run --rm php npm install
	docker-compose -f local.yml run --rm php npm run development
	docker-compose -f local.yml up -d
	: docker-compose -f local.yml run --rm php php artisan app:install

dup:
	@echo "start docker composer up":
	docker-compose -f local.yml up -d

rebuild:
	@echo "rebuild containers":
	docker-compose -f local.yml up --build

down:
	@echo "start docker-compose dowm":
	docker-compose -f local.yml down --remove-orphans

logs:
	@echo "start logs":
	: docker-compose -f local.yml logs
	docker logs ${cid}

logs-all:
	@echo "start logs":
	docker-compose -f local.yml logs

php:
	@echo "Start local php bash"
	docker-compose -f local.yml exec php bash