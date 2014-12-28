
# Documentation

The app is made with the PHP MVC framework Laravel4. 

## Installation

#### Install dependencies (Ubuntu)

	sudo apt-get install php5 sqlite3 php5-sqlite

#### App install instructions

First you need to clone the app from the repository:

	$ git clone https://github.com/dan-klasson/tweet-search
	$ cd tweet-search/

Then copy the template environment file and add the necessary information like API keys and tokens:

    $ mv .env.template.php .env.php
	$ vim .env.php

You can then install the app by doing:

	$ php composer.phar install

If you're using `apache2` you might want to create a symlink from your public html folder to the public folder (Ubuntu):

	$ sudo ln -s ../tweet-search /var/www/html/tweet-search/public

You should then be able to access the site using the following url:

[http://localhost/tweet-search](http://localhost/tweet-search)

## App Documentation

#### Controllers & Routes
* **index**: Displays the default city, as specified in `.env.php`. 
* **search**: Does the actual search for a city a user performs.

#### Models
* **Search**: is responsible for storing and retrieving a search of a city and their tweets. And connecting and fetching the coordinates to a city from the Google API.
* **Tweet**: is responsible for connecting, authenticating and fetching the tweets from the Twitter API.

#### Views
* **index**: Draws the profile pictures and tweets on the Google map using it's API. Uses `jQuery` to submit the form, and store and retrieve session data.
* **search_form**: Displays the search form, submit and history button.
* **error**: Displays error messages (if any).

#### Database & Migrations
The app uses an sqlite3 database. The tables are automatically created by migrations when the app is installed. The schema contains only two tables.

* **searches**: Stores the name of the searched city and it's coordinates.
* **tweets**: Stores the username, tweet, profile picture and the the coordinates of the tweet.

**app/database/sqlite/production.sqlite**

![DB Diagram](https://raw.githubusercontent.com/dan-klasson/tweet-search/master/app/docs/diagram.png)


