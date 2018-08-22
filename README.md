# support-mailer

## Introduction
The aim of this app is to provide a simple front end for staff to submit a support request, using fields to easily capture the data.

Configurable items include:
* Form heading
* Form title
* Intro text on form page
* Storing support provider name and email addresses (with a default setting)
* Option to show one or multiple providers
* Staff list, and the option to show a select or blank input for this (in case you don't want to maintain a staff list)
* Issue type list
* User management

On submitting, an email will be sent to the support provider with:
* Intro text
* Staff details (name, preferred contact method)
* Issue type
* Details

The email will be sent from the staff member's email address, so this is ideal for support providers that send an automated response when they receive a request (e.g. Zendesk), confirming a ticket has been created.

## Installation
A few quick notes for Windows + Vagrant (e.g. Homestead) devs:
* You will probably have to SSH into the Vagrant box to run the composer and artisan commands. I'm sure there's a way around this, but if you're struggling to run these commands from a bash console, this is the easiest thing to do.
* Unless you already have npm running properly in your environment, save yourself the hassle and install node.js for Windows now (unless you feel like wrasslin' with Vagrant for hours).
* Don't forget to update your hosts file, as well as Homestead.yaml if you're using it.

Oh, one other thing - I highly recommend using mailtrap.io for testing your dev output. It's really simple to set up and is easier than building render methods (ymmv of course).

As follows:
1. Clone the repo
1. Run composer install
1. Copy the .env.example to .env, update the settings to match your environment.
1. Add User table seed config to your .env file - see UsersTableSeeder.php for the specifics
1. Generate an app key - php artisan key:generate
1. Create your database
1. Migrate and seed your database - php artisan:migrate --seed (or leave the seed switch off if you prefer not to)
1. Run npm install from the project root
1. Run npm run dev - this will copy Bootstrap 4 and jQuery into your public directory (via Webpack)

## TODO List
* Integrate user permissions into Auth and wrap certain items in these checks (e.g. Manage Users for Admins)
* Build log viewer
* Add file uploading functionality
* Optimise loops + database queries - there's some not-very-good stuff in there
* LDAP to pull AD users in via cron job