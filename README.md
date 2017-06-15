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
1, download all files to your apache htdoc. 
2, modify configure.php, replace $primo_return [] with your campus data
$primo_return = 'https://[YOUR PRIMO SITE]/primo-explore/account?vid=[YOUR PRIMO CAMPUS VID]&sortby=rank&lang=en_US&section=overview';
3, modify almaUpdae.php, replace $apikey with your own alma apikey
4, in Paypal setup below, need to modify configure.php variable $auth_token and $ppvars with Paypal information


Paypale setup
1, apply for a paypal standard business account. Paypal standard business account is free and offers Payment Data Transfer feature.
2, log into the paypal standard business account.
3, click on Profile next to Logout button, click on Profile and settings.
4, select My Selling Tools from left menu.
5, click Update for Website preferences.
6, under Auto Return for Website Payments, select Auto Return On.
7, in Return URL field, enter https://[Your Apache/PHP server]/[path to script]/pdt.php 
8, under Payment Data Transfer (optional), select Payment Data Transfer On.
9, copy Identity Token under Payment Data Transfer (optional), and paste it to configure.php as value of $auth_token. 
10, check other left menu settings to fit your own campus, like business name...etc.
11, now go to top menu Tools, click on Paypal buttons.
12, on My Saved Buttons page, click on Create new button under Related Items 
13, on Create Paypal payment button page, step 1, select Buy Now under Choose a button type.
14, enter Item Name field (something like XXX Library Fine/Fee).
15, enter 0 under Shipping
16, enter 0 under Tax
17, step 2, uncheck Save button at Paypal (saving button at paypal prevent us from passing patrons' fine amount to paypal, so uncheck it).
18, step 3, select No to first three questions.
19, check Take customers to this URL when they cancel their checkout, and enter $primo_return url from above Code setup section here.
20, click the Save Changes button
21, on Add your button code to your webpage page, select Email tab
22, copy url query string starting after ? to end of url, and paste it to configure.php as value of $ppvars
23, you could log out paypal account now.

Primo setup
1, log into Primo Back Office
2, go to Advanced Configuration->All Mapping Tables, look for My Account Links
3, click on Edit
4, under Create a New Mapping row, select your view ID, select fines.payfinelink as Link Code value
5, in Link URL field, enter https://[Your Apache/PHP server]/[path to script]/form.htm
6, enter description, click create, Save, then deploy
7, a PAY FINE link will show up in patrons' Primo My Library Card Fine+Fee section



