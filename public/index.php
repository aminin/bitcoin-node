<?php

$autoLoader = require_once __DIR__ . '/../vendor/autoload.php';
$autoLoader->add('Ami\\Bitcoin\\', __DIR__ . '/../src/');
$autoLoader->register();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ami\Bitcoin\Client as BitcoinClient;

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = new Silex\Application();
$app['debug'] = true;

$app['wallet.config'] = include __DIR__ . '/../config.php';

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);


$bitcoinClient = $app['wallet.config'] ? new BitcoinClient([
    'scheme'   => 'http',
    'host'     => $app['wallet.config']['server'],
    'port'     => $app['wallet.config']['port'],
    'user'     => $app['wallet.config']['username'],
    'password' => $app['wallet.config']['password'],
]) : null;


$app->get('/generate10', function () use ($app, $bitcoinClient) {
    $result = $bitcoinClient->generate(10);

    return new RedirectResponse('/');
});

$app->get('/getnewaddress', function () use ($app, $bitcoinClient) {
    $bitcoinClient->getnewaddress($app['wallet.config']['accountName']);

    return new RedirectResponse('/');
});


$app->get('/', function () use ($app, $bitcoinClient) {
    $address = $bitcoinClient->getaccountaddress($app['wallet.config']['accountName']);
    $addresses = $bitcoinClient->getaddressesbyaccount($app['wallet.config']['accountName']);
    $balance = $bitcoinClient->getbalance($app['wallet.config']['accountName']);
    $transactions = $bitcoinClient->listtransactions($app['wallet.config']['accountName']);

    return $app['twig']->render('index.html.twig', [
        'address' => $address,
        'addresses' => $addresses,
        'balance' => $balance,
        'transactions' => $transactions,
    ]);
});

$app->run();
