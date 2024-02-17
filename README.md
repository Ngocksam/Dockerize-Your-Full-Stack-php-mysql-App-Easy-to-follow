# Dockerize-Your-Full-Stack-php-mysql-App-Easy-to-follow

This project is a web application that uses PHP and MySQL to create and manage reports, quizzes and sms.

## Prerequisites

To deploy and use this project, you need to have :

- Docker and Docker Compose installed on your machine
- A GitHub account and access to your repository

## Installation

To install this project, follow these steps:

- Clone your GitHub repository on your local machine
- Open a terminal and access the project directory
- Run the command `docker compose up` to create and start Docker containers
- Wait until the containers are ready (you can check the status with the command `docker compose ps`)

## Usage

To use this project, you can access web applications on the following ports:

- Reports: http://localhost:80
- Quizzes: http://localhost:81
- Sms: http://localhost:82

You can also access the phpMyAdmin web interface on port 8080:

- phpMyAdmin: http://localhost:8080

The MySQL database connection identifiers are as follows:

- Host: db
- Port: 3306
- User: phpmyadmin
- Password: phpmyadmin
- Database: phpmyadmin

## License

This project is licensed under the MIT license. See the LICENSE file for details.
