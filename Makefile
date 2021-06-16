init:
	cp .env.example .env && php artisan migrate:fresh --seed && php artisan passport:install