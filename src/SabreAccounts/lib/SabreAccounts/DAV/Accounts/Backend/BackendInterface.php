<?php
namespace SabreAccounts\DAV\Accounts\Backend;

/**
 * @copyright Copyright (C) 2013 Nic Le Breuilly. All rights reserved.
 * @author Nic Le Breuilly
 * @license https://github.com/musonic/SabreAccounts/blob/master/src/SabreAccounts/LICENSE Modified BSD License
 */
interface BackendInterace {
    
     /**
     * Creates a new user
     *
     * If creation is successful, true must be returned.
     *
	 * @param string $username
	 * @param string $hash
     * @return bool
     */
    function createUser($username, $hash);
    
}