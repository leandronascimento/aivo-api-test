## Youtube search list
Api para busca de videos no Youtube
#### Tecnologias:
- Lumen Framework 8.0
- Nginx
- Docker
- PHPUnit
#### Features:
- Busca de videos no Youtube

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

#### Rodando os testes da aplicação.
``` bash
$ docker exec -it aivo-api-test_php_1 php ./vendor/bin/phpunit
```

#### HTTP
- `GET http://localhost/api/youtube?query=muse` lista.

#### API
##### Busca por videos do Youtube
``` bash
$ curl --location --request POST 'http://localhost/api/youtube?query=muse'
```

Resposta esperada:
```json
{
    "published_at": "2009-10-09T13:15:12Z",
    "id": "w8KQmps-Sog",
    "title": "Muse - Uprising [Official Video]",
    "description": "Watch the music video for \"Uprising\" now! \"Uprising\" was released as the lead single from Muse's fifth studio album, The Resistance, on September 7, 2009.",
    "thumbnail": "https:\/\/i.ytimg.com\/vi\/w8KQmps-Sog\/default.jpg",
    "extra": {
      "channelTitle": "Muse",
      "liveBroadcastContent": "none",
      "publishTime": "2009-10-09T13:15:12Z"
    }
},
```
