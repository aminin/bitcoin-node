# Биткоин с Докером с JSON-RPC

 * https://github.com/ruimarinho/docker-bitcoin-core
 * https://github.com/docker-library/php
 * https://github.com/denpamusic/php-bitcoinrpc

## Установка и запуск

```bash
mkdir -p shared-volumes/bitcoin/
git clone git@github.com:aminin/bitcoin-node.git
cd bitcoin-node
docker-compose up --build
```
