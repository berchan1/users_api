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

generate SSL keys
```sh
php bin/console lexik:jwt:generate-keypair
```

### Endpoints

- [x] register
- [ ] avatar update
- [x] get users
- [x] delete user
- [x] edit user
- [x] login
- [x] logout

### TODO's

- unique email validation
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
after login you will get a token in response 

show users (without passwords)
```sh
curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer {token}" http://localhost:8080/api/get_users
```

delete user
```sh
curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer {token}" http://localhost:8080/api/delete/{id}
```

update user
```sh
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer {token}" http://localhost:8080/api/update/12 -d '{"email":"new_email@wp.pl","first_name":"new_name","last_name":"new_last_name","password":"new_pass"}'
```

logout
```sh
curl -X GET -H "Content-Type: application/json" http://localhost:8080/logout
```
