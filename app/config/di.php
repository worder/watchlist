<?php

use function DI\create;
use function DI\get;
use function Di\autowire;

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
use Wl\Http\HttpService\HttpService;
use Wl\Http\HttpService\IHttpService;
use Wl\HttpClient\HttpClient;
use Wl\HttpClient\IHttpClient;
use Wl\Lists\ListItems\ListItemsService\IListItemsService;
use Wl\Lists\ListItems\ListItemsService\ListItemsService;
use Wl\Lists\Subscription\ListSubscriptionService\IListSubscriptionService;
use Wl\Lists\ListService\IListService;
use Wl\Lists\ListService\ListService;
use Wl\Lists\Subscription\ListSubscriptionService\ListSubscriptionService;
use Wl\Media\MediaCacheService\IMediaCacheService;
use Wl\Media\MediaCacheService\MediaCacheService;
use Wl\Session\ISession;
use Wl\Session\Session;
use Wl\User\CredentialsFactory;
use Wl\User\AccountService\IAccountService;
use Wl\User\AccountService\AccountService;
use Wl\User\AuthService\AuthService;
use Wl\User\AuthStorage\AuthCookieStorage;
use Wl\User\AuthStorage\AuthSessionStorage;
use Wl\User\AuthStorage\IAuthStorage;
use Wl\User\AuthService\IAuthService;
use Wl\User\AuthStorage\AuthCompositeStorage;
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
  
    IManipulator::class => function (Manipulator $manipulator) {
        $manipulator->exec('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
        return $manipulator;
    },

    IStorage::class => function (IConfig $conf) {
        $mc = new MemcachedClient();
        $mc->addServer(
            new MemcachedServer(
                $conf->get("CACHE_MEMCACHED_HOST"),
                $conf->get("CACHE_MEMCACHED_PORT")
            )
        );
        return new KeyDecoratedStorage($mc, $conf->get("CACHE_MEMCACHED_PREFIX"));
    },

    ISession::class => get(Session::class),

    IHttpClient::class => get(HttpClient::class),

    IHttpService::class => get(HttpService::class),

    IListService::class => get(ListService::class),

    IListSubscriptionService::class => get(ListSubscriptionService::class),

    IListItemsService::class =>get(ListItemsService::class),

    IMediaCacheService::class => get(MediaCacheService::class),

    // API clients
    // ShikimoriTransportConfig::class => function (IConfig $conf) {
    //     return new ShikimoriTransportConfig($conf->get("API_SHIKIMORI_APP_NAME"));
    // },

    // TmdbTransport::class => function (IHttpClient $httpClient, IConfig $conf) {
    //     return new TmdbTransport($httpClient, $conf->get("API_TMDB_KEY"));
    // },

    // auth and accounts
    IAccountService::class => get(AccountService::class),
    IAuthService::class => get(AuthService::class),

    IAuthStorage::class => autowire(AuthCompositeStorage::class)
        ->constructor([
            get(AuthSessionStorage::class),
            get(AuthCookieStorage::class),
        ]),

    ICredentialsFactory::class => function (IConfig $conf) {
        return new CredentialsFactory($conf->get("AUTH_TOKEN_SALT"));
    }
];
