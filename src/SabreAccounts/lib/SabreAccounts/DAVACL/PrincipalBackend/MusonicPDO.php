<?php
namespace SabreAccounts\DAVACL\PrincipalBackend;
use Sabre\DAVACL\PrincipalBackend\PDO;
use Sabre\DAV\Exception;

class MusonicPDO extends PDO
{
	/**
	 * Get the principal table name.
	 * @return string
	 */
	public function getPrincipalTableName() {
		return $this->tableName;
	}
	
    /**
     * Creates a new  principal.
     *
     * If the creation was a success, an id must be returned
     *
     * @param string $principalUri
     * @param string $name
     * @param array $properties
     * @return string
     */
    public function createPrincipal($principalUri, $name, array $properties) {

        $fieldNames = array(
            'uri'
        );
        $values = array(
            ':principaluri' => $principalUri.'/'.$name
        );

        foreach($this->fieldMap as $xmlName=>$dbName) { 
            if (isset($properties[$xmlName])) {

                $values[':' . $dbName['dbField']] = $properties[$xmlName];
                $fieldNames[] = $dbName['dbField'];
            }
        }

        $stmt = $this->pdo->prepare("INSERT INTO ".$this->tableName." (".implode(', ', $fieldNames).") VALUES (".implode(', ',array_keys($values)).")");
        $stmt->execute($values);

        return $this->pdo->lastInsertId();

    }
	
 }

