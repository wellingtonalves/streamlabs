# Top StreamStats app

StreamStats is an application designed to display information about Twitch streams.

## Stacks
- PHP
- VueJs
- Redis (Jobs)
- Memcached (Cache)
- Realtime communication
- MySql


## Requirements with Docker
- Just Docker!

## Requirements without Docker
- php ˆ7.4
- node 12
- composer
- memcached
- redis
- pusher
- mySql
- supervisor
- cron

## Environment
You will need to fill in these keys before starting!

[Twitch (get here)](https://dev.twitch.tv)
```bash
TWITCH_HELIX_KEY=
TWITCH_HELIX_SECRET=
TWITCH_HELIX_REDIRECT_URI=
```

[Pusher (get here)](https://pusher.com/)
```bash
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```

If you want to enable caching in the app it's here. Default: yes.
```bash
CACHE_ENABLED=true
```

## Installation

Run Docker, Run!

```bash
docker-composer up --build
```

## Server
The app runs on http://localhost:8000

## Here are some instructions
- On the first screen you will need to log in your Twitch account.
- The first API call brings result from the database using SQL.
- If you click on pagination or sorting, the API will bring up the results from the database using data aggregation.
- If you have enabled real-time communication before, every fifteen minutes the API will be called automatically on the front-end.
- If you have enabled caching before, all API calls will be cached.

## Screenshots
<img src="/public/images/1.png" height="300">
<img src="/public/images/2.png" height="300">
<img src="/public/images/3.png" height="300">
<img src="/public/images/4.png" height="300">
<img src="/public/images/5.png" height="300">
<img src="/public/images/6.png" height="300">
<img src="/public/images/7.png" height="300">
