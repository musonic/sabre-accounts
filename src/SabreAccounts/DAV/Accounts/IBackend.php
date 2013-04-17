<?php
namespace DepbookSabre\DAV\Accounts;

/**
 * This is the base class for any user object.
 *
 * @package Sabre
 * @subpackage DAV
 * @copyright Copyright (C) 2007-2012 Nic Le Breuilly. All rights reserved.
 * @author Nic Le Breuilly 
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
interface IBackend {
    
     /**
     * Creates a new user
     *
     * If creation is successful, true must be returned.
     * If creation fails, an exception must be thrown.
     *
     * @return bool
     */
    function createUser($params);

    /**
     * Creates a new principal
     *
     * If creation is successful, true must be returned.
     * If creation fails, an exception must be thrown.
     *
     * @return bool
     */
    // function createPrincipal();
    
}