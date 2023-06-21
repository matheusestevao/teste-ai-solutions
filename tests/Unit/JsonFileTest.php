<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class JsonFileTest extends TestCase
{
    /**
     * testing importing and read document.
     */
    public function test_import_document(): void
    {
        $file = __DIR__ . '/../../storage/data/2023-03-28.json';
        $this->assertTrue(file_exists($file));

        $response = $this->withoutMiddleware()->post('read_document', [
            'queue' => 'file_exercice',
            'file' => new UploadedFile($file, '2023-03-28.json')
        ]);

        $response->assertRedirectToRoute('import_document');
    }

    /**
     * testing execute job
     */
    public function test_exec_job_file_exercice(): void
    {
        $response = $this->withoutMiddleware()->post('exec_job', [
            'queue' => 'file_exercice'
        ]);

        $response->assertRedirectToRoute('import_document');
    }
}
