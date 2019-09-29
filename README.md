For set data provider use service.yaml
parameters:
    data_provider: https://yoc-media.github.io/weather/report/DE/Berlin.json
1. For create country run:
php bin/console app:create-entity country
2. For create city run:
php bin/console app:create-entity city

For get all country:
http://localhost:8000/country/all
<br></br>
<b>REST API:</b>
<b>DEFAULT</b>
http://localhost:8000/api/   => "{\"hello\":\"word!\"}"
//===================CITY================================
<br></br>
<b>GET</b>
http://localhost:8000/api/cities
<br></br>
<b>GET CITY BY ID</b>
http://localhost:8000/api/cities/{id}
<br></br>
<b>POST</b>(create new city)
http://localhost:8000/api/cities/?name=BERLIN,timezone=Europe/Berlin&country=DE&data='{.....}'
<br></br>
<b>PUT</b>(update city by id) 
http://localhost:8000/api/cities/{id}/?name=BERLIN,timezone=Europe/Berlin&country=DE&data='{.....}'
<br></br>
<b>DELETE</b>
http://localhost:8000/api/city/{id}
<br></br>
//===================COUNTRY=============================
<br></br>
<b>POST(create new country)
http://localhost:8000/api/country/?name=UKRANE&code=UA
<br></br>
<b>GET</b>(get all countries)
http://localhost:8000/api/country
//==================GET REPORT==========================
<br></br>
<b>REPORT API</b>
http://localhost:8000/api/report/?start_date=2018-06-16&end_date=2018-06-17&less=15&higher=11
