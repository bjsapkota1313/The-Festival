# Basic PHP MVC demo
This repository demonstrates how the MVC design pattern can be implemented using PHP.

It contains a docker configuration with:
* NGINX webserver
* PHP FastCGI Process Manager with PDO MySQL support
* MariaDB (GPL MySQL fork)
* PHPMyAdmin

## Installation

1. Install Docker Desktop on Windows or Mac, or Docker Engine on Linux.
1. Clone the project

## Usage

## Running the Application
**Note:** docker-compose down -v to delete al the volume of the containers and set it again
To run the application, use the command: 
```bash
docker-compose down -v
docker-compose up
```


## login page address
http://localhost/login
first add the tables to the database. You can use sql/User.sql and sql/Role.sql for adding the tables.
The User.sql contains 3 users:
Username        Pass    Role
Sara@gmail.com  Sara    Admin
Alice@gmail.com Alice   Customer
Bob@gmail.com   Bob     Employee

When user is logged in, a session is created. You can use checkLogin method to see if user is logged in or not and who is logged in.