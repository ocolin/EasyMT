# About
This library provides a simple and basic interface to usein evilcoder's RouterOS AP as well as SNMP calls for Mikrotik devices.

## Requirements

PHP 8.3+

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

```
$_ENV['EXAMPLE1_SNMP_COMMUNITY'] = public;
$_ENV['EXAMPLE1_SNMP_VERSION'] = 2;
$_ENV['EXAMPLE1_MT_IP'] = '127.0.0.1';

$snmp = new \Ocolin\EasyMT\SNMP(
    prefix: 'EXAMPLE1'
);

$output = $snmp->health();
```

### Example 2: Using argument variables

```
$snmp = new \Ocolin\EasyMT\SNMP(
           ip: '127.0.0.1',
    community: 'public',
      version: 2
);

$output = $snmp->health();
```

### Example 3: Using default SNMP settings

```
$snmp = new \Ocolin\EasyMT\SNMP(
    ip: '127.0.0.1'
);
$output = $snmp->health();
```
### Example Output:

``` 
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