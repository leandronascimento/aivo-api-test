### Intruções para instalação
#### Clonar o repositório

``` bash
$ git clone git@github.com:leandronascimento/aivo-api-test.git aivo-api-test
$ cd aivo-api-test
```

#### Subir os containers do Docker
``` bash
$ docker-compose up -d
```

#### Criar um arquivo .env
``` bash
$ cp .env.example .env
```

#### Instalar as dependências de pacotes
``` bash
$ docker exec -it aivo-api-test_php_1 composer install
```

#### Migrations.
``` bash
$ docker exec -it aivo-api-test_php_1 php artisan migrate
```

#### Rodando os testes da aplicação.
``` bash
$ docker exec -it aivo-api-test_php_1 php php ./vendor/bin/phpunit
```

#### HTTP
- `GET localhost/api/youtube?search=muse` lista.

#### API
##### Busca por videos do Youtube
``` bash
$ curl --location --request POST 'localhost/api/youtube?search=muse'
```

Resposta esperada:
```json
{
"published_at": "2009-10-09T13:15:12.000Z",
"id": "X8f5RgwY8CI",
"title": "MUSE - Algorithm [Official Music Video]",
"description": "Description here...",
"thumbnail": "https://i.ytimg.com/vi/TPE9uSFFxrI/default.jpg",
	"extra": {
		"something": "extra"
	}
},
```
