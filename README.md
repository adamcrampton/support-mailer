# support-mailer
Simple app for building support request emails

The aim of this app is to provide a front end for staff to submit a support request, using fields to easily capture the data.

Configurable items include:
* Intro text on form page
* Storing support provider name and email addresses (with a default setting)
* Option to show one or multiple providers
* Staff list, and the option to show a select or blank input for this (in case you don't want to maintain a staff list)
* Issue type list

On submitting, an email will be sent to the support provider with:
* Intro text
* Staff details (name, preferred contact method)
* Issue type
* Details

The email will be sent from the staff member's email address, so this is ideal for support providers that send an automated response when they receive a request, confirming a ticket has been created.
