<x-app-layout>
  <x-slot name="header">
    <h1 class="flex-1 text-2xl font-semibold p-2">{{ config("app.name") }} - {{ __("Scraper sources") }}</h1>
    <p>{{ __("The list of available sources") }}</p>
  </x-slot>


  <div class="max-w-7xl mx-auto py-8">
    @if ($message = Session::get('message'))
    <v-alert type="{{$message->type}}">
      {{ $message->content }}
    </v-alert>
    @endif

    <div class="flex flex-wrap gap-4">

      @forelse($sources as $source)
      <v-source-card logo="{{$source->logo}}" :id={{$source->id}}>
        <template v-slot:title>
          {{ $source->name }}
        </template>
        <template v-slot:content>
          {{$source->description}}
        </template>
      </v-source-card>
      @empty
      <div class="h-full w-full text-center flex flex-col items-center justify-center">
        <img class="mx-auto w-32" src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png" alt="no data">
        <span class="text-small text-gray-500">{{ __("You currently don't have any sources.") }}</span>
      </div>
      @endforelse
    </div>
    <!-- floating button -->
    <div @click="showModal = true" class="text-white shadow-xl flex items-center justify-center p-3 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 z-50 fixed bottom-8 right-8 cursor-pointer">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6 hover:rotate-90 transition-all duration-[0.6s]">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
      </svg>
    </div>
    <v-modal v-if="showModal || {{count($errors)}}" type="success" title="Add new source" width="sm" @close="showModal = false">
      <!-- Card -->
      <div class="bg-white border shadow-sm rounded-xl p-4 dark:bg-gray-800 dark:border-gray-700">
        <form action="{{route('source.store')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="flex sm:flex-col md:flex-row items-center gap-4">
            <div class="w-full mb-2 sm:mb-4">
              <x-input-label for="name" class="font-medium" :value="__('Source name')" />
              <x-text-input id="name" class="block mt-1 w-3/4 border rounded-md" type="text" name="name" :value="old('name')" required autofocus />
              <x-input-error :messages="$errors->get('name')"></x-input-error>
            </div>
            <div class="w-full mb-2 sm:mb-4">
              <x-input-label for="category" class="font-medium" :value="__('Source category')" />
              <select id="category" name="category" class="w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500"> 
                @foreach($categories as $cat)
                <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
              </select>
              <x-input-error :messages="$errors->get('category')"></x-input-error>
            </div>
          </div>
          <div class="mb-2 sm:mb-4">
            <x-input-label for="feed_url" class="font-medium" :value="__('Feed URL')" />
            <x-text-input id="feed_url" class="block mt-1 w-3/4 border rounded-md" type="text" name="feed_url" :value="old('name')" required />
            <x-input-error :messages="$errors->get('feed_url')"></x-input-error>
          </div>

          <div class="mb-2 sm:mb-4">
            <x-input-label for="description" class="font-medium" :value="__('Description')" />
            <div>
              <textarea class="w-3/4 text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500"
                        id="description" name="description" rows="2" placeholder="Some description"></textarea>
            </div>
          </div>
          <div class="mb-2 sm:mb-4 flex gap-4">
            <div class="w-full">
              <x-input-label for="content_regex" class="font-medium" value="Content regex/xpath" />
              <x-text-input id="content_regex" class="block mt-1 w-3/4 border rounded-md" type="text" name="content_regex" :value="old('content_regex')"/>
              <x-input-error :messages="$errors->get('content_regex')"></x-input-error>
            </div>
            <div class="w-full">
              <x-input-label for="image_type" class="font-medium" :value="__('Image type')" />
              <select id="image_type" class="block mt-1 w-full p-2.5 border rounded-md" name="image_type">
                <option>enclosure</option>
                <option>media_thumbnail</option>
                <option>media_content</option>
              </select>
              <x-input-error :messages="$errors->get('image_type')"></x-input-error>
            </div>
          </div>
          <div>
            <label class="block">
              <span class="sr-only">Choose File</span>
              <input type="file" name="source_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </label>
          </div>
          <div class="text-right mt-4">
            <button @click="showModal = false" class="px-4 py-2 text-sm text-gray-600 focus:outline-none hover:underline">Cancel</button>
            <button type="submit" class="mr-2 px-4 py-2 text-sm rounded text-white bg-teal-500 focus:outline-none hover:bg-teal-400">Add</button>
          </div>
        </form>
      </div>
      <!-- End Card -->
    </v-modal>
    @isset($editedsource)
    <v-modal v-if="showEditModal = {{$editedsource ? 'true' : 'false'}}" type="edit" title="Edit source" width="sm" @close="showEditModal = false">
      <!-- Card -->
      <div class="bg-white border shadow-sm rounded-xl p-4 dark:bg-gray-800 dark:border-gray-700">
        <form action="{{route('source.update', $editedsource->id)}}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="flex sm:flex-col md:flex-row items-center gap-4">
            <div class="w-full mb-2 sm:mb-4">
            <x-input-label for="name" class="font-medium" :value="__('Source name')" />
            <x-text-input id="name" class="block mt-1 w-3/4 border rounded-md" type="text" name="name" :value="$editedsource->name" required autofocus />
            <x-input-error :messages="$errors->get('name')"></x-input-error>
          </div>
          <div class="w-full mb-2 sm:mb-4">
              <x-input-label for="category" class="font-medium" :value="__('Source category')" />
              <select id="category" name="category" class="w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500"> 
                @foreach($categories as $cat)
                <option value="{{$cat->id}}" {{ $cat->id === $editedsource->category_id ? 'selected' : '' }}>{{$cat->name}}</option>
                @endforeach
              </select>
              <x-input-error :messages="$errors->get('category')"></x-input-error>
            </div>
          </div>
          <div class="mb-2 sm:mb-4">
            <x-input-label for="feed_url" class="font-medium" :value="__('Feed URL')" />
            <x-text-input id="feed_url" class="block mt-1 w-3/4 border rounded-md" type="text" name="feed_url" :value="$editedsource->feed_url" required />
            <x-input-error :messages="$errors->get('feed_url')"></x-input-error>
          </div>

          <div class="mb-2 sm:mb-4">
            <x-input-label for="description" class="font-medium" :value="__('Description')" />
            <div class="mt-1">
              <textarea id="description" name="description" rows="3" class="w-3/4 text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500" placeholder="Some description">{{$editedsource->description}}</textarea>
            </div>
          </div>
          <div class="mb-2 sm:mb-4 flex gap-4">
            <div class="w-full">
              <x-input-label for="content_regex" class="font-medium" value="Content regex/xpath" />
              <x-text-input id="content_regex" class="block mt-1 w-3/4 border rounded-md" type="text" name="content_regex" :value="$editedsource->content_regex" />
              <x-input-error :messages="$errors->get('content_regex')"></x-input-error>
            </div>
            <div class="w-full">
              <x-input-label for="image_type" class="font-medium" :value="__('Image type')" />
              <select id="image_type" class="block mt-1 w-full p-2.5 border rounded-md" name="image_type">
                <option {{ $editedsource->image_type == "enclosure" ? 'selected' : '' }}>enclosure</option>
                <option {{ $editedsource->image_type == "media_thumbnail" ? 'selected' : '' }}>media_thumbnail</option>
                <option {{ $editedsource->image_type == "media_content" ? 'selected' : '' }}>media_content</option>
              </select>
              <x-input-error :messages="$errors->get('image_type')"></x-input-error>
            </div>
          </div>
          <div>
            <label class="block">
              <span class="sr-only">Choose File</span>
              <input type="file" name="source_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </label>
          </div>
          <div class="text-right mt-4">
            <button @click.prevent="showEditModal = false" class="px-4 py-2 text-sm text-gray-600 focus:outline-none hover:underline">Cancel</button>
            <button type="submit" class="mr-2 px-4 py-2 text-sm rounded text-white bg-teal-500 focus:outline-none hover:bg-teal-400">Edit</button>
          </div>
        </form>
      </div>
      <!-- End Card -->
    </v-modal>
    @endisset
  </div>
</x-app-layout>
