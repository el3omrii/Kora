<x-app-layout>
  <x-slot name="header">
    <h1 class="flex-1 text-2xl font-semibold p-2">{{ config("app.name") }} - {{ __("Blog Posts") }}</h1>
    <p>{{ __("The list of available posts") }}</p>
  </x-slot>


  <div class="max-w-7xl mx-auto py-8">
    @if ($message = Session::get('message'))
    <v-alert type="{{$message->type}}">
      {{ $message->content }}
    </v-alert>
    @endif
    <v-settings />
   
  </div>
</x-app-layout>