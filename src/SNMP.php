<?php

declare( strict_types = 1 );

namespace Ocolin\EasyMT;

use Exception;
use Ocolin\EasySNMP\EasySNMP;
use Ocolin\Env\EasyEnv;
use stdClass;

class SNMP
{
    private EasySNMP $client;

    const string MIKROTIK_MIB = '.1.3.6.1.4.1.14988.1.1.';


/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $ip IPv4 address. If b lank, env will be used
     * @param string $prefix Prefix to add to environment variable names
     * @param bool $local Use local .env file rather than external.
     * @throws Exception
     */
    public function __construct(
        ?string $ip     = null,
         string $prefix = '',
           bool $local  = true
    )
    {
        if( $local === true ) {
            EasyEnv::loadEnv( path: __DIR__ . '/../.env', append: true );
        }

        $ip = $ip ?? $prefix . $_ENV['_MT_IP'] ?? '127.0.0.1';
        $this->client = new EasySNMP( ip: $ip );
    }



/* GET A PORT ALIAS
----------------------------------------------------------------------------- */

    /**
     * @param int $index    Interface ID number
     * @return string|null  Name of port alias
     * @throws Exception
     */
    public function get_Port_Alias( int $index ) : string|null
    {
        $data = $this->client->get( oid: '.1.3.6.1.2.1.31.1.1.1.18.' . $index );

        return $data->value ?? null;
    }



/* GET ETHERNET PORTS
----------------------------------------------------------------------------- */

    /**
     * @return array<object> List of port information objects
     * @throws Exception
     */
    public function get_Ports() : array
    {
        $oid    = '.1.3.6.1.2.1.31.1.1.1';

        return $this->generic_Walk( oid: $oid, param_func: 'portParams' );
    }



/* GET ETHERNET INTERFACES
----------------------------------------------------------------------------- */

    /**
     * @return array<object> List of ethernet data objects
     * @throws Exception
     */
    public function get_Ethernet() : array
    {
        $oid    = '.1.3.6.1.2.1.2.2.1';

        return $this->generic_Walk( oid: $oid, param_func: 'ethernetParams' );
    }



/* GET PORT NAME
----------------------------------------------------------------------------- */

    /**
     * @param int $index Interface ID number
     * @return string|null Name of the port
     * @throws Exception
     */
    public function get_Port_Name( int $index ) : string|null
    {
        $oid = '.1.3.6.1.2.1.2.2.1.2.' . $index;
        $data = $this->client->get( oid: $oid );

        return $data->value ?? null;
    }


/* GET SYSTEM INFORMATION
----------------------------------------------------------------------------- */

    /**
     * @return stdClass Object of system related data
     * @throws Exception
     */
    public function get_System() : object
    {
        $output = new stdClass();
        $oid    = '.1.3.6.1.2.1.1';
        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts = explode( separator: '.', string: $row->oid );
            array_pop( array: $parts );
            $index = (int)array_pop( array: $parts );
            $param = Params::systemParams()[$index] ?? 'Unknown';

            $output->$param = $row->value;
        }

        return $output;
    }



/* GET IP ADDRESSES
----------------------------------------------------------------------------- */

    /**
     * @return array<string, object> List of IP data
     * @throws Exception
     */
    public function get_IPs() : array
    {
        $output = [];
        $oid    = '.1.3.6.1.2.1.4.20.1';
        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row ) {
            $data = str_replace(
                 search: '.1.3.6.1.2.1.4.20.1.',
                replace: '',
                subject: $row->oid
            );

            list( $param_id, $ip ) = explode(
                separator: '.',
                   string: $data,
                    limit: 2
            );
            $param = Params::ipParams()[$param_id] ?? 'Unknown';
            if( empty( $output[$ip] )) {$output[$ip] =  new stdClass(); }

            $output[$ip]->$param = $row->value;
        }

        return $output;
    }



