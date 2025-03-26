# php-d-influencers-test
Um teste para a magnum, contendo um projeto completo neste repositório.

### Características do projeto

** Infraestrutura: **
- PHP: Versão 8.4
- Banco de dados: MySQL
- Servidor Web: Nginx
- Framework PHP: Laravel 12 (Para que eu consiga uma entrega mais agíl e bem estruturada)
- Front-end: ReactJS Versão 19 (React Router v7) => Endereço Dev: http://localhost:5173/
- Back-end Endereço Dev: http://localhost:8000/
- Cypress Endereço Dev: 

** Padrões e considerações aplicadas: **
- As funções, váriaveis são completamente em inglês, sendo apenas a interface de usuário em Português.
- Os projetos laravel e react seguem o modelo estrutural popular mais usado no mercado, sendo o laravel baseado em serviços com injeção de dependências.
- A ferramenta de documentação padrão a qual foi usada foi o Postman, mencionada mais a baixo antes dos exemplos.
- Os testes vão usar PHPUnit para testar o código e Cypress para os testes end-to-end.
- O cypress está separado do projeto em uma pasta, vamos entender que o container do laravel não precisa de um nodejs instalado só por conta disso, e que não estamos dispostos de implementar isso como parte do nosso front reactjs, também vale ressaltar que o cypress padrão é pesado, foi usado um skeleton base que é funcional e leve de usar, criado por um autor terceiro https://github.com/cjbramble/cy-skeleton/tree/main, portanto deixo bem claro que o cypress está ligado aos projetos diretamente e este skeleton substitui a instalação padrão mas não muda o resultado do meu desenvolvimento.


### Instruções para rodar o ambiente localmente.

# Executar o comando na pasta raiz
`
docker-compose up --build
`

# Posteriormente após o build é possível
`
docker-compose up -d
`

# Para desligar
`
docker-compose down
`

### Instruções para testar os endpoints.

- Documentação dos endpoints.

- Exemplos de requisições nos formatos especificados.



