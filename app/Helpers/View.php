<?php

namespace App\Helpers;

use Smarty;

class View
{
    public static function make(): Smarty
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir(__DIR__ . '/../../templates');
        $smarty->setCompileDir(__DIR__ . '/../../storage/cache');

        return $smarty;
    }
}
