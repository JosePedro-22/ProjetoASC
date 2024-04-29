<?php

namespace App\Http\Services;

use App\Jobs\SeedEmailJob;
use App\Models\Campaign;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SeedRequestService
{
    public function __construct(
        private Campaign $contact,
        private Contact $campaign,
    ){}

    public function seedRequest(array $data)
    {
        DB::beginTransaction();

        try {
            $campaign = new Campaign();
            $campaign->campaign = $data['campaign'];
            $campaign->save();

            $campaignId = $campaign->id;

            $anexo = $data['imagens_respaldo2'][1]['path'];

            if (file_exists($anexo)) {

                $file = fopen($anexo, 'r');

                $header = fgetcsv($file);

                $headerParts = explode(';', $header[0]);

                $data = [];

                foreach ($headerParts as $key => $value) {
                    if ($value === '') {
                        $data[$key] = $value;
                    } else {
                        $data[$key] = trim($value);
                    }
                }

                // while (($dataFile = fgetcsv($file)) !== false) {

                //     $contact = new Contact();
                //     $contact->campaign_id = $campaignId;
                //     $contact->nome = $dataFile[0] ?? "";
                //     $contact->sobrenome = $dataFile[1] ?? "";
                //     $contact->email = $dataFile[2] ?? "";
                //     $contact->telefone = $dataFile[3] ?? "";
                //     $contact->endereco = $dataFile[4] ?? "";
                //     $contact->cidade = $dataFile[5] ?? "";
                //     $contact->cep = $dataFile[6] ?? "";
                //     $contact->data_nascimento = $dataFile[7] ?? "";

                //     $contact->save();
                // }
                while (($dataFile = fgetcsv($file)) !== false) {
                    $contact = new Contact();
                    $contact->campaign_id = $campaignId;
                    $dataParts = explode(';', $dataFile[0]);
                    foreach ($dataParts as $key => $value) {
                        switch ($key) {
                            case 0:
                                $contact->nome = trim($value);
                                break;
                            case 1:
                                $contact->sobrenome = trim($value);
                                break;
                            case 2:
                                $contact->email = trim($value);
                                break;
                            case 3:
                                $contact->telefone = trim($value);
                                break;
                            case 4:
                                $contact->endereco = trim($value);
                                break;
                            case 5:
                                $contact->cidade = trim($value);
                                break;
                            case 6:
                                $contact->cep = trim($value);
                                break;
                            case 7:
                                $data_nascimento = date('Y-m-d', strtotime($value));
                                $contact->data_nascimento = trim($data_nascimento);
                                break;
                            default:
                                break;
                        }
                    }
                    $contact->save();
                }

                fclose($file);
            }

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return view('form.formulario');
        }
    }
}