/* GET ROUTES
----------------------------------------------------------------------------- */

    /**
     * @return array<string, object> List of route data objects
     * @throws Exception
     */
    public function get_Routes() : array
    {
        $output = [];
        $oid  = '.1.3.6.1.2.1.4.21.1';
        $rows = $this->client->walk( oid: $oid, numeric: true );

        // NOT SUPPORTED BY ALL MODELS
        if(
            count( $rows ) === 1 AND
            str_contains( haystack: $rows[0]->origin, needle: 'No Such Object' )
        ) {
            return $output;
        }

        foreach( $rows as $row )
        {
            $oid = str_replace(
                 search: '.1.3.6.1.2.1.4.21.1.',
                replace: '',
                subject: $row->oid
            );

            list( $index, $ip ) = explode( separator: '.', string: $oid, limit: 2 );

            if( empty( $output[$ip] )) {$output[$ip] =  new stdClass(); }

            $param = Params::routeParams()[$index] ?? 'Unknown';
            $output[$ip]->$param = $row->value;
        }

        return $output;
    }



/* GET MEDIA DATA
----------------------------------------------------------------------------- */

    /**
     * @return array<string, object> List of media data objects
     * @throws Exception
     */
    public function get_Media() : array
    {
        $output = [];
        $oid    = '.1.3.6.1.2.1.4.22.1';
        $types = [
            0 => '',
            1 => 'other',
            2 => 'invalid',
            3 => 'dynamic',
            4 => 'static'
        ];

        $rows  = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $oidp = str_replace(
                 search: '.1.3.6.1.2.1.4.22.1.',
                replace: '',
                subject: $row->oid
            );
            list( $index, $dnu, $ip ) = explode(
                separator: '.',
                   string: $oidp,
                    limit: 3
            );

            if( empty( $output[$ip] )) {$output[$ip] =  new stdClass(); }

            $param = Params::mediaParams()[$index] ?? 'Unknown';
            $output[$ip]->$param = $row->value;

            if( $index == 4 ) {
                $output[$ip]->TypeName = $types[$row->value];
            }
        }

        return $output;
    }



/* GET FORWARDING DATA
----------------------------------------------------------------------------- */

    /**
     * @return array<string, object> List of forward data objects
     * @throws Exception
     */
    public function get_Forward() : array
    {
        $output = [];
        $oid    = '.1.3.6.1.2.1.4.24.4.1';

        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $data = str_replace(
                 search: '.1.3.6.1.2.1.4.24.4.1.',
                replace: '',
                subject: $row->oid
            );
            list( $index, $id ) = explode( separator: '.', string: $data, limit: 2);
            $param = Params::forwardParams()[$index] ?? 'Unknown';

            if( empty( $output[$id] )) { $output[$id] = new stdClass(); }

            $output[$id]->$param = $row->value;
        }

        return $output;

    }



/* GET ARP TABLE
----------------------------------------------------------------------------- */

    /**
     * @return stdClass[] List of Arp data objects
     * @throws Exception
     */
    public function get_ARP() : array
    {
        $output = [];
        $oid = '.1.3.6.1.2.1.4.22.1.2';

        $rows  = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $data = str_replace(
                 search: '.1.3.6.1.2.1.4.22.1.2.',
                replace: '',
                subject: $row->oid
            );
            list( $id, $ip ) = explode( separator: '.', string: $data, limit: 2 );

            $obj = new stdClass();
            $obj->ip   = $ip;
            $obj->mac  = self::format_MAC( input: $row->value );
            $obj->port = (int)$id;
            $output[]  = $obj;
        }

        return $output;
    }



/* GET UPTIME
----------------------------------------------------------------------------- */

    /**
     * @return stdClass Object of uptime data
     * @throws Exception
     */
    public function get_Uptime() : object
    {
        $output = new stdClass();
        $oid = '.1.3.6.1.2.1.25.1';

        $rows  = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts = explode( separator: '.', string: $row->oid );
            array_pop( array: $parts );
            $id = (int)array_pop( array: $parts );
            $param = Params::uptimeParams()[$id] ?? 'Unknown';

            $output->$param = $row->value;
        }

        return $output;
    }



