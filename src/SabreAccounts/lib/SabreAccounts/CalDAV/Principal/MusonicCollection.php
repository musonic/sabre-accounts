<?php
namespace SabreAccounts\CalDAV\Principal;

use Sabre\CalDAV\Principal\Collection;
use Sabre\DAV\IExtendedCollection;

/**
 * @copyright Copyright (C) 2013 Nic Le Breuilly. All rights reserved.
 * @author Nic Le Breuilly
 * @license https://github.com/musonic/SabreAccounts/blob/master/src/SabreAccounts/LICENSE Modified BSD License
 */
class MusonicCollection extends Collection implements IExtendedCollection {

    /**
     * Creates a new collection
     *
     * @param string $name
     * @param array $resourceType
     * @param array $properties
     * @return void
     */
    public function createExtendedCollection($name, array $resourceType, array $properties) {
        
        if (count($resourceType)!==2) {
            throw new Sabre_DAV_Exception_InvalidResourceType('Unknown resourceType for this collection');
        }
        $this->principalBackend->createPrincipal($this->principalPrefix, $name, $properties);
    }

}