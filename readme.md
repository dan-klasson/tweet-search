
# Tweet-Search

This is a simple app I did as an assignment for [Gomeeki](http://gomeeki.com.au/). You can search tweets about a city, which is then displayed on a Google map of that city. Each search is stored in a database for caching reasons. There is also a history function of all searches the user have made.

Documentation can be found [here](https://github.com/dan-klasson/tweet-search/tree/master/app/docs)

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