/* GET STORAGE DATA
----------------------------------------------------------------------------- */

    /**
     * @return array<int, stdClass> List of storage data objects
     * @throws Exception
     */
    public function get_Storage() : array
    {
        $oid = '.1.3.6.1.2.1.25.2.3.1';

        return $this->generic_Walk( oid: $oid, param_func: 'storageParams' );
    }



/* GET PROCESSOR DATA
----------------------------------------------------------------------------- */

    /**
     * @return array<int, object> List of processor data objects
     * @throws Exception
     */
    public function get_Processor() : array
    {
        $statuses = [
            0 => 'unknown',
            1 => 'unknown',
            2 => 'running',
            3 => 'warning',
            4 => 'testing',
            5 => 'down'
        ];
        $output = [];
        $oid    = '.1.3.6.1.2.1.25.3';

        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts  = explode( separator: '.', string: $row->oid );
            list( $section, $dnu, $column, $id ) = array_slice(
                 array: $parts,
                offset: -4,
                length: 4
            );
            $id = (int)$id;

            $param = $section == 2
                ? Params::hrDeviceParams()[$column]
                : Params::processorParams()[$column];

            if( empty( $output[$id] )) { $output[$id] = new stdClass(); }

            $output[$id]->$param = $row->value;

            if( $section == 2 AND $column == 5 ) {
                $output[$id]->StatusName = $statuses[$row->value];
            }
        }

        return $output;
    }



/* GET ORGANIZATION DATA
----------------------------------------------------------------------------- */

    /**
     * @return array<int, object> Object of organization data
     * @throws Exception
     */
    public function get_Org() : array
    {
        $oid = '.1.3.6.1.2.1.47.1.1.1.1';

        return $this->generic_Walk( oid: $oid, param_func: 'orgParams' );
    }



/* GET POWER INFORMATION
----------------------------------------------------------------------------- */

    /**
     * Only works for some MTs
     * @return object Object of power data objects
     * @throws Exception
     */
    public function get_Power() : object
    {
        $output = new stdClass();
        $oid    = self::MIKROTIK_MIB . '3';
        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts = explode( separator: '.', string: $row->oid );
            array_pop( array: $parts );
            $index = (int)array_pop( array: $parts );
            $param = Params::powerParams()[$index] ?? 'Unknown';

            $output->$param = $row->value;
        }

        return $output;
    }



/* GET MIKROTIK HEALTH INFORMATION
----------------------------------------------------------------------------- */

    /**
     * Not supported on 1036.
     *
     * @return object Object of health data/values
     * @throws Exception
     */
    public function get_Health() : object
    {
        $output = new stdClass();
        $oid    = self::MIKROTIK_MIB . '3.100.1';

        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts    = explode( separator: '.', string: $row->oid );
            $index    = (int)array_pop( array: $parts );
            $param_id = (int)array_pop( array: $parts );
            $param    = Params::healthParams()[$index] ?? 'Unknown';

            switch( $param_id )
            {
                case 2:
                    $output->$param = new stdClass();
                    break;
                case 3:
                    $output->$param->Value = $row->value;
                    break;
                case 4:
                    $output->$param->Unit = $row->value;
                    $output->$param->UnitName = Params::mtUnits()[$row->value];
                    break;
            }
        }

        return $output;
    }



/* GET LICENSE DATA
----------------------------------------------------------------------------- */

    /**
     * @return stdClass Licensing data object
     * @throws Exception
     */
    public function get_Lisc() : object
    {
        $output = new stdClass();
        $oid = self::MIKROTIK_MIB . '4';
        $rows = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts = explode( separator: '.', string: $row->oid );
            list( $id, $dnu ) = array_slice(
                 array: $parts,
                offset: -2,
                length: 2
            );
            $param = Params::liscParams()[$id] ?? 'Unknown';
            $output->$param = $row->value;
        }

        return $output;
    }



