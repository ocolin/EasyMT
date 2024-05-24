# About
This library provides a simple and basic interface to usein evilcoder's RouterOS AP as well as SNMP calls for Mikrotik devices.

# SNMP

## Calls

| Function | Description |
| -------- | ----------- |
| port_Alias( $id ) | Get name of alias for a port |
| ports() | Get list of port information |
| ethernet() | Get list of ethernet interface data |
| port_Name( $id ) | Get name of a port |
| system() | Get system information |
| iPs() | list of IP address information |
| routes() | List of IP routes |
| media() | List of Media information |
| forward() | List of forwarding entries |
| ARP() | List ARP table |
| uptime() | Uptime infromation |
| storage() | List of storage information |
| processor() | Processor information |
| organization() | List of orgnaization information |
| dot1dTpFdbEntry() | List of bridge forwarding information |
| power() | List of power related information |
| health() | Device health information |
| license() | License information |
| os() | Information about OS |
| neighbors() | List of neighbor information |
| ifStats() | List of interface statistic information |
| partitions() | List of partition information |
| optical() | List of optical interface information |
| leaseCount() | Get number of DHCP leases |

## Example

### Example 1: Get Ethernet Interfaces

```
$_ENV['EXAMPLE_SNMP_COMMUNITY'] = public;
$_ENV['EXAMPLE_SNMP_VERSION'] = 2;
$_ENV['EXAMPLE_MT_IP'] = '127.0.0.1';

$snmp = new \Ocolin\EasyMT\SNMP(
    prefix: 'EXAMPLE'
);

$output = $snmp->health();
```