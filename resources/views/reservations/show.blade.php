
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
            <div class="flex">
                <p class="opacity-70">
                    <strong>Created: </strong>{{ $reservation->created_at }}
                </p>
                <p class="opacity-70 ml-8">
                    <strong>Updated: </strong>{{ $reservation->updated_at }}
                </p>
                <a href={{ route("reservations.edit",$reservation) }} class="btn-link ml-auto">Modify</a>
                <form action="{{ route('reservations.destroy',$reservation) }}" method="post">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger ml-4" onclick="return confirm('Are you sure you wish to delete this reservation?')">Delete</button>
                </form>
            </div>
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <h2 class="font-bold text-2xl">From: {{ $reservation->checkin_date}} To: {{ $reservation->checkout_date}}</h2>
                
                <p class="font-bold text-xl mt-2">Hotel: {{ $reservation->hotel_name }}</p>
                <p class="mt-2">Room Number: {{ $reservation->room_number }}</p>
                <p class="mt-2">Capacity: {{ $reservation->room_capacity }}</p>
                <p class="mt-2">rate: {{ $reservation->room_rate }}</p>
                
            </div>

        </div>
    </div>
    
</x-app-layout>
