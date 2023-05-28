<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8">
    @if ($message = Session::get('message'))
    <v-alert type="{{$message->type}}">
      {{ $message->content }}
    </v-alert>
    @endif

    
        <v-dashboard></v-dashboard>
</div>    
</x-app-layout>
