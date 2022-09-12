### Rubik's Cube

## install
Clone repo: <code>git clone git@github.com:zak956/rubik.git</code>\
Go to directory: <code>cd rubik</code>\
Composer: <code>composer install</code>\
Parameters: <code>cp .env.example .env</code>

Update parameters in .env.\
DB_CONNECTION=mysql\
DB_HOST=mysql\
DB_PORT=3306\
DB_DATABASE=rubik\
DB_USERNAME=sail\
DB_PASSWORD=password\
I haven't figured what's wrong with docker config, but for running artisan command locally DB_HOST should be changed to 127.0.0.1

Run Sail (docker containers for laravel): <code>./vendor/bin/sail up</code>

Run migrations: <code>php artisan migrate</code>

 It works at localhost

<code>GET /create</code> - create and/or reset cube to initial state\
<code>GET /rotate/{front|top|left|right|back|bottom}/{cw|ccw}</code> - rotate selected face in selected direction\
<code>GET /shuffle</code> - randomly shuffle cube\

return json example:
<code>{"data":{"id":1,"state":{"front":[["B","B","B"],["B","B","B"],["B","B","B"]],"left":[["O","O","O"],["O","O","O"],["O","O","O"]],"right":[["W","W","W"],["W","W","W"],["W","W","W"]],"back":[["R","R","R"],["R","R","R"],["R","R","R"]],"top":[["G","G","G"],["G","G","G"],["G","G","G"]],"bottom":[["Y","Y","Y"],["Y","Y","Y"],["Y","Y","Y"]]},"created_at":"2022-09-12T00:01:20.000000Z","updated_at":"2022-09-12T03:27:39.000000Z"}}</code>
