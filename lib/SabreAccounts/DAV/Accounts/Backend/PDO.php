<?php
namespace SabreAccounts\DAV\Accounts\Backend;

use SabreAccounts\DAV\Accounts\Backend\BackendInterface;

/**
 * User backend class
 *
 * This class handles creation of new users and principals
 *
 *
 * @copyright Copyright (C) 2013 Nic Le Breuilly. All rights reserved.
 * @author Nic Le Breuilly
 * @license https://github.com/musonic/SabreAccounts/blob/master/src/SabreAccounts/LICENSE Modified BSD License
 */
class PDO implements BackendInterface {

    /**
     * Reference to PDO connection
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * PDO table name we'll be using
     *
     * @var string
     */
    protected $tableName;
    
    /**
     * Creates the backend object.
     *
     * If the filename argument is passed in, it will parse out the specified file fist.
     *
     * @param PDO $pdo
     * @param string $tableName The PDO table name to use
     */
    public function __construct(\PDO $pdo, $tableName = 'users') {

        $this->pdo = $pdo; 
        $this->tableName = $tableName;

    } 
    
	/**
	 * Creates a new user
	 * 
	 * @param string $username
	 * @param string $hash
	 */
    public function createUser($username, $hash) {
        
        $stmt = $this->pdo->prepare('INSERT INTO '.$this->tableName.' (username, digesta1) VALUES (?,?)');
		
		return $stmt->execute(array($username, $hash));
        
    }   

    
}