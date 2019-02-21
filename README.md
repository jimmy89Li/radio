# Radios
a simple service for handling of devices in a radio system

## Clone the git
> git clone https://github.com/jimmy89Li/radio.git

## Docker-compose
> docker-compose up --build


## Scenario 1


### POST /radios/{id}

Method: `POST /radios/100`

Payload: `{ "alias": "Radio100", "allowed_locations": ["CPH-1", "CPH-2"] }`

Response:
```
{
    "status": "200 OK",
    "msg": {
        "alias": "Radio100",
        "allowed_locations": "\"CPH-1\",\"CPH-2\""
    }
}
```

### POST /radios/{id}

Method: `POST /radios/101`

Payload: `{ "alias": "Radio101", "allowed_locations": ["CPH-1", "CPH-2", "CPH-3"] }`

Response:
```
{
    "status": "200 OK",
    "msg": {
        "alias": "Radio101",
        "allowed_locations": "\"CPH-1\",\"CPH-2\",\"CPH-3\""
    }
}
```

### POST /radios/{id}/location

Method: `POST /radios/100/location`

Payload: `{ "location": "CPH-1" }`

Response:
```
{
    "status": "200 OK",
    "msg": "Location set: CPH-1"
}
```

### POST /radios/{id}/location

Method: `POST /radios/101/location`

Payload: `{ "location": "CPH-3" }`

Response:
```
{
    "status": "200 OK",
    "msg": "Location set: CPH-3"
}
```

### POST /radios/{id}/location

Method: `POST /radios/100/location`

Payload: `{ "location": "CPH-3" }`

Response:
```
{
    "status": "403 FORBIDDEN",
    "msg": "Location CPH-3 not allowed!"
}
```

### GET /radios/{id}/location

Method: `GET /radios/101/location`

Response:
```
{
    "status": "200 OK",
    "msg": "Location: CPH-3"
}
```

### GET /radios/{id}/location

Method: `GET /radios/100/location`

Response:
```
{
    "status": "200 OK",
    "msg": "Location: CPH-1"
}
```


## Scenario 2


### POST /radios/{id}

Method: `POST /radios/102`

Payload: `{ "alias": "Radio102", "allowed_locations": ["CPH-1", "CPH-3"] }`

Response:
```
{
    "status": "200 OK",
    "msg": {
        "alias": "Radio102",
        "allowed_locations": "\"CPH-1\",\"CPH-3\""
    }
}
```


### GET /radios/{id}/location

Method: `GET /radios/102/location`

Response:
```
{
    "status": "404 NOT FOUND",
    "msg": "Location not available!"
}
```