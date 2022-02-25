<?php

namespace ThirdParty\Controllers;

use Spatie\RouteAttributes\Attributes\Get;

class ThirdPartyController
{
    #[Get('third-party')]
    public function thirdPartyGetMethod()
    {
    }

    public function debugging(): string
    {
        return 'Here I am. Will you send me an angel?';
    }
}
