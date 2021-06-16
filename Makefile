init:
	sudo cp .env.example .env && sudo php artisan migrate:fresh --seed &&sudo  php artisan passport:install