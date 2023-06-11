<x-app-layout>
  <x-slot name="header">
    <h1 class="flex-1 text-2xl font-semibold p-2">{{ config("app.name") }} - {{ __("Scraper sources") }}</h1>
    <p>{{ __("Scraping.. ") }}</p>
  </x-slot>


  <div class="max-w-7xl mx-auto py-8">
    @if ($message = Session::get('message'))
    <v-alert type="{{$message->type}}">
      {{ $message->content }}
    </v-alert>
    @endif
      <v-feed-table :source="{name: '{{$source->name}}', id: {{$source->id}}, feed_url: '{{$source->feed_url}}'}"></v-feed-table>
  </div>
</x-app-layout>