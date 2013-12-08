<?php
/*
you need to run the Software Versions Check (PHPandServerInfo.php)
and look for the line with

"OK You are running a version of PHP" , you can continue
If you see a line with "Not OK" , stop and please contact us

also, find the line starting with   url of gjwhere

Copy this value so that you can enter in for the variable $gjwhere below

Before you run or execute the script
Run Database setup (coupon_db_setup) from the PopUp Coupon Admin (coupon_admin.php) page,

I.
1) create a mysql database or select an existing database for inclusion of the popup database table (you need database name)
2) create a user or select an existing user with full privileges for that database (you need username and password)

If you use Cpanel, its common to have a MySQL Databases button

a) click on it and add or select your database
b) add or select your Mysql User and password
c) make sure you User is has been added (or is already assigned) to the database, giving it all privileges

II.
If you have cpanel you can go into filemanager and click on the file and select edit.
or you can edit this file on you computer and upload it to the popup directory

If this is confusing to you, please consider having us install the software for you for a nominal fee.

Use an ---EDITOR-- to change the values for $server, $username, $password, $database and $gjwhere
for your test (if you have one) and production servers
in this file, coupon_db_config_inc.php, at the bottom of the file

see the section marked with
=======================
edit below
CONFIGURATION SETTINGS
======================

III.
Return to coupon_admin and click on Run Database setup on this host

Example FAILURE

If you see the line towards the bottom of the page

NOT OK You have errors

and you may see error messages like the following:

Warning: mysqli_connect() [function.mysqli-connect]: (28000/1045): Access denied for user 'garyjohn__mcadam'@'ionr.fleetnetworkshosting.com' (using password: YES) in /home/garyjohn/public_html/mcadams/coupon_db_setup.php on line 66
Failed to connect to MySQL: Access denied for user 'garyjohn__mcadam'@'ionr.fleetnetworkshosting.com' (using password: YES)

check you usernames, passwords and database variables

Example SUCCESS

If you see the line

OK You are ready to go, you are all set

you will also see confirmation information like the following
Host Info: yourhostname.com via TCP/IP

Table created
Showing List of Fields for table
user_id (smallint(5) unsigned)
First (varchar(20))
Phone (varchar(22))
Email (varchar(30))
OptIn (varchar(21))
date_added (date)

Stored procedure created
..syntax used to create stored procedure
string(281) "CREATE DEFINER=`garyjohn_mcadams`@`209.160.37.65` PROCEDURE `gjGMCEM`(IN strFirst varchar(20),strPhone varchar(30),email varchar(30),OptIn varchar(21),theudate date) BEGIN INSERT INTO gjEmail (First,Phone,Email,OptIn,date_added) VALUES (strFirst,strPhone,email,OptIn,theudate); END"

IV.
Return to the PopUp Coupon Admin (coupon_admin.php) to finish your installation

a) edit your popupsettings
b) print popupsettings

There are other miscellaneous actions on the page to further help you with your installation

Debug Mode is set in this file



/*
| the following section is used to setup debugging
|  $gjLocal  Usually set automatically.
|  $gjDebug  True -  for testing - display all errors / warnings
|            False - for production


See the $gjDebug = TRUE; or gjDebug = FALSE;   below
make it gjDebug = TRUE; to debug
make it gjDebug = FALSE; for normal
*/

$gjDebug = TRUE;

// Determine whether we're working on a local server or on the real server:
$gjHost = substr($_SERVER['HTTP_HOST'], 0, 5);
if (in_array($gjHost, array('local', '127.0', '192.1'))) {
    $gjLocal = TRUE;
} else {
    $gjLocal = FALSE;
}

//debug
if ($gjDebug) {
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors',1);
    ini_set('log_errors',1); //!!!!!
} else {
    error_reporting(E_ALL & ~E_DEPRECATED);
    ini_set('display_errors',0);
    ini_set('log_errors',1);
}


if (!isset($gjXdebug)) {
$gjXdebug = FALSE;
}

//$gjXdebug = true;


//if ($gjXdebug) {
if ($gjLocal && $gjXdebug) {
    try {
        ini_set('xdebug.auto_trace', 1);
        ini_set('xdebug.collect_includes', '1');
        ini_set('xdebug.collect_params', '1'); //terse is 1
        ini_set('xdebug.collect_return', '1');
        ini_set('xdebug.collect_vars', '1'); //for xdebug_get_declared_vars().
        ini_set('xdebug.default_enable', '1');
        ini_set('xdebug.dump.SERVER', 'REQUEST_URI,REQUEST_METHOD');
        ini_set('xdebug.dump.GET', '*');
        ini_set('xdebug.dump.SESSION', '*');
        ini_set('xdebug.dump.REQUEST', '*');
        ini_set('xdebug.dump.FILES', '*');
        ini_set('xdebug.dump.COOKIE', '*');
        ini_set('xdebug.dump_globals', '1');
        ini_set('xdebug.max_nesting_level', '50');
        ini_set('xdebug.scream', '1');
        ini_set('xdebug.show_local_vars', '1');
        ini_set('xdebug.trace_format', '0');  //0 is for the editor 1 is for IDEs 2 is html
        ini_set('xdebug.var_display_max_children', '128');
        ini_set('xdebug.var_display_max_data', '-1');
        ini_set('xdebug.var_display_max_depth', '-1');

        xdebug_enable();
        //need this to start tracing on bitnami - use php.ini xdebug.auto_trace=1 to start from begginning

        xdebug_start_trace();
        if (xdebug_is_enabled()) {
             error_log ('Local xdebug on: xdebug_memory_usage(): '.xdebug_memory_usage(). ' gjDebug: '. $gjDebug);
        } else {
             error_log ('Could not turn on xdebug  gjDebug: '. $gjDebug );
        }

    } catch (Exception $e) {
        echo 'Caught Exception -> message: ',  $e->getMessage(), "\n";
    }
} else {
ini_set('xdebug.auto_trace', 0);
//  ? xdebug_stop_trace();
}

/*

| The following section is also used to automatically switch setting for local test and production systems
|

| DATABASE SETTINGS
| -------------------------------------------------------------------
|	$server   The hostname of your database server, usually this is you domain name, see the example below.
|	$username The username used to connect to the database
|	$password The password used to connect to the database
|	$database The name of the database you want to connect to */

/* if you have a test server, the values for the test server go first,
after the line,

if ($gjLocal) {

=======================
edit below
CONFIGURATION SETTINGS
======================

*/


// find the line   url of gjwhere    in check version aka PHPandServerInfo.php
// use single quotes , do not forget the trailing ;
// example $gjwhere = 'http://127.0.0.1/mcadams/required_files/GMsignup.php';


if ($gjLocal) {  // test or local server
    $server = "localhost";
    $username = "garyjohn_mcadams";
    $password = "SnuggleHuggleBunnies";
    $database = "garyjohn_mcadams";
    $gjwhere = 'http://127.0.0.1/mcadams/GMsignup.php';
} else {    /* these are the values for your PRODUCTION or real server */
    $server = 'garyjohnsoninfo.info';
    $username = "garyjohn_mcadams";
    $password = "Snuggle@Huggle!Bunnies";
    $database = "garyjohn_mcadams";
    $gjwhere = 'http://garyjohnsoninfo.info/mcadams/GMsignup.php';
}
