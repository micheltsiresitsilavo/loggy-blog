@extends('layouts.app')

@section('content')
    {{-- <div class="bg-white lg:pt-32 py-6 sm:py-8 lg:py-12">
 
</div> --}}

<div class="bg-white lg:pt-32 py-6 sm:py-8 lg:py-12">
  <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
    <!-- quote - start -->
    <div class="flex flex-col items-center gap-4 md:gap-6">
      <a href="#" class="text-gray-400 transition duration-100 hover:text-gray-500 active:text-gray-600">
  
    {{-- @forelse ($post->category as $cat)
       {{ $cat->slug }}     
    @empty
          Category empty
    @endforelse --}}
   {{-- @foreach ($post->category as $ctgry)
       {{ $ctgry->name }}
   @endforeach --}}
   {{-- {{ $post->title }} --}}
      </a>

      <div class="max-w-md text-center text-gray-600 lg:text-2xl">{{ $post->title }}</div>

      <div class="flex flex-col items-center gap-2 sm:flex-row md:gap-3">
        

        <div>
          <div class="text-center text-sm font-bold text-indigo-500 sm:text-left md:text-base">Loggy</div>
          <p class="text-center text-sm text-gray-500 sm:text-left md:text-sm">Article</p>
        </div>
      </div>
    </div>
    <!-- quote - end -->
    <div class="max-w-4xl mx-auto mt-10">
        <img
        alt=""
        src="{{$post->getFirstMediaUrl('posts', 'thumb') }}"
        class="h-full w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]"
      />
    
    <div class=" py-8    overflow-hidden ">

         <div class="prose prose-slate  lg:prose-lg">
            {!!html_entity_decode($post->content)!!}
         </div>
    </div>
    </div>
  </div>
</div>
@endsection