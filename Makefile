init:
	sudo cp .env.example .env && sudo composer update &&  sudo php artisan migrate:fresh --seed &&sudo  php artisan passport:install