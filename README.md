## Table of Contents
1. [General Info](#general-info)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Usage](#usage)
5. [Contact](#contact)
## General Info
The objective is to implement a REST API that manages a product catalog.

## Technologies
The project consists of two parts :
1. The Back-end part is developed with the framework Symfony version 4.4 that implements the REST API.
2. The Front-end part is developed with React.js version 18 that implements the views powered by REST API.
## Installation
```
$ git clone https://github.com/Arbi-Slimen/PROJECT-ATS-DIGITAL.git
```
1. The Back-end part with Symfony.
```
$ cd backend-symfony
$ composer update //php composer.phar update
```
Configure the database in the .env file.

DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
```
$ php bin/console doctrine:schema:update --force
$ php bin/console server:start
```
Access the application with the URL http://127.0.0.1:8000.

2. The Front-end part with React.js.
```
$ cd frontend-react
$ npm install
$ npm start
```
Access the application with the URL http://127.0.0.1:3000.
## Usage
REST API endpoints :
1. Import the products list into the database.
 ```
 POST /api/products
 
 example: POST http://127.0.0.1:8000/api/products
```
2. Return products list based on pagination and filters.
 ```
 GET /api/products
 
 pagination: page     // default value 1 
             limit    // default value 12
             
 filters:    productName
             category
             price    //price higher than the input
             averageScore //averageScore higher than the input
             
example: GET http://127.0.0.1:8000/api/products?page=1&limit=12&productName=pizza&category=Practical&price=200&averageScore=3
```
3. Return the detailed product sheet.
 ```
 GET /api/product/{id}
 ```
## Contact
> If you have any questions, please email at arbislimen@gmail.com.
