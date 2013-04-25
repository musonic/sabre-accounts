<?php
namespace SabreAccounts\DAV\Accounts;
use Sabre\DAV\Exception;
use Sabre\DAVACL\IACL;
use Sabre\DAVACL\PrincipalBackend\BackendInterface;
use SabreAccounts\DAV\Accounts\Backend\PDO;
use Sabre\DAV\URLUtil;

/**
 * The users class represents a node on which to make requests to add new users.
 *
 *
 * @copyright Copyright (C) 2013 Nic Le Breuilly. All rights reserved.
 * @author Nic Le Breuilly
 * @license https://github.com/musonic/SabreAccounts/blob/master/src/SabreAccounts/LICENSE Modified BSD License
 */
class Users implements IACL {
    
    /**
     * Principal backend
     *
     * @var Sabre\DAVACL\PrincipalBackend\BackendInterface
     */
    protected $principalBackend;

    /**
     * Accounts backend
     *
     * @var SabreAccounts\DAV\Accounts\Backend\PDO
     */
    protected $accountsBackend;

    /**
     * Principal information
     *
     * @var array
     */
    protected $principalInfo;

    /**
     * Constructor
     *
     * @param Sabre\DAVACL\PrincipalBackend\BackendInterface $principalBackend
     * @param SabreAccounts\DAV\Accounts\Backend\PDO $accountsBackend
     * @param mixed $userUri
     */
    public function __construct(BackendInterface $principalBackend, PDO $accountsBackend, $userUri) {

        $this->principalBackend = $principalBackend;
        $this->accountsBackend = $accountsBackend;
        $this->principalInfo = $principalBackend->getPrincipalByPath($userUri);

    }
    
    /**
     * Returns the name of this object
     *
     * @return string
     */
    public function getName() {

        list(,$name) = URLUtil::splitPath($this->principalInfo['uri']);
        return $name;

    }

    /**
     * Updates the name of this object
     *
     * @param string $name
     * @return void
     */
    public function setName($name) {

        throw new Exception\Forbidden();

    }

    /**
     * Deletes this object
     *
     * @return void
     */
    public function delete() {

        throw new Exception\Forbidden();

    }

    /**
     * Returns the last modification date
     *
     * @return int
     */
    public function getLastModified() {

        return null;

    }
   
    /**
     * Returns the owner principal
     *
     * This must be a url to a principal, or null if there's no owner
     *
     * @return string|null
     */
    function getOwner() {
        
        return $this->principalInfo['uri'];
        
    }

    /**
     * Returns a group principal
     *
     * This must be a url to a principal, or null if there's no owner
     *
     * @return string|null
     */
    function getGroup() {
        
        return null;
        
    }

    /**
     * Returns a list of ACE's for this node.
     *
     * Each ACE has the following properties:
     *   * 'privilege', a string such as {DAV:}read or {DAV:}write. These are
     *     currently the only supported privileges
     *   * 'principal', a url to the principal who owns the node
     *   * 'protected' (optional), indicating that this ACE is not allowed to
     *      be updated.
     *
     * @return array
     */
    public function getACL() {

        return array(
            array(
                'privilege' => '{DAV:}read',
                'principal' => $this->principalInfo['uri'],
                'protected' => true,
            ),
            array(
                'privilege' => '{DAV:}write',
                'principal' => $this->principalInfo['uri'],
                'protected' => true,
            )
        );

    }

    /**
     * Updates the ACL
     *
     * This method will receive a list of new ACE's as an array argument.
     *
     * @param array $acl
     * @return void
     */
    public function setACL(array $acl) {

        throw new Exception\MethodNotAllowed('Changing ACL is not yet supported');

    }

    /**
     * Returns the list of supported privileges for this node.
     *
     * The returned data structure is a list of nested privileges.
     * See Sabre_DAVACL_Plugin::getDefaultSupportedPrivilegeSet for a simple
     * standard structure.
     *
     * If null is returned from this method, the default privilege set is used,
     * which is fine for most common usecases.
     *
     * @return array|null
     */
    public function getSupportedPrivilegeSet() {

        return null;

    }
}