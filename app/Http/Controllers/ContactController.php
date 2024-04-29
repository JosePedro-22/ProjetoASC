<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidadorDadosApiRequest;
use App\Models\Campaign;
use App\Models\Contact;
use App\Http\Services\SeedRequestService;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ContactController extends Controller
{
    private array $data;
    public function __construct(
        private readonly SeedRequestService $seedRequestService,
    )
    {}

    public function index()
    {
        return view('form.formulario');
    }

    public function store(ValidadorDadosApiRequest $request)
    {
        try {
            $this->seedRequestService->seedRequest($request->validated());
            Session::put('cadastro', true);
        } catch (Throwable $throwable) {
            $this->handleException($throwable);
            return redirect()->route('index');
        } finally {
            $this->deleteRespaldoImages($request);
        }
        return redirect()->route('success-form');
    }

    public function find()
    {
        $contacts = Contact::paginate(10);
        $campaigns = Campaign::paginate(10);

        return view('contacts.index',
            [
                'contacts' => $contacts,
                'campaigns' => $campaigns,
            ]);
    }

    private function deleteRespaldoImages($request)
    {
        if (! empty($request['imagens_respaldo2'])) {
            collect($request['imagens_respaldo2'])->each(function ($anexo) {

                if (is_array($anexo) && file_exists($anexo['path'])) {
                    Storage::disk('public_files')->delete($anexo['path']);
                }
            });
        }
        if (! empty($request['imagens_respaldo_files'])) {
            collect($request['imagens_respaldo_files'])->each(function ($anexo) {
                if ($anexo->isValid() && file_exists($anexo->getRealPath())) {
                    $path = $anexo->getRealPath();
                    Storage::disk('public_files')->delete($path);
                }
            });
        }
    }
    private function handleException(Throwable $throwable)
    {
        dd(1, $throwable->getMessage());
        Log::error($throwable->getMessage());
        SeedError::seed($throwable->getMessage(), 'Error ...');
    }

    public function successForm()
    {
        if (session('cadastro') == true) {
            session()->put('cadastro', false);

            return view('form.viewSuccessForm');
        }

        return redirect()->route('index');
    }

    public function getContactsByCampaignId($campaignId)
    {
        $contacts = Contact::where('campaign_id', $campaignId)->get();
        return response()->json($contacts);
    }
}
