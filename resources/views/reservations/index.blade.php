
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservations') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert-success>
                {{ session('success') }}
            </x-alert-success>
            <a href="{{ route('reservations.create') }}" class="btn-link btn-lg mb-2">Reserve</a>
            @forelse ($reservations as $reservation)
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <a href="{{ route('reservations.show',$reservation) }}">
                    <h2 class="font-bold text-2xl">From: {{ $reservation->checkin_date}} To: {{ $reservation->checkout_date}}</h2>
                </a>
                <p class="font-bold text-xl mt-2">Hotel: {{ $reservation->hotel_name }}</p>
                <p class="mt-2">Room Number: {{ $reservation->room_number }}</p>
                <p class="mt-2">Capacity: {{ $reservation->room_capacity }}</p>
                <p class="mt-2">rate: {{ $reservation->room_rate }}</p>
                <span class="block mt-4 text-sm opacity-70">Updated at: {{  $reservation->updated_at }}</span>
                
            </div>

  
            @empty
                <p>No reservations yet.</p>
            
            @endforelse
            <div class="bg-gray-50 bg-transparent-50">

            {{ $reservations->links() }}
            </div>
        </div>
    </div>
    
</x-app-layout>
