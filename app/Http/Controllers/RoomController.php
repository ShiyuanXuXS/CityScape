<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Reservation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    //read hotel_rooms.txt
    static function readRooms()
    {
        $json = Storage::get('public/hotel_rooms.txt');
        $hotel_rooms = json_decode($json, true);
        return $hotel_rooms;
    }
    //return hotel names
    static function getHotelNames()
    {
        $hotels = RoomController::readRooms();
        $hotel_names = [];
        foreach ($hotels as $hotel) {
            $hotel_names[] = $hotel["name"];
        }
        return $hotel_names;
    }
    //return hotel room
    static function getRoom(string $hotel_name, string $room_number)
    {
        $hotels = RoomController::readRooms();
        foreach ($hotels as $hotel) {
            if ($hotel["name"] == $hotel_name) {
                foreach ($hotel["rooms"] as $room) {
                    if ($room["room_number"] == $room_number) {
                        return $room;
                    }
                }
            }
        }
        return [];
    }

    static function getCity($hotel_name)
    {
        $hotels = RoomController::readRooms();
        foreach ($hotels as $hotel) {
            if ($hotel["name"] == $hotel_name) {
                return ["city" => $hotel["city"], "lat" => $hotel["lat"], "lon" => $hotel["lon"]];
            }
        }
        return [];
    }
    public function getWeather(string $hotel_name)
    {
        $city = RoomController::getCity($hotel_name);
        if (!$city) {
            return [];
        }

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather?lat=" . $city['lat'] . "&lon=" .  $city['lon'] . "&appid=" . env('API_WEATHER_KEY') . "&units=metric");
        $data = $response->json();
        //dd($data);
        return $data;
    }
    //return available hotel rooms, ignore occupation of reservation where id is $id
    static function getAvailableRooms(string $hotel_name, string $checkin_date, string $checkout_date, int $id = null, bool $onlyRoomNumber = false)
    {
        //read hotels from file
        $hotels = RoomController::readRooms();
        if (!$hotels) {
            return []; //["error" => "Read room file error!"];
        }
        //delete other hotels
        foreach ($hotels as $k => $v) {
            if ($v["name"] != $hotel_name) {
                unset($hotels[$k]);
            }
        }
        if (!$hotels) {
            return [];
        }
        $hotel = current($hotels);
        //validate checkin date
        $checkin_date = RoomController::toDate($checkin_date);
        if (!$checkin_date) {
            return [];
        }
        //validate checkout date
        $checkout_date = RoomController::toDate($checkout_date);
        if (!$checkout_date) {
            return [];
        }

        //query & delete unavailable rooms
        $where = "hotel_name='{$hotel_name}' and checkin_date < '{$checkout_date}' and checkout_date > '{$checkin_date}'";
        $where = $id ? $where . " and id<>{$id}" : $where;

        $bookedRooms = Reservation::whereRaw($where)->get();

        //dd($bookedRooms);
        foreach ($bookedRooms as $bookedRoom) {
            foreach ($hotel["rooms"] as $k => $v) {
                if ($bookedRoom["room_number"] == $v["room_number"]) {
                    unset($hotel["rooms"][$k]);
                }
            }
        }
        //dd($hotels);
        //dd($bookedRooms);
        if ($onlyRoomNumber) {
            $room_numbers = [];
            foreach ($hotel["rooms"] as $room) {
                $room_numbers[] = $room["room_number"];
            }
            return $room_numbers;
        } else {
            return $hotel;
        }
    }

    //check if the hotel name exists
    private function hasHotel(string $hotel_name, array $hotel_rooms)
    {
        foreach ($hotel_rooms as $hotel) {

            if ($hotel_name == $hotel["name"]) {
                return true;
            }
        }
        return false;
    }

    //validate date value
    static function toDate(string $value)
    {
        try {
            $date = date_parse($value);
            if ($date["error_count"]) {
                return false;
            }
            return $date["year"] . "-" . $date["month"] . "-" . $date["day"];
        } catch (Exception $e) {
            return false;
        }
    }
}
