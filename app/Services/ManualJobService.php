<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\ManualJobs;
use Illuminate\Database\Eloquent\Collection;

class ManualJobService
{
    public static function store(string $queue, array $data): ?object
    {
        try {
            $manualJobs = ManualJobs::create([
                'queue' => $queue,
                'data' => $data
            ]);

            return $manualJobs;
        } catch (\Throwable $th) {
            Helper::store_error_log($th);

            throw new \Exception('Erro ao salvar os jobs. Favor, tente novamente.');
        }
    }

    public static function get_jobs_to_queue(string $queue): ?Collection
    {
        try {
            $manualJobs = ManualJobs::where('queue', $queue)->get();

            if($manualJobs->isEmpty()) {
                return NULL;
            }

            return $manualJobs;
        } catch (\Throwable $th) {
            Helper::store_error_log($th);

            throw new \Exception('Erro ao buscar os registros. Favor, tente novamente.');
        }
    }
}