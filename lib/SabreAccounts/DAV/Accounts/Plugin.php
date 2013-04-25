<?php
namespace SabreAccounts\DAV\Accounts;

use Sabre\DAV\ServerPlugin;
use Sabre\DAV\Server;
use SabreAccounts\DAV\Accounts\Backend\PDO;

/**
 * Add User Plugin
 *
 * This plugin allows the creation of new users and principals. A "superUser"
 * needs to be authorized first to complete the request and this user must
 * be hardcoded initially into the database.
 *
 * The principal uri can be modified to allow for more complex situations if required.
 * 
 *
 * @copyright Copyright (C) 2013 Nic Le Breuilly. All rights reserved.
 * @author Nic Le Breuilly
 * @license https://github.com/musonic/SabreAccounts/blob/master/src/SabreAccounts/LICENSE Modified BSD License
 */
class Plugin extends ServerPlugin {
    
    public $server; 
    
    /**
     * Accounts backend
     *
     * @var Sabre\DAV\Accounts\Backend\BackendInterface
     */
    private $accountsBackend;
    
    /**
     * Superuser name
     */
    public $superuser = 'admin';
    
    /**
     * __construct
     *
     * @param Sabre\DAV\Accounts\Backend\BackendInterface $userBackend
     */
    public function __construct(PDO $accountsBackend) {

        $this->accountsBackend = $accountsBackend;

    }
    
    function getFeatures() {
        
        return array();
        
    }
    
    function set_superuser($username) {
        $this->superuser = $username;
    }
    
    function initialize(Server $server) {
        
        $this->server = $server;
        $server->subscribeEvent('beforeMethod',array($this,'httpPostInterceptor'));
        
    }
    
    function httpPostInterceptor($method) {
        
        if ($method !== 'POST') return true;
		
	// check that the request comes from the currently logged in user
	$authPlugin = $this->server->getPlugin('auth');
	$userName = $authPlugin->getCurrentUser();
	if($userName == NULL || $userName !== $this->superuser) {
		return true;
	}
        
        // check the MIME type of the request. We only want to intercept requests that 
        // have the mime-type "application/json"
        $contentType = $this->server->httpRequest->getHeader('Content-Type');
        list($contentType) = explode(';', $contentType);
        if ($contentType !== 'application/json') {
                return true;
        }
        
		// passing true to the getBody method returns a string
        $body = $this->server->httpRequest->getBody(true); 
        
        // the request body should be simple json object with the username and digestA1 password
        $params = json_decode($body);
         
        // check we have what we need
        if(!$params->username || !$params->digesta1)
        { 
            return true;
        }
        
        // send the data to the backend
        return $this->accountsBackend->createUser($params->username, $params->digesta1) ? false : true;
        
    }
    
}
