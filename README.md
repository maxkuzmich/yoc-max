1. For create country run:
php bin/console app:create-entity country
2. For create city run:
php bin/console app:create-entity city

For get all country:
http://localhost:8000/country/all

REST API:
DEFAULT
http://localhost:8000/api/   => "{\"hello\":\"word!\"}"
//===================CITY================================
GET
http://localhost:8000/api/cities

GET CITY BY ID
http://localhost:8000/api/cities/{id}

POST(create new city)
http://localhost:8000/api/cities/?name=BERLIN,timezone=Europe/Berlin&country=DE&data='{.....}'

PUT(update city by id) 
http://localhost:8000/api/cities/{id}/?name=BERLIN,timezone=Europe/Berlin&country=DE&data='{.....}'

DELETE
http://localhost:8000/api/city/{id}

//===================COUNTRY=================
POST(create new country)
http://localhost:8000/api/country/?name=UKRANE&code=UA

GET(get all countries)
http://localhost:8000/api/country
