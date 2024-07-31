FROM php_base_image AS php_base
COPY php-extensions.txt /tmp/php-extensions.txt

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/download/2.3.2/install-php-extensions /usr/local/bin/
RUN install-php-extensions @composer `cat /tmp/php-extensions.txt` && rm /tmp/php-extensions.txt

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip make retry jq openssh-client \
    && rm -rf /var/lib/apt/lists/*

ENV PATH="${PATH}:./vendor/bin"
