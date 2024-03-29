<?php
define('NAVBAR_TITLE', 'Create an Account');
define('HEADING_TITLE', 'My Account Information');
define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>NOTE:</b></font></small> If you already have an account with us, please login at the <a href="%s"><u>login page</u></a>.');
define('EMAIL_SUBJECT', 'Welcome to ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");
define('EMAIL_WELCOME', 'We welcome you to <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_USERNAME', 'Your username is: <b>' . stripslashes($HTTP_POST_VARS['email_address']) . '</b>' . "\n\n");
define('EMAIL_PASSWORD', 'Youre password is:' . stripslashes($HTTP_POST_VARS['password']) . "\n\n");
define('ENTRY_EMAIL_WARNING', '<font color=FF0000">Your password will be emailed to the adress you provided above. Please change your default password when you login for the first time</font>');
define('EMAIL_TEXT', 'You can now take part in the <b>various services</b> we have to offer you. Some of these services include:' . "\n\n" . '<li><b>Permanent Cart</b> - Any products added to your online cart remain there until you remove them, or check them out.' . "\n" . '<li><b>Address Book</b> - We can now deliver your products to another address other than yours! This is perfect to send birthday gifts direct to the birthday-person themselves.' . "\n" . '<li><b>Order History</b> - View your history of purchases that you have made with us.' . "\n" . '<li><b>Products Reviews</b> - Share your opinions on products with our other customers.' . "\n\n");
define('EMAIL_CONTACT', 'For help with any of our online services, please email the store-owner: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Note:</b> This email address was given to us by one of our customers. If you did not signup to be a member, please send an email to ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
//TotalB2B start
define('EMAIL_VALIDATE_SUBJECT', 'New customer at '. STORE_NAME);
define('EMAIL_VALIDATE', 'A new customer registered at '. STORE_NAME);
define('EMAIL_VALIDATE_PROFILE', 'To see customer profile click here:');
define('EMAIL_VALIDATE_ACTIVATE', 'To activate customer click here:');
//TotalB2B end
?>