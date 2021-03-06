<?php
// Create app
$config = array(
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
    'debug' => true,
    'log.enable' => true,
    'db' => array(
        'engine' => 'mysql',
        'host' => 'eu-cdbr-west-01.cleardb.com',
        'database' => 'heroku_8646fdb99660d05',
        'username' => 'b9332b6354ade6',
        'password' => '8988813a',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'port' => 3306,
        'options' => array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => true,
        ),
    )
);

$app = new \Slim\App(['settings' => $config]);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('templates', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['db'] = function($container) {
    $config = $container->get('settings')['db'];
    $dsn = "{$config['engine']}:host={$config['host']};dbname={$config['database']};port={$config['port']};charset={$config['charset']}";
    $username = $config['username'];
    $password = $config['password'];

    return new PDO($dsn, $username, $password, $config['options']);
};
