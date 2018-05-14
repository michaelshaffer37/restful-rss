# RESTful Rss

---

A RESTful API application for aggregating and querying RSS feed items.

## Setup

---

Use the following instructions to setup the project.
These instructions were tested Linux but should be compatible with any Unix type systems.

**Expected System Dependencies**

* `docker`
* `docker-compose`

### Configure Local Environment Configuration

Starting from the project root.
Use the following command to create a new local environment file called `.env`.

```bash
cp ./.env.example ./.env
```

_Note: The provided example `.env` file should be sufficient for most local development needs._

### Start Docker Environment

Next use docker compose to build the environment.
During this step docker should build the `restful-rss/app` image and start the app.

```bash
docker-compose up -d
```

### Configure MongoDb Indices

Run the migrations which will configure the correct indices on the mongodb collections.

```bash
docker-compose exec app php artisan migrate
```

## Testing & Linting

The application is configured to validate logic using PhpUnit (`phpunit`) and code style using PHP CodeSniffer (`phpcs`).
Use the following instructions to run these utilities.

### Testing

#### All Tests
```bash
docker-compose exec app composer test
```

#### Specific Test Suite
```bash
docker-compose exec app ./vendor/bin/phpunit --testsuite=<UT|IT|FT>
```

**Test Suites**

* UT: Unit Tests
* IT: Integration Tests
* FT: Functional Tests

### Linting

#### Lint all php files
```bash
docker-compose exec app composer lint
```

#### Auto fix most lint errors
```bash
docker-compose exec app composer lint:fix
```

## Application Overview

This section will attempt to provide a reasonable overview of the application, it's configuration, & interface.

### Services

The application is composed for the following four services.

* **app** (`restful-rss/app`): The main application running the RESTful API.
* **worker** (`restful-rss/app`): The worker application running the asynchronous event handlers.
* **mongodb** (`mongo:3.7.9-jessie`): The MongoDb document store, for maintaining resource state.
* **queue** (`schickling/beanstalkd`): The Beanstalk queue used to store events for asynchronous processing.

_Note: the **app** & **worker** containers use the same code base & docker image, with different entry point commands._

#### app

This service is running the HTTP Web Server handling all application requests.
This project was built on top of the [Lumen Framework](https://lumen.laravel.com/) because of its light-weight, flexable, & stateless design.
There are a few notable aspects to this service.

##### async

This service operates in an asynchronously when handling requests to remote endpoints by queueing serialized events which can be deserialized and processed in the `worker`.

##### Request handling

This project was built using Actions instead of the standard [Controllers](https://lumen.laravel.com/docs/5.6/controllers) found in the [Lumen Framework](https://lumen.laravel.com/).
Although the distinction is minor these actions are singularly responsible.
They are implemented to behave as if they were simple functions through the use of the php magic method `__invoke`.

#### worker

This service is running the CLI entry point to the application which pulls the queue for events and processes them.
This container is what will process the `App\Events\RequestLoadFeed` events, loading the rss feed and storing the `Feed` & `Entry` records.

The primary application code for this is found in the `App\Listeners\LoadRssFeed` class.

#### mongodb

The mongodb service is used to store documents in four different collections.

* `sources`: This collection maintains the status of the source being loaded, the user provided name, & the Rss feed `url`.
* `feeds`: This collection stores information about the loaded Rss Feeds. (link, title, description, feed link etc.)
* `entries`: This collection stores information about the loaded Rss Feed Entries. (title, description, pubDate etc.)
* `migrations`: This collection stores information about the migration files that have been run.

#### queue

The queue service is currently configured to operate as a Beanstalk queue.
The queue stores a serialized version of any event listener that implements the `Illuminate\Contracts\Queue\ShouldQueue` interface for asynchronous processing.
