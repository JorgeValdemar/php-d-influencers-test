FROM php:8.4-fpm

# aplicar as extensoes de PHP e mysql e atualizar o container linux
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

# declarar o usuario e a pasta raiz
ARG USER=dinfluencer
ARG HOME=/var/www

# garantir que temos todas as extensoes comuns para o PHP nao dar pau em alguma lib
RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            git \
            libzip-dev \
            zip \
            libmemcached-dev \
            libz-dev \
            libpq-dev \
            libjpeg-dev \
            libpng-dev \
            libfreetype6-dev \
            libssl-dev \
            libwebp-dev \
            libxpm-dev \
            libmcrypt-dev \
            libicu-dev \
            libonig-dev; \
    rm -rf /var/lib/apt/lists/*

# algumas aqui vai travar o laravel se nao tiver, principalmente PDO para o eloquent
RUN set -eux; \
    # Install the PHP pdo_mysql extention
    docker-php-ext-install pdo_mysql; \
    # Install the PHP pdo_pgsql extention
    docker-php-ext-install pdo_pgsql; \
    # ZIP used by composer
    docker-php-ext-install zip; \
    # Format money etc...
    docker-php-ext-install mbstring; \
    docker-php-ext-install intl; \
    docker-php-ext-configure intl; \
    # Install the PHP gd library
    docker-php-ext-configure gd \
            --prefix=/usr \
            --with-jpeg \
            --with-webp \
            --with-xpm \
            --with-freetype; \
    docker-php-ext-install gd; \
    php -r 'var_dump(gd_info());'
RUN docker-php-ext-enable intl mbstring

# aplicar o user e declarar o diretorio de trabalho para os comandos do docker trabalharem a partir dele
RUN useradd -ms /bin/bash $USER
WORKDIR /var/www

# permissoes do docker
RUN groupadd -f docker
RUN usermod -aG docker $USER

# aplicar o composer para conseguir manter as libs atualizadas dentro do container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer
RUN alias composer='php /usr/bin/composer'

# declarar que o usuario tem as permissoes x para este container
RUN chown -R $USER:$USER $HOME
RUN chmod -R g+rw $HOME

USER $USER
