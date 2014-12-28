
## Documentation

The app is made with the PHP MVC framework Laravel4. 

#### Controllers & Routes
* **index**: Displays the default city, as specified in **.env.php**. 
* **search**: Does the actual search for a city a user performs.

#### Models
* **Search**: is responsible for storing and retrieving a search of a city and their tweets. And connecting and fetching the coordinates to a city from the Google API.
* **Tweet**: is responsible for connecting, authenticating and fetching the tweets from the Twitter API.

#### Views
* **index**: Draws the profile pictures and tweets on the Google map using it's API. Uses **jQuery** to submit the form, and store and retrieve session data.
* **searchform**: Displays the search form, submit and history button.
* **error**: Displays error messages (if any).

#### Database & Migrations
The app uses an sqlite3 database. The tables are automatically created by migrations when the app is installed. The schema contains only two tables.

* **searches**: Stores the name of the searched city and it's coordinates.
* **tweets**: Stores the username, tweet, profile picture and the the coordinates of the tweet.

**app/database/sqlite/production.sqlite**

![DB Diagram](https://raw.githubusercontent.com/dan-klasson/tweet-search/master/app/docs/diagram.png)

