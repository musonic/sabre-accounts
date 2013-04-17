<?php
namespace DepbookSabre\DAV\Accounts\Backend;

/**
 * User backend class
 *
 * This class handles creation of new users and principals
 *
 * @package Sabre
 * @subpackage DAV
 * @copyright Copyright (C) 2007-2012 Nic Le Breuilly. All rights reserved.
 * @author NIc Le Breuilly
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
class PDO implements \DepbookSabre\DAV\Accounts\IBackend {

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
    
    public function createUser($params) {
        
        $stmt = $this->pdo->prepare('INSERT INTO '.$this->tableName.' (username, digesta1) VALUES (?,?)');
        $stmt->execute(array($params->username, $params->digesta1));
        return true;
    }   

    
}