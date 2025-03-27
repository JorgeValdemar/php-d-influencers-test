# php-d-influencers-test
Um teste para a magnum, contendo um projeto completo neste repositório.

### Características do projeto

** Infraestrutura: **
- PHP: Versão 8.4
- Banco de dados: MySQL 8 (+ adicionalmente o docker valida se o banco está funcionando)
- Servidor Web: Nginx
- Framework PHP: Laravel 12 (Para que eu consiga uma entrega mais agíl e bem estruturada)
- Front-end: ReactJS (Usei a última versão WebPack, o Vite estava bloqueando a porta do container, não quis perder tempo) => Endereço Dev: http://localhost:3000/
- Back-end Endereço Dev: http://localhost:8000/
- Cypress Endereço Dev: 
- Documentação do Postman: https://documenter.getpostman.com/view/32118189/2sAYkLmweB

** Padrões e considerações aplicadas: **
- As funções, váriaveis são completamente em inglês, sendo apenas a interface de usuário em Português.
- Os projetos laravel e react seguem o modelo estrutural popular mais usado no mercado, sendo o laravel baseado em serviços com injeção de dependências.
- A ferramenta de documentação padrão a qual foi usada foi o Postman, mencionada mais a baixo antes dos exemplos.
- Os testes vão usar PHPUnit para testar o código e Cypress para os testes end-to-end.
- O cypress está separado do projeto em uma pasta, vamos entender que o container do laravel não precisa de um nodejs instalado só por conta disso, e que não estamos dispostos de implementar isso como parte do nosso front reactjs, também vale ressaltar que o cypress padrão é pesado, foi usado um skeleton base que é funcional e leve de usar, criado por um autor terceiro https://github.com/cjbramble/cy-skeleton/tree/main, portanto deixo bem claro que o cypress está ligado aos projetos diretamente e este skeleton substitui a instalação padrão mas não muda o resultado do meu desenvolvimento.

## estrutura de pastas: Laravel
`
Controllers: Responsavel por carregar regra como um todo independente de ser N services.
Services: Cada uma contém uma regra de negócio, é um pacote da regra reaproveitável.
Repositories: É o conjunto que organiza/centraliza o uso das querys, facilitando manutenções de performance.
Models: As regras da tabela e seus relacionamentos com outras. 

Este modelo é ideal e escalável até grande porte desde que o uso da injeção de dependências seja pensado para isso, lembrando que uma service dentro de outra com as mesmas injeções causa loop, aumentando a necessidade de criar libs.
*Para ter conforto em um porte maior pode-se usar modelo de DDD com Use Cases como estrutura e o laravel de auxiliar externo sem romper as "camadas de cebola".
`

## estrutura de pastas: ReactJS
`
ooooo
`

### Instruções para rodar o ambiente localmente.

- Executar o comando na pasta raiz
`
docker-compose up --build
`

- rodar o composer
`
docker exec -it api sh -c "composer install"
`

- criar a chave
`
docker exec -it api sh -c "php artisan key:generate"
`

- rodar as migrations
`
docker exec -it api sh -c "php artisan migrate"
`

- Posteriormente após o build, o trabalho de rotina será apenas
`
docker-compose up -d
`

- Para desligar será
`
docker-compose down
`

### Instruções para testar os endpoints.

- Documentação dos endpoints.


- Exemplos de requisições nos formatos especificados.

abaixo segue alguns exemplos de como realizar o cadastro de usuário e seu retorno em formas diferentes:

- usando terminal CURL
Chamada:
`
curl --location 'http://localhost:8000/api/user/register' \
--data-raw '{
    "name": "Jorge",
    "email": "teste@oi.com",
    "password": "123456",
    "password_confirmation": "123456"
}'
`
Resposta:
`
{
    "user": {
        "name": "Jorge",
        "email": "teste@oi.com",
        "updated_at": "2025-03-27T04:26:42.000000Z",
        "created_at": "2025-03-27T04:26:42.000000Z",
        "id": 1
    },
    "token": "{{vault:json-web-token}}"
}
`

- PHP Guzzle
Chamada:
`
<?php
$client = new Client();
$body = '{
    "name": "Jorge",
    "email": "teste@oi.com",
    "password": "123456",
    "password_confirmation": "123456"
}';
$request = new Request('POST', 'http://localhost:8000/api/user/register', [], $body);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();
`
Resposta:
`
{
  "user": {
    "name": "Jorge",
    "email": "teste@oi.com",
    "updated_at": "2025-03-27T04:26:42.000000Z",
    "created_at": "2025-03-27T04:26:42.000000Z",
    "id": 1
  },
  "token": "{{vault:json-web-token}}"
}
`

- NodeJS Axios
Chamada:
`
var axios = require('axios');
var data = '{\r\n    "name": "Jorge",\r\n    "email": "teste@oi.com",\r\n    "password": "123456",\r\n    "password_confirmation": "123456"\r\n}';

var config = {
  method: 'post',
maxBodyLength: Infinity,
  url: 'http://localhost:8000/api/user/register',
  headers: { },
  data : data
};

axios(config)
.then(function (response) {
  console.log(JSON.stringify(response.data));
})
.catch(function (error) {
  console.log(error);
});
`
Resposta:
`
{
  "user": {
    "name": "Jorge",
    "email": "teste@oi.com",
    "updated_at": "2025-03-27T04:26:42.000000Z",
    "created_at": "2025-03-27T04:26:42.000000Z",
    "id": 1
  },
  "token": "{{vault:json-web-token}}"
}
`

É possível ver mais na documentação do postman mencionado no início desta doc: 
https://documenter.getpostman.com/view/32118189/2sAYkLmweB

