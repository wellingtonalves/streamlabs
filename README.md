# Top StreamStats app
<img src="https://cdn.streamlabs.com/static/imgs/streamlabs-logos/dark/streamlabs-logo-horizontal.svg" width="450"/>


### StreamLabs Coding Assignment
>  The coding assignment [here]( https://docs.google.com/document/d/1nmA9ZHtPtjFNNX2nknijkrDTz8KJXrUDkG496zFZW4A/edit).

#### Requirements

<small>All requirements have been implemented</small>

#### Bonus Requirements

<small>All bonus requirements have been implemented</small>

## Live Demo
The application is hosted in my own server in the following link:
> removed

## Tech Stacks
>**Backend** (PHP, Laravel, MySQL, Redis, Memcached, Events, Jobs, Cache)

> **Frontend** (VueJs, Vuex, Vuetify, Pusher (Real-time))

## Structure
![Screen Shot 2021-11-17 at 14 32 02](https://user-images.githubusercontent.com/4297908/142251917-8d30964b-36b9-4590-bf86-0c7975d14214.png)

## Workflow

![Screen Shot 2021-11-17 at 13 02 38](https://user-images.githubusercontent.com/4297908/142238588-592a4c03-3946-4b2b-9777-25cc9ce80bb9.png)


## Installation

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

Run Docker, Run!

```bash
docker-composer up --build
```

## Here are some instructions
- On the first screen you will need to log in your Twitch account.
- The first API call brings result from the database using SQL.
- If you click on pagination or sorting, the API will bring up the results from the database using data aggregation.
- If you have enabled real-time communication before, every fifteen minutes the API will be called automatically on the front-end.
- If you have enabled caching before, all API calls will be cached.

## Screenshots

Total per game          |  Highest
:-------------------------:|:-------------------------:
<img src="/public/images/1.png" height="300"> | <img src="/public/images/2.png" height="300">

Odd          |  Even
:-------------------------:|:-------------------------:
<img src="/public/images/3.png" height="300"> | <img src="/public/images/4.png" height="300">

Same amount          |  Top 100
:-------------------------:|:-------------------------:
<img src="/public/images/5.png" height="300"> | <img src="/public/images/6.png" height="300">


### Mobile
<img src="/public/images/7.png" height="300">
