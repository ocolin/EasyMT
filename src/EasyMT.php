<?php

declare( strict_types =1 );

namespace Ocolin\EasyMT;

use Exception;
use Ocolin\Env\EasyEnv;
use RouterOS;
use RouterOS\Interfaces\ClientInterface;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\QueryException;

class EasyMT
{
    private object $config;

    private RouterOS\Client $client;

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string $prefix Prefix name to append to environment variable names
     * @param bool $local Load environment from local .env file. Meant for standalone use.
     * @param string|null $ip IPv4 Address. Using this will override environment.
     * @throws ClientException
     * @throws ConfigException
     * @throws QueryException
     * @throws RouterOS\Exceptions\BadCredentialsException
     * @throws RouterOS\Exceptions\ConnectException
     * @throws Exception
     */
    public function __construct(
        readonly private string $prefix,
        readonly private bool   $local = false,
        readonly private ?string $ip = null
    )
    {
        $this->load_Default_config();
        $this->localEnv();
        $this->set_Config();
        $this->validate_IP();

        $client = new RouterOS\Config((array)$this->config);
        $this->client = new RouterOS\Client( $client );
    }


/* QUERY DEVICE
----------------------------------------------------------------------------- */

    /**
     * @param string $prefix Name of prefix to add to environment parameters
     * @param string $endpoint Path of RouterOS module
     * @param string|null $ip IPv4 Address. This will override environment ip settings
     * @param array<array<string,string|int>>|null $where
     * @param string|null $operations Specify operator (and/or, etc) for where clause
     * @param string|null $tag
     * @param bool $local Load environment variables from local .env file.
     *      For use as standalone library
     * @return ClientInterface
     * @throws ClientException
     * @throws ConfigException
     * @throws QueryException
     */
    public static function query(
         string $prefix,
         string $endpoint,
        ?string $ip         = null,
         ?array $where      = null,
        ?string $operations = null,
        ?string $tag        = null,
           bool $local      = false,
    ) : ClientInterface
    {
        $o = new self(
            prefix: $prefix,
             local: $local,
                ip: $ip
        );

        return $o->client->query(
              endpoint: $endpoint,
                 where: $where,
            operations: $operations,
                   tag: $tag
        );
    }



/* LOAD LOCAL ENVIRONMENT VARIABLES
----------------------------------------------------------------------------- */

    /**
     * @throws Exception
     */
    private function localEnv() : void
    {
        if( $this->local === true ) {
            EasyEnv::loadEnv( path: __DIR__ . '/../.env', append: true );
        }
    }



/* LOAD DEFAULT CONFIGURATION SETTINGS FROM JSON FILE
----------------------------------------------------------------------------- */

    private function load_Default_config() : void
    {
        $this->config = (object)json_decode(
            json: (string)file_get_contents( filename: __DIR__ . '/config.json' )
        );

        $this->config->ssl_options = (array)$this->config->ssl_options;
    }



/* VALIDATE IPV4 IP ADDRESS
----------------------------------------------------------------------------- */

    /**
     * @throws Exception
     */
    private function validate_IP() : void
    {
        if( !filter_var(
              value: $this->config->host,
             filter: FILTER_VALIDATE_IP,
            options: FILTER_FLAG_IPV4
        )) {
            throw new Exception( message: "{$this->config->host} is not a valid IPv4 address." );
        }
    }



/* SET CONFIGURATION SETTINGS
----------------------------------------------------------------------------- */

    private function set_Config() : void
    {
        $this->config->host =  $this->ip ?? $_ENV[ $this->prefix . '_MT_IP'] ?? $this->config->host;
        $this->config->user = $_ENV[ $this->prefix . '_MT_USER'] ?? $this->config->user;
        $this->config->pass = $_ENV[ $this->prefix . '_MT_PASS'] ?? $this->config->user;
    }
}