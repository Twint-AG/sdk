<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\SystemStatus;

interface SystemAdministration extends Capability
{
    public function checkSystemStatus(): SystemStatus;
}
