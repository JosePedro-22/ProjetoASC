@php use Illuminate\Support\Str; @endphp
@extends('app')
@section('title', 'Projeto ASC')
@section('content')
<div class="flex flex-col">
    <section class="pl-6 row flex justify-between">
        <h2 class="text-xl md:text-2xl mt-3 mb-2 text-sky-800 p-2 text-start">Lista de Contatos</h2>
        <div class="pr-6">
            <label for="campaignSelect" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione a Campanha:</label>
            <select id="campaignSelect" name="campaignSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Selecione...</option>
                @foreach ($campaigns as $campaign)
                    <option value="{{ $campaign->id }}">{{ $campaign->campaign }}</option>
                @endforeach
            </select>
        </div>
    </section>
    <section class="w-screen p-6">
        <div class="relative overflow-x-auto bg-slate-100">
            @if ($contacts->isEmpty())
                <h3 class="flex justify-center mt-4 text-gray-600 dark:text-gray-400 mb-3">Não existem dados de contato salvos.</h3>
            @else
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-3xl border">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nome
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sobrenome
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Telefone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Endereço
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Cidade
                        </th>
                        <th scope="col" class="px-6 py-3">
                            CEP
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Data de Nascimento
                        </th>
                    </tr>
                </thead>
                <tbody id="contactTableBody">
                    @foreach ($contacts as $contact)
                    <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $contact->nome }}</td>
                        <td class="px-6 py-4">{{ $contact->sobrenome }}</td>
                        <td class="px-6 py-4">{{ $contact->email }}</td>
                        <td class="px-6 py-4">{{ $contact->telefone }}</td>
                        <td class="px-6 py-4">{{ $contact->endereco }}</td>
                        <td class="px-6 py-4">{{ $contact->cidade }}</td>
                        <td class="px-6 py-4">{{ $contact->cep }}</td>
                        <td class="px-6 py-4">{{ $contact->data_nascimento }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="mt-2">
            {{ $contacts->links() }}
        </div>
        @endif
    </section>
</div>
<script>
    document.getElementById('campaignSelect').addEventListener('change', function() {
    var campaignId = this.value;

    fetch(`/contacts/${campaignId}`)
        .then(response => response.json())
        .then(data => {
            var contactTableBody = document.getElementById('contactTableBody');
            contactTableBody.innerHTML = '';

            data.forEach(contact => {
                var newRow = '<tr>' +
                    '<td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' + contact.nome + '</td>' +
                    '<td class="px-6 py-4">' + contact.sobrenome + '</td>' +
                    '<td class="px-6 py-4">' + contact.email + '</td>' +
                    '<td class="px-6 py-4">' + contact.telefone + '</td>' +
                    '<td class="px-6 py-4">' + contact.endereco + '</td>' +
                    '<td class="px-6 py-4">' + contact.cidade + '</td>' +
                    '<td class="px-6 py-4">' + contact.cep + '</td>' +
                    '<td class="px-6 py-4">' + contact.data_nascimento + '</td>' +
                    '</tr>';
                contactTableBody.innerHTML += newRow;
            });
        })
        .catch(error => {
            console.error('Erro ao buscar contatos:', error);
        });
});
</script>
@push('scripts')
    @vite(['resources/css/app.css', 'resources/js/form.js'])
@endpush
@endsection
