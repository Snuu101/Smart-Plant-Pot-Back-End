# Smart Plant Pot - Back-End
The Smart Pant Pot - Back-End is part of the Smart Plant Pot project, klick [here](https://github.com/Snuu101/Smart-Plant-Pot) for more information about the whole project.
The Smart Plant Pot Back-End consists of a SQL Database and a REST API.
The REST API provides the infrastructure for the comunication between Raspberry PI and iOS-App with the mySQL database.

# How to
The following steps must be completed in order to run the REST API:

- Setup a mySQL Database on your server
- The mySQL Database can be created using the provided *Create_Smart-Plant-Pot_DB.sql* file
- Put *api*, *config* and *model* Folders on your Server
- Configure the API in the config folder (see Read.me inside)

# Database Model
The database model shows the relation between the tables, items and the datatypes.

![Database model](/Readme_Images/DatabaseModelpng.png)

# REST API Documentation
The REST API documantation provides information about alle accepted querys by the mySQL Database and also about schema of the contents of the database respond.
The documentation can be found [here](https://app.swaggerhub.com/apis-docs/Smart-Plant-Pot/SmartPlantPot/1.0.0)
