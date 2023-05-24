<x-app-layout>
    <x-slot name="header">
        <h1 class="flex-1 text-2xl font-semibold p-2">{{ config("app.name") }} - {{ __("Scraper sources") }}</h1>
        <p>{{ __("Scraping from: ") . $source->name }}</p>
    </x-slot>


    <div class="max-w-7xl mx-auto py-8">
        @if ($message = Session::get('message'))
        <x-alert class="max-w-md mx-auto flex justify-center items-center mb-2 font-medium p-2 rounded-md"
                 :type="$message->type">
                 {{ $message->content }}
        </x-alert>
        @endif
        
        <div class="flex flex-wrap justify-evenly gap-4">
        <table class="min-w-full text-center">
          <thead class="border-b">
            <tr>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                Image
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                Title
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                pub date
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr class="border-b">
              <td class="text-sm text-gray-900 font-medium px-6 py-4 whitespace-nowrap">
                <img src="{{$item->get_enclosure()->link}}" class="w-16 h-auto rounded-md" />
              </td>
              <td class="text-sm text-gray-900 font-medium px-6 py-4 whitespace-nowrap">
                {{$item->get_title()}}
              </td>
              <td class="text-sm text-gray-900 font-medium px-6 py-4 whitespace-nowrap">
                {{$item->get_date()}}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        
    </div>
</x-app-layout>