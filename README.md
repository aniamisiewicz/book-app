# Instrukcja uruchomienia projektu Book App
- W pliku .env ustawiamy paramtetry dostępowe do bazy danych,
- W przypadku braku composera, to w katalogu projektu wykonujemy:
```text
composer install
```
jeżeli jednak mamy to:
```text
composer update
```
- ładujemy migracje i zapełniamy bazę danych danymi:
```text
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
!Istotne, aby usunąć wczesniej instniejące migracje, które mogłyby wpłynąć na aplikację. 
Aby to zrobić wykonujemy:
```text
bin/console doctrine:schema:drop --force
bin/console doctrine:query:sql "TRUNCATE TABLE migration_versions"
```
następnie fizycznie usuwamy migracje z folderu /app/migrations i wykonujemy:
```text
bin/console make:migration
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
```
