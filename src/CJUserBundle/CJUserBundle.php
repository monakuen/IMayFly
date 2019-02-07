<?php

namespace CJUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CJUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

