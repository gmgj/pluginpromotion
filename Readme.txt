1) First you need to get the software to a new (recommeded) or existing directory on your server

For example
1) create a new directory on you server called couponPromotion or whatever you want
2a) either unzip and ftp the software to the new directory
2B) upload the zip to your server and unzip it their

You want to end up with a directory structure something like this
in ..couponPromotion
       coupon_db_config_inc.php
       coupon_db_setup.php
  ....
in ..couponPromotion/required_files
       gj_csrf.inc.php
       GMconfirm.php
    .....

2) After you upload this to you server

create a bookmark link to

http://yourserver.com/couponPromotion/coupon_admin.php

replace yourserver.com  with you actual server name
replace couponPromtion with the actual path to the software files you created above

then go to the link you just created to see the in you browser to the admin page
with title PopUp Coupon Admin

follow the instructions from top to bottom until you get to
Run Test Popup Page