# Using Passport in Lumen

This project is an example of using [dusterio Lumen Passport](https://github.com/dusterio/lumen-passport) to allow using OAuth2 to authenticate calls to your API.

## Running the project

To run the project you can use the following commands:

    cd docker
    docker-compose up -d
    docker exec -it php /bin/bash
    cp .env.example .env
    php artisan migrate
    php artisan passport:install   
     
Note:
* Make a note of the client keys that are output in the console after you install passport     
* You can replace the APP_KEY setting in `.env` with a value that you obtain from https://3v4l.org/2Gjac, but for the purpose of demonstration and not production there is no need to.

## Demo of using OAuth2 to authenticate a user

Note: Passport does not include authorization and is exclusively focused on authentication, see [Gates](https://github.com/andybeak/gates-demo) as an example of authorizing requests.

### Registering a user

    curl -X POST \
      http://localhost:8000/register \
      -H 'Accept: */*' \
      -H 'Accept-Encoding: gzip, deflate' \
      -H 'Cache-Control: no-cache' \
      -H 'Connection: keep-alive' \
      -H 'Content-Length: 398' \
      -H 'Content-Type: multipart/form-data; boundary=--------------------------737666806044416663579227' \
      -H 'Host: localhost:8000' \
      -H 'cache-control: no-cache' \
      -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
      -F name=Username \
      -F email=test@example.com \
      -F password=secret
      
## Obtaining an access token

Replace the value of the `client_secret` with the value that you obtained when you installed passport (see note above)

    curl -X POST \
      http://localhost:8000/v1/oauth/token \
      -H 'Accept: */*' \
      -H 'Accept-Encoding: gzip, deflate' \
      -H 'Cache-Control: no-cache' \
      -H 'Connection: keep-alive' \
      -H 'Content-Length: 774' \
      -H 'Content-Type: multipart/form-data; boundary=--------------------------616904423189338829706400' \
      -H 'Host: localhost:8000' \
      -H 'cache-control: no-cache' \
      -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
      -F grant_type=password \
      -F client_id=2 \
      -F client_secret=<secret> \
      -F password=secret \
      -F username=test@example.com \
      -F scope=
      
Make a note of the value for the access token that is returned in the JSON response.
      
## Making an authenticated call

Use the access token that you received from the password grant.

    curl -X GET \
      http://localhost:8000/protected \
      -H 'Accept: */*' \
      -H 'Accept-Encoding: gzip, deflate' \
      -H 'Authorization: Bearer <token>' \
      -H 'Cache-Control: no-cache' \
      -H 'Connection: keep-alive' \
      -H 'Host: localhost:8000' \
      -H 'cache-control: no-cache'