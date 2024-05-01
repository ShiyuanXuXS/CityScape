<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservations') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <div id="weather" class="collapse flex flex-wrap mb4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    <span id="weather_city" class="mx-4"></span>
                    <img id="weather_icon" class="w-6" >
                    <span id="weather_description" class="mx-4"></span>
                    <span id="weather_temp" class="mx-4"></span>
                    <span id="weather_feel" class="mx-4"></span>
                    <span id="weather_temp_min" class="mx-4"></span>
                    <span id="weather_temp_max" class="mx-4"></span>
                </div>

                <form action="{{ route('reservations.update',$reservation) }}" method="post">
                    @method('put')
                    @csrf
                    @if ( $hotel_rooms)
                    <div>
                        <label for="hotel_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selected hotel</label>
                        <select id="hotel_name" 
                            value="{{ $reservation->hotel_name }}" 
                            name="hotel_name" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option selected>{{ $reservation->hotel_name }}</option>
                        </select>
                    </div>
                    @error('hotel_name')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                    <br>
                    <div class="flex items-center">
                        <div class="relative">
                            <input id="checkin_date" 
                            value="{{ $reservation->checkin_date }}" 
                            name="checkin_date" 
                            type="date" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" 
                            placeholder="Checkin date" 
                            autocomplete="off"
                        >
                        </div>
                        <span class="mx-4 text-gray-500">to</span>
                        <div class="relative">
                            <input id="checkout_date" 
                            value="{{ $reservation->checkout_date }}" 
                            name="checkout_date" 
                            type="date" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" 
                            placeholder="Checkout date" 
                            autocomplete="off"
                        >
                        </div>
                    </div>
                    @error('checkin_date')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                    @error('checkout_date')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                    <br>
                    <div>
                        <label for="room_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a room</label>
                        <select id="room_number" 
                            name="room_number" 
                            value="{{ $reservation->room_number }}" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option selected>Choose a room</option>
                            @foreach($hotel_rooms as $hotel)
                                @foreach($hotel["rooms"] as $room)
                                    <option value="{{ $room["room_number"] }}" {{ ($room["room_number"]== $reservation->room_number)?"selected": ""}}>Room Number: {{ $room["room_number"] }} --Capacity: {{ $room["room_capacity"] }} --Rate: {{ $room["room_rate"] }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    @error('room_number')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror

                    <x-button class="mt-6">Confirm</x-button>
                    
                    @else

                    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                        <p class="font-bold">Error:</p>
                        <p>Cannot get hotel rooms</p>
                    </div>

                    @endif
                </form>
            </div>
        </div>
    </div>
    

    <script src="{{ route('home') }}/js/rooms_view.js"></script>
</x-app-layout>
