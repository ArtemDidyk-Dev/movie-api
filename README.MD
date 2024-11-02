### service containers:
```bash
docker-compose -f docker-compose.services.yml -p codenewspaper-services up -d
```

### php and caddy containers:
```bash
docker-compose up -d --build
```
php bin/console lexik:jwt:generate-keypair --skip-if-exists
