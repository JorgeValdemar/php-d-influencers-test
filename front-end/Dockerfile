ARG NODE_VERSION=23.9.0

# config base
FROM node:${NODE_VERSION}-alpine as base
WORKDIR /usr/src/app
EXPOSE 5173

# bloco de frontend vinda de base declarando o PATH
FROM base as frontend
ENV PATH=/usr/src/app/node_modules/.bin:$PATH

# copiar o conteudo do front para o container
COPY --chown=node:node ./front-end/www ./

# atualizar e preparar para usar os recursos
RUN apk update && apk add bash

# instalar as derendencias do react
RUN npm ci
RUN npm i --silent

# permissoes
RUN chown -R node:node /usr/src/app/.
USER node

# rodar
# opcoes => "build": "react-router build" | "dev": "react-router dev" | "start": "react-router-serve ./build/server/index.js"
CMD ["npm", "run", "dev"]
