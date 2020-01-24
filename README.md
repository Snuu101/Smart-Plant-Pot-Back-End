# Smart Plant Pot - Back End

<p align="center">
<img width="450" alt="back end technologies" src="/Readme_Images/backend.JPG")
</p>

The Smart Pant Pot back end is part of the Smart Plant Pot project, click [here](https://github.com/Snuu101/Smart-Plant-Pot) for more information about the whole project.

The Smart Plant Pot back end consists of a SQL Database and a REST API.
The REST API provides the infrastructure for the communication between Raspberry PI and iOS app with the MySQL database. The API is written in PHP and uses simple HTTP-requests (GET, POST, PUT) for the communication. The payload of the HTTP-requests is alwas a JSON file.

# How to
The following steps must be completed in order to run the REST API:

- Setup a MySQL Database on your server
- The MySQL Database can be created using the provided *Create_Smart-Plant-Pot_DB.sql* file
- Put the *api*, *config* and *model* folders on your Server
- Additionally create a folder named *images* this is needed to store pictures from the webcam
- Configure the API: Edit *Database.php* in the *config* folder (see README.md inside for more information)

# Database Model
The database model shows the relation between the tables, items and the data types.

![Database model](/Readme_Images/DatabaseModelpng.png)

# REST API Documentation
The REST API documentation provides information about alle accepted queries by the MySQL database and also about the schema of the contents of the database respond.
The documentation can be found on [swagger.io](https://app.swaggerhub.com/apis-docs/Smart-Plant-Pot/SmartPlantPot/1.0.0)
