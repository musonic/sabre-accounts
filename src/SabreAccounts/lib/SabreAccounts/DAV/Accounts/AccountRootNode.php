<?php
namespace SabreAccounts\DAV\Accounts;
use Sabre\DAVACL\AbstractPrincipalCollection;
use Sabre\DAVACL\PrincipalBackend\BackendInterface;
use SabreAccounts\DAV\Accounts\Backend\PDO;

/**
 * @copyright Copyright (C) 2013 Nic Le Breuilly. All rights reserved.
 * @author Nic Le Breuilly
 * @license https://github.com/musonic/SabreAccounts/blob/master/src/SabreAccounts/LICENSE Modified BSD License
 */
class AccountRootNode extends AbstractPrincipalCollection {

    /**
     * Accounts backend
     *
     * @var SabreAccounts\DAV\Accounts\Backend\BackendInterface
     */
    protected $accountsBackend;

    /**
     * Constructor
     *
     * This constructor needs both a principal and an accounts backend.
     *
     *
     * @param Sabre\DAVACL\PrincipalBackend\BackendInterface $principalBackend
     * @param SabreAccounts\DAV\Accounts\Backend\BackendInterface $accountsBackend
     * @param string $principalPrefix
     */
    public function __construct(BackendInterface $principalBackend, PDO $accountsBackend, $principalPrefix = 'accounts') {

        parent::__construct($principalBackend, $principalPrefix);
        $this->accountsBackend = $accountsBackend;

    }

    /**
     * This method returns a node for a user.
     *
     *
     * @param array $principal
     * @return Sabre_DAV_INode
     */
    public function getChildForPrincipal(array $principal) {

        return new Users($this->principalBackend, $this->accountsBackend, $principal['uri']);

    }

}
