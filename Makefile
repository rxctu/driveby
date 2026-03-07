.PHONY: build up down install migrate seed fresh logs shell

# Build and start all containers
build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

# First-time installation
install: build up
	@echo "Waiting for containers to start..."
	sleep 5
	docker compose exec app composer install
	docker compose exec app cp .env.example .env
	docker compose exec app php artisan key:generate
	docker compose exec app npm install
	docker compose exec app npm run build
	docker compose exec app php artisan migrate --seed
	docker compose exec app php artisan storage:link
	@echo ""
	@echo "EpiDrive is ready at http://localhost:8080"

# Database commands
migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

fresh:
	docker compose exec app php artisan migrate:fresh --seed

# Utility
logs:
	docker compose logs -f

shell:
	docker compose exec app bash

# Dev mode (Vite watch)
dev:
	docker compose exec app npm run dev

# Cache
cache:
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache

cache-clear:
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear
