FROM php_base_image AS php_base_image_extensions_prepare
RUN apt-get update \
    && apt-get install -y --no-install-recommends jq \
    && rm -rf /var/lib/apt/lists/*
COPY composer.lock /tmp/composer.lock
ARG DEV=true
RUN jq --arg dev "${DEV}" --raw-output '\
    ["zip"] + \
    [ \
      [ \
        .platform + if $dev == "true" then ."platform-dev" | if type == "array" then {} else . end else {} end | to_entries[] \
      ] + \
      [  \
        .packages[] | to_entries[] | select (.key == "require" or ($dev == "true" and .key == "require-dev")) | .value | to_entries \
      ] \
      | flatten[] | select(.key | startswith("ext-")) | .key[4:] \
    ] | sort | unique | join(" ")' < /tmp/composer.lock > /tmp/php-extensions.txt
RUN rm /tmp/composer.lock

FROM php_base_image AS php_base

COPY --from=php_base_image_extensions_prepare /tmp/php-extensions.txt /tmp/php-extensions.txt
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/download/2.2.16/install-php-extensions /usr/local/bin/
RUN install-php-extensions @composer `cat /tmp/php-extensions.txt` && rm /tmp/php-extensions.txt

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip make retry \
    && rm -rf /var/lib/apt/lists/*

ENV PATH="${PATH}:./vendor/bin"
