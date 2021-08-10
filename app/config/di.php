<?php

use function DI\create;
use function DI\get;

use Wl\Api\Client\Shikimori\ShikimoriTransportConfig;
use Wl\Api\Client\Tmdb\TmdbTransport;
use Wl\Config\ConfigService;
use Wl\Config\IConfig;
use Wl\Config\Provider\IConfigProvider;
use Wl\Config\Provider\JsonFileProvider;
use Wl\Datasource\KeyValue\IStorage;
use Wl\Datasource\KeyValue\KeyDecoratedStorage;
use Wl\Datasource\KeyValue\Memcached\MemcachedClient;
use Wl\Datasource\KeyValue\Memcached\MemcachedServer;
use Wl\Db\Pdo\Config\IPdoConfig;
use Wl\Db\Pdo\Config\MysqlConfig;
use Wl\Db\Pdo\IManipulator;
use Wl\Db\Pdo\Manipulator;
use Wl\HttpClient\HttpClient;
use Wl\HttpClient\IHttpClient;
use Wl\User\CredentialsFactory;
use Wl\User\AccountService\IAccountService;
use Wl\User\AccountService\AccountService;
use Wl\User\AccountService\AccountValidationService;
use Wl\User\AccountService\Exception\AccountValidationException;
use Wl\User\AccountService\IAccountValidationService;
use Wl\User\AuthService\AuthService;
use Wl\User\AuthService\IAuthService;
use Wl\User\ICredentialsFactory;

return [
    "app.config.path" => "app/config/config.json",

    IConfigProvider::class => create(JsonFileProvider::class)
        ->constructor(get('app.config.path')),

    IConfig::class => get(ConfigService::class),

    IPdoConfig::class => function (IConfig $conf) {
        return new MysqlConfig(
            $conf->get("DB_MYSQL_HOST"),
            $conf->get("DB_MYSQL_DBNAME"),
            $conf->get("DB_MYSQL_USER"),
            $conf->get("DB_MYSQL_PASSWORD"),
        );
    },

    IStorage::class => function (IConfig $conf) {
        $mc = new MemcachedClient();
        $mc->addServer(
            new MemcachedServer(
                $conf->get("CACHE_MEMCACHED_HOST"),
                $conf->get("CACHE_MEMCACHED_PORT")
            )
        );
        $decorated = new KeyDecoratedStorage($mc, $conf->get("CACHE_MEMCACHED_PREFIX"));
        return $decorated;
    },

    IHttpClient::class => get(HttpClient::class),

    IManipulator::class => get(Manipulator::class),

    ShikimoriTransportConfig::class => function (IConfig $conf) {
        return new ShikimoriTransportConfig($conf->get("API_SHIKIMORI_APP_NAME"));
    },

    TmdbTransport::class => function (IHttpClient $httpClient, IConfig $conf) {
        return new TmdbTransport($httpClient, $conf->get("API_TMDB_KEY"));
    },

    IAccountService::class => get(AccountService::class),

    ICredentialsFactory::class => function (IConfig $conf) {
        return new CredentialsFactory($conf->get("AUTH_TOKEN_SALT"));
    },

    IAuthService::class => get(AuthService::class),

    IAccountValidationService::class => get(AccountValidationService::class),

];
