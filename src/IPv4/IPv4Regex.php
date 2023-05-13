<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

/**
 * @codeCoverageIgnore
 */
final readonly class IPv4Regex
{
    private const ADDRESS_DEFINITION = '(?<'.self::ADDRESS_CAPTURING_GROUPS[0].'>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)\.(?<'.self::ADDRESS_CAPTURING_GROUPS[1].'>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)\.(?<'.self::ADDRESS_CAPTURING_GROUPS[2].'>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)\.(?<'.self::ADDRESS_CAPTURING_GROUPS[3].'>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)';

    private const NETMASK_DEFINITION = '(?<'.self::NETMASK_CAPTURING_GROUPS[0].'>0|128|192|224|240|248|252|254|255)\.(?<'.self::NETMASK_CAPTURING_GROUPS[1].'>0|128|192|224|240|248|252|254|255)\.(?<'.self::NETMASK_CAPTURING_GROUPS[2].'>0|128|192|224|240|248|252|254|255)\.(?<'.self::NETMASK_CAPTURING_GROUPS[3].'>0|128|192|224|240|248|252|254|255)';

    private const CIDR_DEFINITION = '\/(?<'.self::CIDR_CAPTURING_GROUP.'>0|[1-9]|[1-2]\d|3[0-2])';

    /**
     * @var array<string> The address octets capturing group names.
     */
    public const ADDRESS_CAPTURING_GROUPS = [
        'octet1', 'octet2', 'octet3', 'octet4',
    ];

    /**
     * @var string The netmask capturing group name (regardless of format).
     */
    public const NETMASK_CAPTURING_GROUP = 'netmask';

    /**
     * @var array<string> The netmask octets capturing group names.
     */
    public const NETMASK_CAPTURING_GROUPS = [
        'netmask1', 'netmask2', 'netmask3', 'netmask4',
    ];

    /**
     * @var string The netmask CIDR capturing group name.
     */
    public const CIDR_CAPTURING_GROUP = 'bits';

    /**
     * @var string The capturing regex for an IPv4 address that supports the following formats:
     *  1) Traditional: "<octet1>.<octet2>.<octet3>.<octet4>{optional:{space}<netmask1>.<netmask2>.<netmask3>.<netmask4>}"
     *  2) CIDR: "<octet1>.<octet2>.<octet3>.<octet4>{optional:{optional:{space}/<bits>}"
     * and captures the matches in the following capturing group names:
     *  - <self::ADDRESS_CAPTURING_GROUPS> (address octets)
     *  - <self::NETMASK_CAPTURING_GROUP> (the netmask in the given format)
     *  - <self::NETMASK_CAPTURING_GROUPS> (the netmask octets)
     *  - <self:CIDR_CAPTURING_GROUP> (the CIDR netmask bits)
     */
    public const ADDRESS = '%^'.self::ADDRESS_DEFINITION.'(?:(?: )?(?<'.self::NETMASK_CAPTURING_GROUP.'>'.self::NETMASK_DEFINITION.'|'.self::CIDR_DEFINITION.'))?$%';

    /**
     * @var string The capturing regex for netmask that supports the following formats:
     *  1) Traditional: "<netmask1>.<netmask2>.<netmask3>.<netmask4>"
     *  2) CIDR: "/<bits>"
     * and captures the matches in the following capturing group names:
     *  - <self::NETMASK_CAPTURING_GROUPS> (the netmask octets)
     *  - <self:CIDR_CAPTURING_GROUP> (the CIDR netmask bits)
     */
    public const NETMASK = '%^(?: )?(?<'.self::NETMASK_CAPTURING_GROUP.'>'.self::NETMASK_DEFINITION.'|'.self::CIDR_DEFINITION.')$%';

    /**
     * @var string The capturing regex for a CIDR netmask that supports the following formats:
     *  1) CIDR: "/<bits>"
     * and captures the matches in the following capturing group names:
     *  - <self:CIDR_CAPTURING_GROUP> (the CIDR netmask bits)
     */
    public const CIDR = '%^'.self::CIDR_DEFINITION.'$%';

    private function __construct()
    {
    }
}
