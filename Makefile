.PHONY: help install run test docker-up docker-down clean

help:
	@echo "Available commands:"
	@echo "  make docker-up    - Start Docker containers"
	@echo "  make docker-down  - Stop Docker containers"
	@echo "  make install      - Install dependencies (local)"
	@echo "  make run          - Start server (local)"
	@echo "  make test         - Run tests"
	@echo "  make lint         - Run linter"
	@echo "  make analyse      - Run static analysis"
	@echo "  make clean        - Clear cache"

install:
	composer install
	cp .env.example .env
	php artisan key:generate

run:
	php artisan serve --port=8001

test:
	php artisan test --coverage --min=50

lint:
	./vendor/bin/pint --test

analyse:
	./vendor/bin/phpstan analyse --memory-limit=512M

docker-up:
	docker-compose up -d
	@echo "Waiting for MySQL to be ready..."
	sleep 10
	docker-compose exec app composer install
	docker-compose exec app cp .env.docker .env
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate --seed
	@echo ""
	@echo "========================================="
	@echo "Application is running at: http://localhost:8000"
	@echo "phpMyAdmin is running at: http://localhost:8080"
	@echo "========================================="

docker-down:
	docker-compose down

clean:
	php artisan config:clear
	php artisan cache:clear
	php artisan view:clear
	php artisan route:clear
