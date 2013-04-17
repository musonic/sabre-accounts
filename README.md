SabreAccounts
=============

Accounts plugin for SabreDAV (https://github.com/evert/SabreDAV) a WebDAV framework for PHP. 
This plugin allows for the creation of users remotely via HTTP request.

INSTALLATION
============

This assumes that you have setup a users table in your database as outlined here:
https://code.google.com/p/sabredav/wiki/CalDAV#Database_setup

1) Manually add a 'super_user' to your users table. This user is the only user authorized to add new users to the database.

2) Update your server.php file (or whatever you have named it)

    $accountsBackend = new \SabreAccounts\DAV\Accounts\Backend\PDO($pdo);
    $account = new \SabreAccounts\DAV\Accounts\Plugin($accountsBackend);
    $account->set_superuser('your_super_user');
    $server->addPlugin($account);

USAGE
=====

The plugin works by sending an HTTP POST request to the server with a custom header and a very simple JSON body.
The request MUST include the following:

1) A "Content-Type" header of "application/json"
2) A "request-username" header that matches the username of your superuser.
3) A request body in JSON format that simply contains the username of user you want to add along with a password in digesta1
format. 
eg. $body = json_encode(array('username'=>$username, 'digesta1'=>$password));

