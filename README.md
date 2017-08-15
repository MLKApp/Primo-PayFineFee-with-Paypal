# Primo-PayFineFee-with-Paypal
Primo Payfine with Paypal: Primo patrons pay fine/fee using Paypal payment service. 

Workflow:
* In patrons' Primo My Library Card Fine+Fee section, click on PAY FINE link.
* In an external form, enter patrons' library ID so that we could grab patrons' fine/fee balance amount from Alma and send the amount with ID to Paypal.
* Paypal processes payments via paypal accounts or credit/debit cards, and sends back notification to a script we specify in Paypal.
* The script receives notification from Paypal and updates patrons' Alma fine/fee balance.
* Patrons will be redirected to their Primo account pages.

Requirments:
* A Apache/PHP server to host files
* SSL turned on for the Apache/PHP server
* A Paypal standard business account

Test Paypal process:
* recommend test Paypal process on Paypal sandbox

The instruction consists of three parts of setup:
* Code setup
* Paypale setup
* Primo setup

Code setup
* download all files to your apache htdoc. 
* modify configure.php, replace $primo_return [] with your campus data
$primo_return = 'https://[YOUR PRIMO SITE]/primo-explore/account?vid=[YOUR PRIMO CAMPUS VID]&sortby=rank&lang=en_US&section=overview';
* modify almaUpdae.php, replace $apikey with your own alma apikey
* in Paypal setup below, need to modify configure.php variable $auth_token and $ppvars with Paypal information


Paypale setup
* apply for a paypal standard business account. Paypal standard business account is free and offers Payment Data Transfer feature.
* log into the paypal standard business account.
* click on Profile next to Logout button, click on Profile and settings.
* select My Selling Tools from left menu.
* click Update for Website preferences.
* under Auto Return for Website Payments, select Auto Return On.
* in Return URL field, enter https://[Your Apache/PHP server]/[path to script]/pdt.php 
* under Payment Data Transfer (optional), select Payment Data Transfer On.
* copy Identity Token under Payment Data Transfer (optional), and paste it to configure.php as value of $auth_token. 
* check other left menu settings to fit your own campus, like business name...etc.
* now go to top menu Tools, click on Paypal buttons.
* on My Saved Buttons page, click on Create new button under Related Items 
* on Create Paypal payment button page, step 1, select Buy Now under Choose a button type.
* enter Item Name field (something like XXX Library Fine/Fee).
* enter 0 under Shipping
* enter 0 under Tax
* step 2, uncheck Save button at Paypal (saving button at paypal prevent us from passing patrons' fine amount to paypal, so uncheck it).
* step 3, select No to first three questions.
* check Take customers to this URL when they cancel their checkout, and enter $primo_return url from above Code setup section here.
* click the Save Changes button
* on Add your button code to your webpage page, select Email tab
* copy url query string starting after ? to end of url, and paste it to configure.php as value of $ppvars
* you could log out paypal account now.

Primo setup
* log into Primo Back Office
* go to Advanced Configuration->All Mapping Tables, look for My Account Links
* click on Edit
* under Create a New Mapping row, select your view ID, select fines.payfinelink as Link Code value
* in Link URL field, enter https://[Your Apache/PHP server]/[path to script]/form.htm
* enter description, click create, Save, then deploy
* a PAY FINE link will show up in patrons' Primo My Library Card Fine+Fee section


CREDITS

This application uses Open Source components. You can find the source code of their open source projects along 
with license information below. We acknowledge and are grateful to these developers for their contributions to 
open source.

Project: paypal/pdt-code-samples https://github.com/paypal/pdt-code-samples
License https://github.com/paypal/pdt-code-samples/blob/master/LICENSE.txt

Project: PHP-PayPal-IPN https://github.com/Quixotix/PHP-PayPal-IPN
Copyright (c) 2012, Micah Carrick
All rights reserved.
License https://github.com/Quixotix/PHP-PayPal-IPN/blob/master/LICENSE