/* GET OS INFORMATION
----------------------------------------------------------------------------- */

    /**
     * @return stdClass Object of OS related data
     * @throws Exception
     */
    public function get_OS() : object
    {
        $output = new stdClass();
        $oid    = self::MIKROTIK_MIB . '7';
        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts = explode( separator: '.', string: $row->oid );
            array_pop( array: $parts );
            $index = array_pop( array: $parts );
            $param = Params::osParams()[$index] ?? 'Unknown';

            if( is_string( $row->value )) {
                $row->value = str_replace(
                    search: '"',
                    replace: '',
                    subject: $row->value
                );
            }

            $output->$param = $row->value;
        }

        return $output;
    }



/* GET NEIGHBOR DATA
----------------------------------------------------------------------------- */

    /**
     * @return array<int, object> List of Neighbors
     * @throws Exception
     */
    public function get_Neighbors() : array
    {
        $oid = self::MIKROTIK_MIB . '11';

        return $this->generic_Walk( oid: $oid, param_func: 'neighborParams' );
    }



/* GET INTERFACE STATISTICS
----------------------------------------------------------------------------- */

    /**
     * @return array<int, object> List of interface stat data objects
     * @throws Exception
     */
    public function get_IfStats() : array
    {
        $oid = self::MIKROTIK_MIB . '14';

        return $this->generic_Walk( oid: $oid, param_func: 'ifStatParams' );
    }


/* GET PARTITION DATA
----------------------------------------------------------------------------- */

    /**
     * @return object[] List of Partition data objects
     * @throws Exception
     */
    public function get_Partitions() : array
    {
        $oid = self::MIKROTIK_MIB . '17';

        return $this->generic_Walk( oid: $oid, param_func: 'partitionParams' );
    }


/* GENERIC TREE WALK
----------------------------------------------------------------------------- */

    /**
     * @param string $oid SNMP OID
     * @param string $param_func Name of function to get parameter names
     * @return array<int, object> List of data objects
     * @throws Exception
     */
    protected function generic_Walk( string $oid, string $param_func ) : array
    {
        $output = [];
        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            $parts = explode( separator: '.', string: $row->oid );
            list( $column, $id ) = array_slice(
                array: $parts,
                offset: -2,
                length: 2
            );
            $id = (int)$id;

            $param = Params::$param_func()[$column] ?? 'Unknown';
            if( empty( $output[$id])) {
                $output[$id] = new stdClass();
            }

            $output[$id]->$param = $row->value;
        }

        return $output;
    }

/* GET OPTICAL DATA
----------------------------------------------------------------------------- */

    /**
     * @return array<int, object> List of Optical data object
     * @throws Exception
     */
    public function get_Optical() : array
    {
        $output = [];
        $oid = self::MIKROTIK_MIB . '19';

        $rows   = $this->client->walk( oid: $oid, numeric: true );
        foreach( $rows as $row )
        {
            if( str_contains( haystack: $row->origin, needle: 'No more variables' )) {
                continue;
            }

            $parts = explode( separator: '.', string: $row->oid );
            list( $column, $id ) = array_slice(
                array: $parts,
                offset: -2,
                length: 2
            );
            $id = (int)$id;
            $param = Params::opticalParam()[$column] ?? 'Unknown';

            if( empty( $output[$id])) {
                $output[$id] = new stdClass();
            }

            $output[$id]->$param = $row->value;
        }

        return $output;
    }


/* GET DHCP LEASE COUNT
----------------------------------------------------------------------------- */

    /**
     * @return int Number of DHCP leases
     * @throws Exception
     */
    public function leaseCount() : int
    {
        $data = $this->client->get( oid: self::MIKROTIK_MIB . '6.1.0' );

        return (int)$data->value;
    }



/* FORMAT A MAC ADDRESS - MIKROTIKS LEAVE OUT LEADING ZEROS
----------------------------------------------------------------------------- */

    /**
     * @param string $input Raw MAC address
     * @return string Formatted MAC address
     */
    public static function format_MAC( string $input ) : string
    {
        $parts = explode( separator: ':', string: $input );
        foreach( $parts as $key => $part )
        {
            $parts[$key] = strtoupper( $part );
            if( strlen( $part ) === 1 ) {
                $parts[$key] = '0' . $parts[$key];
            }
        }

        return implode( separator: ':', array: $parts );
    }
}