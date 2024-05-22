<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

interface CoreCapabilities extends DeviceHandling, OrderAdministration, OrderCheckout, OrderMonitoring, OrderReversal, SystemAdministration
{
}
