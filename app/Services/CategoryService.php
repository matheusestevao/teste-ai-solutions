<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public static function getCategoryToName(string $name): ?object
    {
        try {
            return Category::where('name', $name)->first();
        } catch (\Throwable $th) {
            Helper::store_error_log($th);
        }
    }
}