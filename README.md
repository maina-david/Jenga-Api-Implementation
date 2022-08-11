## About

This is an example laravel backend to integrate with Equity's jenga api.

## Installation

Clone or download the repository

Cd to the project and run composer install or update

Setup env and migrate tables

## Configurations

Setup the UAT and Prod url

Enter merchant details in the Jenga Accounts table

Run the below in the directory where you want the keys to be stored

Generate signature by:

    openssl genrsa out privatekey.pem 2048

Then run the below command to generate the public key

    openssl rsa -in privatekey.pem -outform PEM -pubout -out publickey.pem

Locate and open the publickey.pem and copy paste in to https://v3.jengahq.io/dashboard/settings/api-keys

The private key is called in the accountservices helper, so adjust the folder to point to the directory you chose to store the keys
