@php use Illuminate\Support\Str; @endphp
@extends('app')
@section('title', 'Projeto ASC')
@section('content')
    @include('Validation.validation_form_menssage')
    <div class="flex flex-col">
        <section class="bg-gray-50 drop-shadow-2xl grid mx-auto rounded-3xl border sm:max-w-[850px] w-10/12 mt-8">
            <form action="{{ route('store') }}" method="post" enctype="multipart/form-data" id="uploadForm"
                class="m-3 flex flex-col">
                @csrf
                <div>
                    <label for="campaign"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Campanha:</label>
                    <input type="text" id="campaign" name="campaign"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Identificador de campanha" value="" required />
                </div>
                <div id="myDivForm" class="grid grid-cols-1 mb-3 gap-6">
                    <div class="flex flex-col md:relative">
                        <input type="hidden" name="imagens_respaldo" id="img_test">
                        @include('components.componentFIles', [
                            'title' => 'Anexo (.csv)',
                            'visible' => false,
                            'filenumber' => '4',
                            'id' => 'remove_btn_4',
                            'ob' => false,
                        ])
                        @include('components.componentFIles', [
                            'title' => 'Anexo (.csv)',
                            'visible' => true,
                            'filenumber' => '2',
                            'id' => 'remove_btn_2',
                            'ob' => false,
                        ])

                    </div>
                </div>

                <section class="grid grid-cols-1 justify-items-center mb-6 mt-2">
                    <div class="form-footer flex gap-3">
                        <button type="button" id="BtnSeending" name="buttonEnviar"
                            class="w-full text-white border-solid rounded-md cursor-pointer h-14 p-1 pl-3 pr-3 bg-sky-500 hover:bg-sky-600 shadow-lg">
                            Enviar
                        </button>
                    </div>
                </section>
    </div>
    </form>
    </section>
    </div>


    @push('scripts')
        @vite(['resources/css/app.css', 'resources/js/form.js'])
    @endpush
@endsection
