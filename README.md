### Setup

#### running docker
in the `.docker` directory:
```sh
docker-compose up -d
```

#### composer install
in the php container (`docker exec -it php /bin/sh`)
```sh
cd /var/www/users_api/back
composer install
```

run migrations
in the `/var/www/users_api/back` directory
```sh
php bin/console doctrine:migrations:migrate
```

### Endpoints

- [x] register
- [ ] avatar update
- [x] get users
- [ ] delete user
- [ ] edit user
- [x] login
- [x] logout

### TODO's

- unique email validation
- implement token
- finish implementing swagger (endpoints are not properly documented)
- (optional) vue frontend

### Examples

register
```sh
curl -X POST -H "Content-Type: application/json" http://localhost:8080/api/register -d '{"email":"imie_nazwisko@wp.pl"," first_name":"imie","last_name":"nazwisko","password":"test"}'
```

login
```sh
curl -X POST -H "Content-Type: application/json" http://localhost:8080/api/login -d '{"username":"imie_nazwisko@wp.pl","password":"test"}'
```

show users (without passwords)
```sh
curl -X GET -H "Content-Type: application/json" http://localhost:8080/user/api_user
```

logout
```sh
curl -X GET -H "Content-Type: application/json" http://localhost:8080/logout
```
