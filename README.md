## About 

This is an example laravel backend to integrate with Equity's jenga api.

## Installation

-Clone or download the repository

-Cd to the project and run composer install or update

-Setup env and migrate tables


## Configurations

-Setup the UAT and Prod url

-Enter merchant details in the Jenga Accounts table

-Run the below in the directory where you want the keys to be stored

-Generate signature by:

    - openssl genrsa -out privatekey.pem 2048

-then

    - openssl rsa -in privatekey.pem -outform PEM -pubout -out publickey.pem

