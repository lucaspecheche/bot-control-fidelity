FROM ubuntu:xenial

LABEL Description="PHP-FPM v7.2"
LABEL Version="1.0.0"

ENV TIME_ZONE America/Sao_Paulo

RUN apt-get update -yqq \
    && apt-get install -yqq \
	ca-certificates \
    git \
    gcc \
    make \
    wget \
    mc \
    curl \
    sendmail

## Install php7.2 extension
RUN apt-get update -yqq \
    && apt-get install -yqq \
    php7.2-pgsql \
	php7.2-mysql \
	php7.2-sqlite3 \
	php7.2-opcache \
	php7.2-common \
	php7.2-mbstring \
    php7.2-zip \
	php7.2-soap \
	php7.2-cli \
	php7.2-intl \
	php7.2-json \
	php7.2-xsl \
	php7.2-imap \
	php7.2-ldap \
	php7.2-curl \
    php7.2-xml \
	php7.2-gd  \
	php7.2-dev \
    php7.2-fpm \
    php7.2-soap \
    php7.2-bcmath \
    && apt-get install pkg-config \
    && pecl install mongodb \
    && echo "extension=mongodb.so" > /etc/php/7.2/cli/conf.d/ext-mongodb.ini \
    && echo "extension=mongodb.so" > /etc/php/7.2/fpm/conf.d/ext-mongodb.ini \
    && apt-get install -y -q --no-install-recommends \
       ssmtp

# Add default timezone
RUN echo $LYBERTEAM_TIME_ZONE > /etc/timezone
RUN echo "date.timezone=$LYBERTEAM_TIME_ZONE" > /etc/php/7.2/cli/conf.d/timezone.ini

## Install composer globally
RUN echo "Install composer globally"
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Create user and group www-data
RUN usermod -aG www-data www-data

# Reconfigure system time
RUN dpkg-reconfigure -f noninteractive tzdata

# Copy entrypoint.sh to container and execute
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]

WORKDIR /app

EXPOSE 9000
