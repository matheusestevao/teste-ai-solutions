<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ManualJobs;
use App\Services\CategoryService;
use App\Services\DocumentService;
use App\Services\ManualJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImportDocumentController extends Controller
{
    public function import_document()
    {
        return view('welcome');
    }

    public function read_document(Request $request)
    {
        try {
            $file = $request->file('file');
            
            if(!$file || !$file->isValid()) {
                throw new \Exception('Arquivo Inválido.');
            }

            $fileContents = file_get_contents($file->getPathname());
            if($fileContents === false) {
                throw new \Exception('Não foi possível ler o arquivo.');
            }

            $fileData = json_decode($fileContents);
            if(!$fileData) {
                throw new \Exception('Arquivo JSON Inválido ou vazio.');
            }

            $queue = $request->queue;
            $exercice = $fileData->exercicio;

            foreach ($fileData->documentos as $document) {
                $data = ['exercice' => $exercice];

                foreach($document as $field => $detail) {
                    $data[$field] = $detail;
                }

                ManualJobService::store($queue, $data);
                $data = array();
            }

            return redirect()
                        ->route('import_document')
                        ->with('success', 'Informações inseridas com sucesso na fila de processamento.');
        } catch (\Throwable $th) {
            Helper::store_error_log($th);

            return redirect()
                        ->route('import_document')
                        ->with('error', 'Não foi possível processar as informações. Favor, revise o arquivo e tente novamente.');
        }
    }

    public function exec_job(Request $request)
    {
        try {
            $queueName = $request->queue;

            $manualJobs = ManualJobService::get_jobs_to_queue($queueName);

            if(!is_null($manualJobs)) {
                foreach ($manualJobs as $job) {
                    $category = CategoryService::getCategoryToName($job->data['categoria']);
                    
                    $data = [
                        'title' => $job->data['titulo'],
                        'category_id' => $category->id,
                        'exercice' => $job->data['exercice'],
                        'contents' => $job->data['conteúdo']
                    ];

                    DocumentService::store($data);

                    $job->delete();
                }
            }

            return redirect()
                        ->route('import_document')
                        ->with('success', 'Fila processada com sucesso.');
        } catch (\Throwable $th) {
            Helper::store_error_log($th);

            return redirect()
                        ->route('import_document')
                        ->with('error', 'Não foi possível processar as informações. Favor, revise o arquivo e tente novamente.');
        }
    }
}
