<x-app-layout class="w-full static">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bem vindo(a)') }} {{ Auth::user()->name }}!
        </h2>

    </x-slot>

    <div class="py-12">

        @if (Auth::check() && session()->get('chat_id'))
        <x-chat />
        @else
        <x-home-chat value="{{ Auth::user()->name }}" />
        @endif

    </div>
</x-app-layout>