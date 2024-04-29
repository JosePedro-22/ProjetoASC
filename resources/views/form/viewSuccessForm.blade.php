@extends('app')
@section('title', 'Chamado sei ')

@section('content')
    <section class="grid content-center p-6 container mx-auto h-[80vh] ">
        <div class="bg-white rounded-lg shadow-lg grid justify-items-center">
            <div class="flex justify-center mt-5">
                <img src="{{asset('sei00.png')}}" alt=""
                     class="h-24">
            </div>
            <h2 class="text-2xl md:text-5xl mt-3 mb-2 text-sky-800 p-2 text-center">Solicitação realizada com
                sucesso!</h2>
            <p class="text-xl md:text-3xl mb-12 text-sky-800 p-2 text-center">
                Todos os dados foram cadastrados
            </p>
        </div>
    </section>
    <div class="flex justify-center mb-5">
        <button class="w-40 text-white border-solid rounded-md cursor-pointer h-14 p-1 pl-3 pr-3 bg-sky-500 hover:bg-sky-600 shadow-lg"><a href="{{ route('index') }}">Home</a></button>
    </div>

@endsection
