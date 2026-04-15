FROM php_base_image AS php_base

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip make retry jq openssh-client \
    && rm -rf /var/lib/apt/lists/*

ARG TWINT_SDK_PHP_CURL_SSL_ENGINE=openssl
RUN if [ "${TWINT_SDK_PHP_CURL_SSL_ENGINE}" != openssl ]; then \
    apt-get update \
    && apt-get install -y --no-install-recommends \
             libargon2-dev \
             libcurl4-"${TWINT_SDK_PHP_CURL_SSL_ENGINE%-nobignum}-dev" \
             libonig-dev \
             libreadline-dev \
             libsodium-dev \
             libsqlite3-dev \
             libssl-dev \
             libxml2-dev \
             zlib1g-dev \
    && docker-php-source extract \
    && cd /usr/src/php \
    && retry sh -c 'eval $(php --info | grep "^Configure Command" | cut -d " " -f 5-)' \
    && retry make -j $(nproc) \
    && make install \
    && docker-php-source delete \
    && rm -rf /var/lib/apt/lists/*; fi

COPY php-extensions.txt /tmp/php-extensions.txt
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/download/2.10.15/install-php-extensions /usr/local/bin/
RUN for ext in @composer `cat /tmp/php-extensions.txt`; do retry install-php-extensions $ext ; done && rm /tmp/php-extensions.txt

# Check for the correct SSL engine
RUN php -r 'assert(str_starts_with(strtolower(curl_version()["ssl_version"]), str_replace("-nobignum", "", getenv("TWINT_SDK_PHP_CURL_SSL_ENGINE"))), curl_version()["ssl_version"]);'

# Check bignum/nobignum flavor
RUN php -r ' \
    if (str_ends_with(getenv("TWINT_SDK_PHP_CURL_SSL_ENGINE"), "-nobignum")) { \
        assert(!extension_loaded("gmp")); \
        assert(!extension_loaded("bcmath")); \
    } else { \
        assert(extension_loaded("gmp") || extension_loaded("bcmath")); \
    }'

ENV PATH="${PATH}:./vendor/bin"
