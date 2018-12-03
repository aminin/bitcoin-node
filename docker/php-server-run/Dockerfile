FROM php:7.2-cli-alpine

#RUN useradd -Ums /bin/bash aminin \
#    && mkdir -p /home/aminin/bitcoin-node \
#    && chown aminin:aminin /home/aminin/bitcoin-node

RUN addgroup aminin \
    && adduser -h /home/aminin/bitcoin-node -s /bin/bash -D -G aminin aminin \
    && mkdir -p /home/aminin/bitcoin-node \
    && chown aminin:aminin /home/aminin/bitcoin-node

USER aminin
WORKDIR /home/aminin/bitcoin-node
EXPOSE 8000

ADD variables-order.ini /usr/local/etc/php/conf.d/

CMD php -S 0.0.0.0:8000 -t public ../config/router_dev.php
