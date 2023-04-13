# The Festival -Group-5 IT2A

It contains a docker configuration with:
* NGINX webserver
* PHP FastCGI Process Manager with PDO MySQL support
* Azure Mysql Db
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

##Live App :
https://thefestivalinhollland.000webhostapp.com

Login Credentials:

Admin 
email Address:
```bash
test@inholland.nl
```
Password:
```bash
12
```
Customer
email Address:
```bash
eerwin@gmail.com
```
Password
```bash
12
```
Employee
email Address:
```bash
bijay@gmail.com
```
Password
```bash
12
```

> **_NOTE:_**
We deployed the website with 000 web host and we treied to use the databse from it but it said max connection user allowed which on searching found out that it needs to be upgraded to use that database so we are using the database from azure So , it takes the time to load pages. some of the error are also occuring in deployed website  for ajax request like ' net::ERR_HTTP2_PROTOCOL_ERROR' which we had no Idea. , cpatcha is not valid for web host.


There is Decision List also in Directory If Needed.


