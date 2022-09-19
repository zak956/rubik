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

Run Sail (docker containers for laravel): <code>./vendor/bin/sail up -d</code>

Run migrations: <code>php artisan migrate</code>

It works at localhost.\
Multiple cubes can be created and manipulated

<code>POST /api/cube/create</code> - create cube to initial state\
<code>GET /api/cube/{cube_id}/rotate/{front|top|left|right|back|bottom}/{cw|ccw}</code> - rotate selected face in selected direction\
<code>GET /api/cube/{cube_id}/shuffle</code> - randomly shuffle cube\
<code>GET /api/cube/{cube_id}/init</code> - reset cube to initial state\
<code>GET /api/cube/{cube_id}</code> - get cube\

return json example:
<code>{"data":{"id":1,"state":{"front":[["B","B","B"],["B","B","B"],["B","B","B"]],"left":[["O","O","O"],["O","O","O"],["O","O","O"]],"right":[["W","W","W"],["W","W","W"],["W","W","W"]],"back":[["R","R","R"],["R","R","R"],["R","R","R"]],"top":[["G","G","G"],["G","G","G"],["G","G","G"]],"bottom":[["Y","Y","Y"],["Y","Y","Y"],["Y","Y","Y"]]}}}</code>
