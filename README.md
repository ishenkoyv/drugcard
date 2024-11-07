# DrugCard Test Task
- Symfony v7.1.*
- PHP v8.3.x
- MariaDB v8.*
- RabbitMQ v3.*

# Requirements
- Stable version of [Docker](https://docs.docker.com/engine/install/)
- Compatible version of [Docker Compose](https://docs.docker.com/compose/install/#install-compose)

# How To Deploy

### For first time only !
- `git clone`
- `cd drugcard`
- `make install`

### Run app
curl -i -k https://localhost/api/products

make bash
php bin/console app:parse-products

make bash
php bin/console messenger:consume async -vv

### Run tests
- `make test`
