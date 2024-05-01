let dom_hotel_name = document.getElementById('hotel_name')
let dom_checkin_date = document.getElementById('checkin_date')
let dom_checkout_date = document.getElementById('checkout_date')

//today is the min date
let today = new Date()
//console.log(today)
dom_checkin_date.setAttribute('min', today.toISOString().split('T')[0])
today.setDate(today.getDate() + 1)
dom_checkout_date.setAttribute('min', today.toISOString().split('T')[0])

let dom_room_number = document.getElementById('room_number')
let dom_weather = document.getElementById('weather')

let path = window.location.pathname
let pathArr = path.split("/")
let id = (pathArr.length > 2) ? pathArr[pathArr.length - 2] : null
//if url is '/reservations/id/edit', the room reserved (with id) is still available
id = (id != "reservations") ? id : null
refreshRooms()

//if hotel changed,refresh weather and available rooms
dom_hotel_name.addEventListener('change', () => {
    showWeather()
    refreshRooms()
})

//if checkin date changed, refresh available rooms
dom_checkin_date.addEventListener('change', () => {

    //checkout date must be after checkin date
    let checkinDate = new Date(dom_checkin_date.value.slice(0, 4),dom_checkin_date.value.slice(5, 7)-1,dom_checkin_date.value.slice(8, 10))
    let checkoutDate = (dom_checkout_date.value) ? (new Date(dom_checkout_date.value.slice(0, 4),dom_checkout_date.value.slice(5, 7)-1,dom_checkout_date.value.slice(8, 10))) : checkinDate
    if (checkoutDate <= checkinDate) {
        checkoutDate=new Date(checkinDate.getFullYear(), checkinDate.getMonth(), checkinDate.getDate() + 1)
        dom_checkout_date.value = checkoutDate.toISOString().slice(0, 10)
    }
    //refresh available rooms
    refreshRooms()
});

//if checkout date changed, refresh available rooms
dom_checkout_date.addEventListener('change', () => {
    //checkout date must be after checkin date
    let checkoutDate = new Date(dom_checkout_date.value.slice(0, 4),dom_checkout_date.value.slice(5, 7)-1,dom_checkout_date.value.slice(8, 10))
    let checkinDate = (dom_checkin_date.value) ? (new Date(dom_checkin_date.value.slice(0, 4),dom_checkin_date.value.slice(5, 7)-1,dom_checkin_date.value.slice(8, 10))) : checkoutDate
    if (checkinDate >= checkoutDate) {
        checkinDate=new Date(checkoutDate.getFullYear(), checkoutDate.getMonth(), checkoutDate.getDate() - 1)
        dom_checkin_date.value = checkinDate.toISOString().slice(0, 10)
    }
    //refresh available rooms
    refreshRooms()
})


function showWeather(){
    if (dom_hotel_name.value != "Choose a hotel") {
        //window.location.origin
        fetch(`../api/rooms/weather/${dom_hotel_name.value}`)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("API request failed");
            }
        })
        .then((data) => {
            //show weather
            document.getElementById("weather_city").textContent = data.name
            document.getElementById("weather_icon").src =`http://openweathermap.org/img/w/${data.weather[0].icon}.png` 
            document.getElementById("weather_description").textContent = data.weather[0].description
            document.getElementById("weather_temp").textContent = `${data.main.temp} °C`
            document.getElementById("weather_feel").textContent = `feel like: ${data.main.feels_like} °C`
            document.getElementById("weather_temp_min").textContent = `min: ${data.main.temp_min} °C`
            document.getElementById("weather_temp_max").textContent = `max: ${data.main.temp_max} °C`
            
            dom_weather.classList.remove('collapse')    //same as : dom_weather.style.display = "block"
        })
        .catch((error) => {
            console.log(error)
        })
    }
}
//
function refreshRooms() {
    dom_room_number.innerHTML = "<option selected>Choose a room</option>"

    if (dom_hotel_name.value == "Choose a hotel") {
        dom_weather.classList.add('collapse')   //same as: dom_weather.style.display = "none"
        return
    }
    
    if (dom_checkin_date.value && dom_checkout_date.value) {
            //get and show rooms
        let request = `../api/rooms/${dom_hotel_name.value}/${dom_checkin_date.value}/${dom_checkout_date.value}`
        request = id ? (request + `/${id}`) : request;
        fetch(request)
            .then((response) => {
                    
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('API request failed');
                }
            })
            .then((data) => {
                //console.log(data.rooms)
                for (room_id in data.rooms) {
                    let room = data.rooms[room_id];
                    let option = document.createElement("option")
                    option.value = `${room.room_number}`
                    option.textContent =`Room Number: ${ room.room_number } --Capacity: ${ room.room_capacity } --Rate: ${ room.room_rate }`
                    dom_room_number.appendChild(option)
                }
            })
            .catch((error) => {
                console.log(error)
            })
    }
    
    
}