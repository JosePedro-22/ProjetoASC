<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File as FileAlias;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ValidadorDadosApiRequest extends FormRequest
{
    public static function fromBase64(string $base64File): UploadedFile
    {
        $fileData = base64_decode(Arr::last(explode(',', $base64File)));

        $mimeTypes = [
            'csv' => 'csv',
        ];

        $extensao = substr($base64File, 10, 3);

        $extension = $mimeTypes[$extensao] ?? 'tmp';

        $tempFilePath = public_path('files') . '/' . uniqid() . '.' . $extension;
        file_put_contents($tempFilePath, $fileData);

        $tempFileObject = new File($tempFilePath);

        $file = new UploadedFile(
            $tempFileObject->getPathname(),
            $tempFileObject->getFilename(),
            $tempFileObject->getMimeType(),
            0,
            true
        );

        return $file;
    }

    protected function prepareForValidation(): void
    {
        $this->processArq();
    }

    private function processArq(): void
    {
        $imagens = [];
        $pdf = [];
        $files = [];
        $filesUpload = [];
        foreach (json_decode($this['imagens_respaldo']) as $item) {
            if (!Str::contains($item, 'pdf')) {
                $imagens[] = $item;
            } else {
                $pdf[] = $item;
            }
        }

        foreach ($imagens as $item) {
            $uploadedFile = self::fromBase64($item);
            $fileInfo = $this->processFile($uploadedFile);
            $files[] = $fileInfo;
            $filesUpload[] = $uploadedFile;
        }

        foreach ($this->files as $items) {
            foreach ($items as $item) {
                $option = [
                    'text/csv',
                ];

                if (in_array($item->getClientMimeType(), $option)) {
                    $fileInfo = $this->processFile($item);
                    $files[] = $fileInfo;
                }
            }
        }

        $this['imagens_respaldo2'] = $files;
        $this['imagens_respaldo_files'] = $filesUpload;
    }

    private function processFile($file): array
    {
        $hashFile = hash_file('sha256', $file);
        $content = file_get_contents($file);
        $nameFile = $hashFile . '.' . $file->getClientOriginalExtension();
        $url = Storage::disk('public_files')->put($nameFile, $content);

        return [
            'path' => public_path('files/') . $nameFile,
            'name' => $nameFile,
            'extension' => $file->getClientOriginalExtension(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ];
    }

    public function rules()
    {
        // dd($this->request->all()['imagens_respaldo_files'][0]);
        $default = [
            'campaign' => ['required', 'string', 'max:255', 'min:2'],
            'imagens_respaldo2' => ['nullable', 'array'],
            'imagens_respaldoAll' => ['nullable', 'array'],
            'imagens_respaldo_files' => ['nullable', 'array'],
            // 'imagens_respaldo_files.*' => ['nullable', 'max:5120','mime:text/plain,text/csv'],
        ];

        return $default;
    }

    public function failedValidation(Validator $validator): MessageBag
    {
        if (!empty($this['imagens_respaldo2'])) {
            collect($this['imagens_respaldo2'])->each(function ($anexo) {
                if (is_array($anexo) && file_exists($anexo['path'])) {
                    FileAlias::delete($anexo['path']);
                }
            });
        }
        if (!empty($this['imagens_respaldo_files'])) {
            collect($this['imagens_respaldo_files'])->each(function ($anexo) {
                if (is_array($anexo) && file_exists($anexo->getRealPath())) {
                    FileAlias::delete($anexo->getRealPath());
                }
            });
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    public function messages()
    {
        return [
            'campaign.required' => 'Campanha é obrigatória',
            'campaign.string' => 'Campanha deve ser uma string',
            'imagens_respaldo2' => 'O campo Anexo é obrigatorio ter a planilha com os dados dos usuarios',
            'imagens_respaldo_files.*.nullable' => 'O campo aceita apenas imagens.',
            'imagens_respaldo_files.*.file' => 'Os arquivos devem ser imagens.',
            // 'imagens_respaldo_files.*.mime' => 'Os arquivos deve ter o formato csv.',
            'imagens_respaldo_files.*.max' => 'O arquivo deve ter tamanho máximo de 5MB.',
            'imagens_respaldo_files.*.uploaded' => 'Não foi possível processar essa imagem. Tente enviar uma imagem da sua galeria.',

        ];
    }
}
