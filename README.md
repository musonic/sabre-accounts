SabreAccounts
=============

Accounts plugin for SabreDAV (https://github.com/evert/SabreDAV) a WebDAV framework for PHP. 
This plugin allows for the creation of users and principals remotely via HTTP request.
If you're not sure what the difference is then take a look here:
http://tools.ietf.org/html/rfc3744#section-2

REQUIREMENTS
============

This requires SabreDAV version 1.8 or later.

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

TO CREATE A USER

The plugin works by sending an HTTP POST request to the server with a custom header and a very simple JSON body.
The request MUST include the following:

1) A "Content-Type" header of "application/json"

2) A "request-username" header that matches the username of your superuser.

3) A request body in JSON format that simply contains the username of user you want to add along with a password in digesta1
format. eg.

    $body = json_encode(array('username'=>$username, 'digesta1'=>$password));
    
TO CREATE A PRINCIPAL

1) Update your server.php file to use the correct principals backend 

    $principalsBackend = new \SabreAccounts\DAVACL\PrincipalBackend\MusonicPDO($pdo, $principalsTable, $groupMembersTableName);

2) Update your document tree so that the principals collection is an instance of SabreAccounts\CalDAV\Principal\MusonicCollection

3) To create a new principal you need to make a MKCOL request. The body of the request should be something like this:

    <?xml version="1.0" encoding="utf-8" ?>
            <D:mkcol xmlns:D="DAV:" xmlns:S="http://sabredav.org/ns">
                <D:set>
                    <D:prop>
                        <D:resourcetype>
                            <D:collection/>
                            <D:principal/>
                        </D:resourcetype>
                        <D:displayname>Joe Bloggs</D:displayname>
                        <S:email-address>joebloggs@example.com</S:email-address>
                    </D:prop>
                </D:set>
            </D:mkcol>
            
Remember to make the request to the principal you are creating. ie /principals/newprincipal, not just /principals/


