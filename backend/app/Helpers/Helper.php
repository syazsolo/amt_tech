<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use PhpParser\PrettyPrinter\Standard;

class Helper
{
    public static function StandardResponse(int $errCode, string $errMsg)
    {
        return [
            'errCode' => $errCode,
            'errMsg' => $errMsg
        ];
    }

    public static function respondSuccess()
    {
        return Helper::StandardResponse(0, '');
    }
}
