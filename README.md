```bash
docker compose exec -it mysql mysql -uroot -proot
```

```sql
CREATE DATABASE IF NOT EXISTS symfony_test;
GRANT ALL PRIVILEGES ON symfony_test.* TO 'symfony'@'%';
FLUSH PRIVILEGES;
```

```bash
php bin/console doctrine:migrations:migrate --env=test
php bin/console doctrine:fixtures:load --env=test --no-interaction
```


curl -X GET http://localhost:8080/api/authors/

curl -X POST http://localhost:8080/api/authors/ \
-H "Content-Type: application/json" \
-d '{"name": "John Doe", "email": "john.doe@example.com"}'

curl -X PUT http://localhost:8080/api/authors/1 \
-H "Content-Type: application/json" \
-d '{"name": "Jane Doe", "email": "jane.doe@example.com"}'


curl -X PATCH http://localhost:8080/api/authors/1 \
-H "Content-Type: application/json" \
-d '{"name": "Jane Smith"}'
