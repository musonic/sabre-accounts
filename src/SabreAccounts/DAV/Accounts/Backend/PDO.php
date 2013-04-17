<?php
namespace SabreAccounts\DAV\Accounts\Backend;

use SabreAccounts\DAV\Accounts\Backend\BackendInterface;

/**
 * User backend class
 *
 * This class handles creation of new users and principals
 *
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
    
    public function createUser($params) {
        
        $stmt = $this->pdo->prepare('INSERT INTO '.$this->tableName.' (username, digesta1) VALUES (?,?)');
        $stmt->execute(array($params->username, $params->digesta1));
        return true;
    }   

    
}