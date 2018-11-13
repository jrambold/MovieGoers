# Back-End Developer Test

## Overview
Your client has tasked you with making a RESTful API to support the ultimate Moviegoers Guide suite of applications.
They are asking for an API that serves up:

* A list of movies
  * The user should be able to search the movies by title
  * The user should be able to filter the movies by rating
  * The user should be able to filter the movies by category
* Movie details for each movie
* A list of actors in a movie

We have provided a mysql database of movie info for you.
We have also provided a starter PHP application using the SLIM framework although you are free to use the language and framework of your choice - Ruby, Node, etc.

## Installation

### Docker
You will need Docker installed.
Here are the instructions to install Docker for ([Mac](https://docs.docker.com/docker-for-mac/install/)) or ([Windows](https://docs.docker.com/docker-for-windows/install/)). For older systems that do not meet the docker requirements, use the [Docker Toolbox](https://docs.docker.com/toolbox/overview) installation instructions.

_NOTE if using Docker Toolbox_: To verify you may have to use the ip address of the docker machine. In the _verify installation_ section you will want to use the ip address returned by `docker-machine ip` instead of localhost.

### Composer

You will also need to install Composer if you plan to use our starter PHP application.
Here are the instructions to install [Composer](https://getcomposer.org/download)

Launch the test code with the following commands

```
cd developer_test_server/movies
composer install
cd ../
docker-compose up -d
```

### Verify Installation

In a browser navigate to http://localhost:3000/movies. You should see ```[]``` returned from the request.

_Note_: If you don't see the empty array, run ```docker-compose logs``` and wait for all the containers to be fully loaded. Once the containers are completely loaded you should be able to hit the movies endpoint.

### Database Connection Information

__host__: 127.0.0.1<br />
__username__: sakila<br />
__password__: sakila<br />
__database__: sakila<br />
__port__: 3306

## Submitting Your App
When you have completed your app, please post it in a public repository and send us a link - GitHub, GitLab, BitBucket etc.

## Submitted App Info

Endpoints
* /movies
* /movies/{id}

The individual movie takes the database ID as an argument.

Movies endpoint takes header arguments. Any combination of header arguments works.

* TITLE

Will pull up any title in which the string appears anywhere in the title

* RATINGS

Takes CSV input of the rating strings ex: G,PG,PG-13

* CATEGORIES

Takes CSV input of category names ex: Documentary,Horror

Uses sakila's nicer but slower film list view for formatting json output.

```
[
    {
        "0": "2",
        "1": "ACE GOLDFINGER",
        "2": "A Astounding Epistle of a Database Administrator And a Explorer who must Find a Car in Ancient China",
        "3": "Horror",
        "4": "4.99",
        "5": "48",
        "6": "G",
        "7": "Bob Fawcett, Minnie Zellweger, Sean Guiness, Chris Depp",
        "FID": "2",
        "title": "ACE GOLDFINGER",
        "description": "A Astounding Epistle of a Database Administrator And a Explorer who must Find a Car in Ancient China",
        "category": "Horror",
        "price": "4.99",
        "length": "48",
        "rating": "G",
        "actors": "Bob Fawcett, Minnie Zellweger, Sean Guiness, Chris Depp"
    },
]
```
