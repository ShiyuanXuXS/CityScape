<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Homepage') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
    <div class="flex justify-center">
        <div class="max-w-5xl h-full ">
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <span class="prose text-purple-700 max-w-5xl drop-shadow-lg bg-blue-200 opacity-80 absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 z-10 text-3xl font-bold text-center">
                            Vieux-Montréal Suites
                        </span>
                        <img alt="Vieux-Montréal Suites" src="{{ url("/images/montreal.jpg") }}">
                    </div>
                    <div class="swiper-slide">
                        <span class="prose text-purple-700 max-w-5xl drop-shadow-lg bg-blue-200 opacity-80 absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 z-10 text-3xl font-bold text-center">
                            Québec Quaint Inns
                        </span>
                        <img alt="Québec Quaint Inns" src="{{ url("/images/quebec.jpg") }}">
                    </div>
                    <div class="swiper-slide">
                        <span class="prose text-purple-700 max-w-5xl drop-shadow-lg bg-blue-200 opacity-80 absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 z-10 text-3xl font-bold text-center">
                            Ottawa Riverview Suites
                        </span>
                        <img alt="Ottawa Riverview Suites" src="{{ url("/images/ottawa.jpg") }}">
                    </div>
                    <div class="swiper-slide">
                        <span class="prose text-purple-700 max-w-5xl drop-shadow-lg bg-blue-200 opacity-80 absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 z-10 text-3xl font-bold text-center">
                            Toronto Central Plaza
                        </span>
                        <img alt="Toronto Central Plaza" src="{{ url("/images/toronto.jpg") }}">
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <a href="{{ url("/reservations") }}" class="inline-block text-8xl opacity-80 text-black bg-yellow-700 rounded-lg hover:bg-blue-200 border border-black absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                    {{-- <img class="w-96" src="{{ url("/public/images/reserve.png") }}"> --}}
                    RESERVE
                </a>
                
            </div>
            <div  class="prose text-purple-700 max-w-5xl text-2xl drop-shadow-lg bg-blue-200 opacity-80">
                <p class="">
                    Cityscape Hotels is a premier hotel chain offering exceptional accommodations and unparalleled hospitality in four of Canada's most captivating cities: Montreal, Ottawa, Quebec City, and Toronto. 
                </p>
                <p class="">
                    With a focus on contemporary design, superior service, and a commitment to guest satisfaction, Cityscape Hotels aims to provide a memorable and comfortable stay for both business and leisure travelers. 
                </p>
                <p class="">
                    Each hotel within our chain reflects the unique charm and character of its respective city, allowing guests to immerse themselves in the vibrant culture, rich history, and exciting attractions. Whether you're exploring the historic streets of Quebec City, experiencing the multicultural energy of Toronto, indulging in Montreal's culinary delights, or discovering the political heartbeat of Ottawa, Cityscape Hotels is your trusted home away from home. 
                </p>
                <p class="">
                    We invite you to experience the ultimate urban getaway with Cityscape Hotels.
                </p><br>
            </div>
        </div>
    </div>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>
</x-app-layout>
