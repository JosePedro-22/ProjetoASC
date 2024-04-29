@if ($errors->any())
    <div role="alert" class="mb-4 grid mx-auto w-6/12 mt-4">
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            Erro
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
            @endforeach
        </div>
    </div>
@endif
