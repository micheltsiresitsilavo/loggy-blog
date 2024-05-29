@extends('layouts.app')

@section('content')
<div class="bg-white lg:pt-32 py-6 sm:py-8 lg:py-12">
  <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
    <div class="flex flex-col overflow-hidden rounded-lg bg-gray-200 sm:flex-row ">
      <!-- image - start -->
      <div class="order-first h-auto w-full bg-gray-300 sm:order-none sm:h-auto sm:w-1/2 lg:w-2/5">
        <img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?auto=format&q=75&fit=crop&w=1000" loading="lazy" alt="Photo by Andras Vas" class="h-full w-full object-cover object-center" />
      </div>
      <!-- image - end -->

      <!-- content - start -->
      <div class="flex w-full flex-col p-4 sm:w-1/2 sm:p-8 lg:w-3/5">
        <h2 class="mb-4 text-xl font-bold text-gray-800 md:text-2xl lg:text-4xl">About</h2>

        <p class="mb-8 w-full text-gray-600">Loggy is a modern and feature-rich blogging platform built using the powerful PHP Laravel framework. It provides a seamless and user-friendly experience for both writers and readers, allowing you to effortlessly create, manage, and publish your thoughts and stories.
        With Loggy, you can craft beautifully formatted blog posts, complete with rich text editing, multimedia embedding, and customizable layouts. The platform's intuitive interface and robust content management system make it easy to organize your posts into categories, add tags, and schedule publications.
        Loggy leverages the flexibility and scalability of Laravel, ensuring a secure and high-performance blogging experience. Its modular architecture allows for easy customization and integration with third-party services, such as social media platforms, analytics tools, and more.
        For readers, Loggy offers a clean and responsive design, ensuring an enjoyable reading experience across various devices. Features like search functionality, related post suggestions, and commenting systems encourage engagement and foster a vibrant community around your content.
        Behind the scenes, Loggy takes advantage of Laravel's powerful tools and features, including routing, database migrations, and authentication systems, ensuring a smooth development and deployment process.</p>

     
      </div>
      <!-- content - end -->
    </div>
  </div>
</div>
@endsection