# ExpressiveBackend

#### Run composer install/update
```bash
#!/usr/bin/env bash
docker-compose run --rm composer update
```

#### Update database schema
```bash
#!/usr/bin/env bash
docker exec expressive_backend_phpfpm_container /bin/sh -c 'php /var/www/vendor/bin/doctrine orm:schema-tool:update --force'
```

#### Init database fixture
```bash
#!/usr/bin/env bash
docker exec expressive_backend_phpfpm_container /bin/sh -c 'php bin/init-db-fixtures.php'
```

# Server instance

```text
IP: 
UID: 
PWD: 
```

#### phpMyAdmin

```text
URL: http://127.0.0.1:8082
UID: dev
PWD: dev
DB: dev
```

# API Endpoints

### Endpoint base URL

http://127.0.0.1:8082
