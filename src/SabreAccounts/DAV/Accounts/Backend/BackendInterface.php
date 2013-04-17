<?php
namespace SabreAccounts\DAV\Accounts\Backend;

/**
 * This is the base class for any user object.
 *
 */
interface BackendInterace {
    
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