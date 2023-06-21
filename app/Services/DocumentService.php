<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Document;
use Illuminate\Support\Facades\Log;

class DocumentService
{
    public static function store(array $data): Document
    {
        Log::info(print_r($data, 1));
        try {
            $document = Document::create($data);

            return $document;
        } catch (\Throwable $th) {
            Helper::store_error_log($th);

            throw new \Exception('Erro ao criar o documento. Favor, tente novamente.');
        }
    }
}