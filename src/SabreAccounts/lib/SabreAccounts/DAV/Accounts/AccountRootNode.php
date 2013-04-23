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
     * This constructor needs both an authentication and a caldav backend.
     *
     * By default this class will show a list of calendar collections for
     * principals in the 'principals' collection. If your main principals are
     * actually located in a different path, use the $principalPrefix argument
     * to override this.
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

    // /**
     // * Returns the nodename
     // *
     // * We're overriding this, because the default will be the 'principalPrefix',
     // * and we want it to be Sabre_CalDAV_Plugin::CALENDAR_ROOT
     // *
     // * @return string
     // */
    // public function getName() {
// 
        // return Sabre_CalDAV_Plugin::CALENDAR_ROOT;
// 
    // }

    /**
     * This method returns a node for a principal.
     *
     * The passed array contains principal information, and is guaranteed to
     * at least contain a uri item. Other properties may or may not be
     * supplied by the authentication backend.
     *
     * @param array $principal
     * @return Sabre_DAV_INode
     */
    public function getChildForPrincipal(array $principal) {

        return new Users($this->principalBackend, $this->accountsBackend, $principal['uri']);

    }

}
