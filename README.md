# About
This library provides a simple and basic interface to useing evilfreelancer's RouterOS API as well as SNMP calls for Mikrotik devices.

## Requirements

PHP 8.3+

## Adding a composer module:

In your composer.json
``` 
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ocolin/EasySNMP"
        }
    ],
```

Then run

``` 
composer require ocolin/eastmt
```

# API

Most of the funcionality comes from:

https://github.com/EvilFreelancer/routeros-api-php

This wrapper simply allows you to use environment variables in advance.

## Settings

### Arguments

Any host related arguments such as IP will take precedent the config file or environment variables

### Environment Variables 

Environment variables will override any settings from the default config file. A prefix is required so that multiple entries can be stored. The prefix will be appended to the beginning of the environment variable used. Here are the defaults:


With prefix 'EXAMPLE1':

```
$_ENV['EXAMPLE1_MT_IP'];
$_ENV['EXAMPLE1_MT_USER'];
$_ENV['EXAMPLE1_MT_PASS'];
```

### Default config file

You can also edit **src/config.json** if you don't want to use arguments or environment variables. This will however only allow for a single device to be used.

## Examples

### Example 1: Using settings in config.json

```php
use Ocolin\EasyMT\API;

$output = API::query( '/ip/arp/print' )->read();
```

### Example 2: Using parameters:

``` php
use Ocolin\EasyMT\API;

$output = API::query(
        endpoint: '/ip/arp/print',
        where: [
            ['address', '127.0.0.1'],
            ['address', '127.0.0.2']
        ],
        operations: '|'
)->read();
```

### Example 3: Using environment variables

``` php
use Ocolin\EasyMT\API;

$_ENV['EXAMPLE_MT_IP']   = '127.0.0.1';
$_ENV['EXAMPLE_MT_USER'] = 'admin';
$_ENV['EXAMPLE_MT_PASS'] = 'pass';

$output = API::query(
    endpoint: '/ip/arp/print',
      prefix: 'EXAMPLE'
)->read();

```

### Example 4: Using argument ip and local environment variables

``` php
use Ocolin\EasyMT\API;

$output = API::query(
    endpoint: '/ip/arp/print',
      prefix: 'EXAMPLE',
       local: true
)->read();
```



# SNMP

## Calls

| Function          | Description                             |
|-------------------|-----------------------------------------|
| port_Alias( int ) | Get name of alias for a port            |
| ports()           | Get list of port information            |
| ethernet()        | Get list of ethernet interface data     |
| port_Name( int )  | Get name of a port                      |
| system()          | Get system information                  |
| iPs()             | List of IP address information          |
| routes()          | List of IP routes                       |
| media()           | List of Media information               |
| forward()         | List of forwarding entries              |
| ARP()             | List ARP table                          |
| uptime()          | Uptime infromation                      |
| storage()         | List of storage information             |
| processor()       | Processor information                   |
| organization()    | List of orgnaization information        |
| dot1dTpFdbEntry() | List of bridge forwarding information   |
| power()           | List of power related information       |
| health()          | Device health information               |
| license()         | License information                     |
| os()              | Information about OS                    |
| neighbors()       | List of neighbor information            |
| ifStats()         | List of interface statistic information |
| partitions()      | List of partition information           |
| optical()         | List of optical interface information   |
| leaseCount()      | Get number of DHCP leases               |

## Example

### Example 1: Using environment variable

```php
use Ocolin\EasyMT\SNMP;

$_ENV['EXAMPLE1_SNMP_COMMUNITY'] = public;
$_ENV['EXAMPLE1_SNMP_VERSION'] = 2;
$_ENV['EXAMPLE1_MT_IP'] = '127.0.0.1';

$snmp = new \Ocolin\EasyMT\SNMP(
    prefix: 'EXAMPLE1'
);

$output = $snmp->health();
```

### Example 2: Using argument variables

```php
use Ocolin\EasyMT\SNMP;

$snmp = new \Ocolin\EasyMT\SNMP(
           ip: '127.0.0.1',
    community: 'public',
      version: 2
);

$output = $snmp->health();
```

### Example 3: Using default SNMP settings

```php
use Ocolin\EasyMT\SNMP;

$snmp = new \Ocolin\EasyMT\SNMP(
    ip: '127.0.0.1'
);
$output = $snmp->health();
```
### Example Output:

```php
stdClass Object
(
    [temperature] => stdClass Object
        (
            [Value] => 27
            [Unit] => 1
            [UnitName] => celsius
        )

    [cpu-temperature] => stdClass Object
        (
            [Value] => 48
            [Unit] => 1
            [UnitName] => celsius
        )

    [fan1-speed] => stdClass Object
        (
            [Value] => 4200
            [Unit] => 2
            [UnitName] => rpm
        )

    [fan2-speed] => stdClass Object
        (
            [Value] => 3990
            [Unit] => 2
            [UnitName] => rpm
        )

    [psu1-state] => stdClass Object
        (
            [Value] => 0
            [Unit] => 6
            [UnitName] => status
        )

    [psu2-state] => stdClass Object
        (
            [Value] => 1
            [Unit] => 6
            [UnitName] => status
        )
)

```