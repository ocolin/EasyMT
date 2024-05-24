<?php

declare( strict_types = 1 );

namespace Ocolin\EasyMT;

class Params
{

/* PORT PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function portParams() : array
    {
        return [
            1  => 'Name',
            2  => 'InMulticastPkts',
            3  => 'InBroadcastPkts',
            4  => 'OutMulticastPkts',
            5  => 'OutBroadcastPkts',
            6  => 'HCInOctets',
            7  => 'HCInUcastPkts',
            8  => 'HCInMulticastPkts',
            9  => 'HCInBroadcastPkts',
            10 => 'HCOutOctets',
            11 => 'HCOutUcastPkts',
            12 => 'HCOutMulticastPkts',
            13 => 'HCOutBroadcastPkts',
            14 => 'LinkUpDownTrapEnable',
            15 => 'HighSpeed',
            16 => 'PromiscuousMode',
            17 => 'ConnectorPresent',
            18 => 'Alias',
            19 => 'CounterDiscontinuityTime'
        ];
    }


/* ETHERNET PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function ethernetParams() : array
    {
        return [
            1 => 'Index',
            2 => 'Descr',
            3 => 'Type',
            4 => 'Mtu',
            5 => 'Speed',
            6 => 'PhysAddress',
            7 => 'AdminStatus',
            8 => 'OperStatus',
            9 => 'LastChange',
            10 => 'InOctets',
            11 => 'InUcastPkts',
            12 => 'InNUcastPkts',
            13 => 'InDiscards',
            14 => 'InErrors',
            15 => 'InUnknownProtos',
            16 => 'OutOctets',
            17 => 'OutUcastPkts',
            18 => 'OutNUcastPkts',
            19 => 'OutDiscards',
            20 => 'OutErrors',
            21 => 'OutQLen',
            22 => 'Specific'
        ];
    }


/* HEALTH PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function healthParams() : array
    {
        return [
            14   => 'temperature',
            17   => 'cpu-temperature',
            7001 => 'fan1-speed',
            7002 => 'fan2-speed',
            7401 => 'psu1-state',
            7402 => 'psu2-state'
        ];
    }


/* POWER PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function powerParams() : array
    {
        return [
            1  => 'CoreVoltage',
            2  => 'ThreeDotThreeVoltage',
            3  => 'FiveVoltage',
            4  => 'TwelveVoltage',
            5  => 'SensorTemperature',
            6  => 'CpuTemperature',
            7  => 'BoardTemperature',
            8  => 'Voltage',
            9  => 'ActiveFan',
            10 => 'Temperature',
            11 => 'ProcessorTemperature',
            12 => 'Power',
            13 => 'Current',
            14 => 'ProcessorFrequency',
            15 => 'PowerSupplyState',
            16 => 'BackupPowerSupplyState',
            17 => 'FanSpeed1',
            18 => 'FanSpeed2'
        ];
    }


/* SYSTEM PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function systemParams() : array
    {
        return [
            1 => 'Descr',
            2 => 'ObjectID',
            3 => 'UpTime',
            4 => 'Contact',
            5 => 'Name',
            6 => 'Location',
            7 => 'Services',
            8 => 'ORLastChange',
            9 => 'ORTable'
        ];
    }


/* OS PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function osParams() : array
    {
        return [
            1 => 'SystemReboot',
            2 => 'USBPowerReset',
            3 => 'SerialNumber',
            4 => 'FirmwareVersion',
            5 => 'Note',
            6 => 'BuildTime',
            7 => 'FirmwareUpgradeVersion',
            8 => 'DisplayName',
            9 => 'BoardName'
        ];
    }


/* IP PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function ipParams() : array
    {
        return [
            1 => 'Addr',
            2 => 'IfIndex',
            3 => 'NetMask',
            4 => 'BcastAddr',
            5 => 'ReasmMaxSize',
        ];
    }


/* ROUTE PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function routeParams() : array
    {
        return [
            1  => 'Dest',
            2  => 'IfIndex',
            3  => 'Metric1',
            4  => 'Metric2',
            5  => 'Metric3',
            6  => 'Metric4',
            7  => 'NextHop',
            8  => 'Type',
            9  => 'Proto',
            10 => 'Age',
            11 => 'Mask',
            12 => 'Metric5',
            13 => 'Info',
            14 => 'LocalIfIndex',
            15 => 'DefaultFlag',
            16 => 'PrivateFlag',
            17 => 'RipCost',
            18 => 'Preference',
            19 => 'Strategy'
        ];
    }


/* MEDIA PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function mediaParams() : array
    {
        return [
            1 => 'IfIndex',
            2 => 'PhysAddress',
            3 => 'NetAddress',
            4 => 'Type'
        ];
    }


/* FORWARD PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function forwardParams() : array
    {
        return [
            1  => 'Dest',
            2  => 'Mask',
            3  => 'Tos',
            4  => 'NextHop',
            5  => 'IfIndex',
            6  => 'Type',
            7  => 'Proto',
            8  => 'Age',
            9  => 'Info',
            10 => 'NextHopAS',
            11 => 'Metric1',
            12 => 'Metric2',
            13 => 'Metric3',
            14 => 'Metric4',
            15 => 'Metric5',
            16 => 'Status'
        ];
    }


/* ARP PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function arpParams() : array
    {
        return [
            1 => 'IfIndex',
            3 => 'NetAddress',
            4 => 'Type'
        ];
    }


/* UPTIME PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function uptimeParams() : array
    {
        return [
            1   => 'Uptime',
            2   => 'Date',
            3   => 'InitialLoadDevice',
            4   => 'InitialLoadParameters',
            5   => 'NumUsers',
            6   => 'Processes',
            7   => 'MaxProcesses',
            100 => 'CurrentLoadDevice',
            101 => 'DefaultPermanentStorageDevice'
        ];
    }


/* STORAGE PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function storageParams() : array
    {
        return [
            1 => 'Index',
            2 => 'Type',
            3 => 'Descr',
            4 => 'AllocationUnits',
            5 => 'Size',
            6 => 'Used',
            7 => 'AllocationFailures'
        ];
    }


/* DEVICE PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function hrDeviceParams() : array
    {
        return [
            1 => 'DeviceIndex',
            2 => 'DeviceType',
            3 => 'DeviceDescr',
            4 => 'DeviceID',
            5 => 'DeviceStatus',
            6 => 'DeviceErrors',
        ];
    }


/* PROCESSOR PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function processorParams() : array
    {
        return [
            1 => 'ProcessorFrwID',
            2 => 'ProcessorLoad'
        ];
    }


/* ORGANIZATION PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function orgParams() : array
    {
        return [
            1  => 'Index',
            2  => 'Descr',
            3  => 'VendorType',
            4  => 'ContainedIn',
            5  => 'Class',
            6  => 'ParentRelPos',
            7  => 'Name',
            8  => 'HardwareRev',
            9  => 'FirmwareRev',
            10 => 'SoftwareRev',
            11 => 'SerialNum',
            12 => 'MfgName',
            13 => 'ModelName',
            14 => 'Alias',
            15 => 'AssetID',
            16 => 'IsFRU',
            17 => 'MfgDate',
            18 => 'Uris',
            19 => 'UUID',
        ];
    }


/* LIST OF INTERFACE STATISTICS PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function ifStatParams() : array
    {
        return [
            1 => 'Index',
            2 => 'Name',
            11 => 'DriverRxBytes',
            12 => 'DriverRxPackets',
            13 => 'DriverTxBytes',
            14 => 'DriverTxPackets',
            15 => 'TxRx64',
            16 => 'TxRx65To127',
            17 => 'TxRx128To255',
            18 => 'TxRx256To511',
            19 => 'TxRx512To1023',
            20 => 'TxRx1024To1518',
            21 => 'TxRx1519ToMax',
            31 => 'RxBytes',
            32 => 'RxPackets',
            33 => 'RxTooShort',
            34 => 'Rx64',
            35 => 'Rx65To127',
            36 => 'Tx128To255',
            37 => 'Rx256To511',
            38 => 'Rx512To1023',
            39 => 'Rx1024To1518',
            40 => 'Rx1519ToMax',
            41 => 'RxTooLong',
            42 => 'RxBroadcast',
            43 => 'RxPause',
            44 => 'RxMulticast',
            45 => 'RxFCSError',
            46 => 'RxAlignError',
            47 => 'RxFragment',
            48 => 'RxOverflow',
            49 => 'RxControl',
            50 => 'RxUnknownOp',
            51 => 'RxLengthError',
            52 => 'RxCodeError',
            53 => 'RxCarrierError',
            54 => 'RxJabber',
            55 => 'RxDrop',
            61 => 'TxBytes',
            62 => 'TxPackets',
            63 => 'TxTooShort',
            64 => 'Tx64',
            65 => 'Tx65To127',
            66 => 'Tx128To255',
            67 => 'Tx256To511',
            68 => 'Tx512To1023',
            69 => 'Tx1024To1518',
            70 => 'Tx1519ToMax',
            71 => 'TxTooLong',
            72 => 'TxBroadcast',
            73 => 'TxPause',
            74 => 'TxMulticast',
            75 => 'TxUnderrun',
            76 => 'TxCollision',
            77 => 'TxExcessiveCollision',
            78 => 'TxMultipleCollision',
            79 => 'TxSingleCollision',
            80 => 'TxExcessiveDeferred',
            81 => 'TxDeferred',
            82 => 'TxLateCollision',
            83 => 'TxTotalCollision',
            84 => 'TxPauseHonored',
            85 => 'TxDrop',
            86 => 'TxJabber',
            87 => 'TxFCSError',
            88 => 'TxControl',
            89 => 'TxFragment',
            90 => 'LinkDowns',
            91 => 'TxRx1024ToMax',
        ];
    }



/* OPTICAL PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function opticalParam() : array
    {
        return [
            2  => 'Name',
            3  => 'RxLoss',
            4  => 'TxFault',
            5  => 'Wavelength',     # nm
            6  => 'Temperature',    # C
            7  => 'SupplyVoltage',  # V
            8  => 'BiasCurrent',    # mA
            9  => 'TxPower',        # dBm
            10 => 'RxPower',        # dBm
            11 => 'VendorName'
        ];
    }



/* LICENSE PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function liscParams() : array
    {
        return [
            1 => 'LicSoftwareId',
            2 => 'LicUpgrUntil',
            3 => 'LicLevel',
            4 => 'LicVersion',
            5 => 'LicUpgradableTo'
        ];
    }



/* NEIGHBOR PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function neighborParams() : array
    {
        return [
            1 => 'Index',
            2 => 'IpAddress',
            3 => 'MacAddress',
            4 => 'Version',
            5 => 'Platform',
            6 => 'Identity',
            7 => 'SoftwareID',
            8 => 'InterfaceID'
        ];
    }


/* PARTITION PARAMS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    final public static function partitionParams() : array
    {
        return [
            1 => 'Name',
            2 => 'Size',
            3 => 'Version',
            4 => 'Active',
            5 => 'Running'
        ];
    }


/* MIKROTIK UNITS
----------------------------------------------------------------------------- */

    /**
     * @return string[]
     */
    public static function mtUnits() : array
    {
        return [
            1 => 'celsius',
            2 => 'rpm',
            3 => 'dV',
            4 => 'dA',
            5 => 'dW',
            6 => 'status'
        ];
    }
}