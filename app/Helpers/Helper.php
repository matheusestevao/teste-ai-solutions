<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Helper
{
    public static function store_error_log(object $data): void
    {
        Log::error($data->getFile() . ' - ' . $data->getLine() . ' - ' . print_r($data->getMessage(), 1));
    }
}