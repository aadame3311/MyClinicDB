<?php

namespace Map;

use \Patient;
use \PatientQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'patient' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PatientTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PatientTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'patient';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Patient';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Patient';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'patient.ID';

    /**
     * the column name for the first_name field
     */
    const COL_FIRST_NAME = 'patient.first_name';

    /**
     * the column name for the last_name field
     */
    const COL_LAST_NAME = 'patient.last_name';

    /**
     * the column name for the address field
     */
    const COL_ADDRESS = 'patient.address';

    /**
     * the column name for the date_of_birth field
     */
    const COL_DATE_OF_BIRTH = 'patient.date_of_birth';

    /**
     * the column name for the insurance field
     */
    const COL_INSURANCE = 'patient.insurance';

    /**
     * the column name for the username field
     */
    const COL_USERNAME = 'patient.username';

    /**
     * the column name for the password_hash field
     */
    const COL_PASSWORD_HASH = 'patient.password_hash';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'patient.email';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'FirstName', 'LastName', 'Address', 'DateOfBirth', 'Insurance', 'Username', 'PasswordHash', 'Email', ),
        self::TYPE_CAMELNAME     => array('id', 'firstName', 'lastName', 'address', 'dateOfBirth', 'insurance', 'username', 'passwordHash', 'email', ),
        self::TYPE_COLNAME       => array(PatientTableMap::COL_ID, PatientTableMap::COL_FIRST_NAME, PatientTableMap::COL_LAST_NAME, PatientTableMap::COL_ADDRESS, PatientTableMap::COL_DATE_OF_BIRTH, PatientTableMap::COL_INSURANCE, PatientTableMap::COL_USERNAME, PatientTableMap::COL_PASSWORD_HASH, PatientTableMap::COL_EMAIL, ),
        self::TYPE_FIELDNAME     => array('ID', 'first_name', 'last_name', 'address', 'date_of_birth', 'insurance', 'username', 'password_hash', 'email', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FirstName' => 1, 'LastName' => 2, 'Address' => 3, 'DateOfBirth' => 4, 'Insurance' => 5, 'Username' => 6, 'PasswordHash' => 7, 'Email' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'firstName' => 1, 'lastName' => 2, 'address' => 3, 'dateOfBirth' => 4, 'insurance' => 5, 'username' => 6, 'passwordHash' => 7, 'email' => 8, ),
        self::TYPE_COLNAME       => array(PatientTableMap::COL_ID => 0, PatientTableMap::COL_FIRST_NAME => 1, PatientTableMap::COL_LAST_NAME => 2, PatientTableMap::COL_ADDRESS => 3, PatientTableMap::COL_DATE_OF_BIRTH => 4, PatientTableMap::COL_INSURANCE => 5, PatientTableMap::COL_USERNAME => 6, PatientTableMap::COL_PASSWORD_HASH => 7, PatientTableMap::COL_EMAIL => 8, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'first_name' => 1, 'last_name' => 2, 'address' => 3, 'date_of_birth' => 4, 'insurance' => 5, 'username' => 6, 'password_hash' => 7, 'email' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('patient');
        $this->setPhpName('Patient');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Patient');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', true, 255, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', true, 255, null);
        $this->addColumn('address', 'Address', 'VARCHAR', true, 255, null);
        $this->addColumn('date_of_birth', 'DateOfBirth', 'VARCHAR', true, 255, null);
        $this->addColumn('insurance', 'Insurance', 'VARCHAR', false, 255, null);
        $this->addColumn('username', 'Username', 'VARCHAR', false, 255, null);
        $this->addColumn('password_hash', 'PasswordHash', 'VARCHAR', false, 255, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Appointment', '\\Appointment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':patient_id',
    1 => ':ID',
  ),
), null, null, 'Appointments', false);
        $this->addRelation('Bill', '\\Bill', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':patient_id',
    1 => ':ID',
  ),
), null, null, 'Bills', false);
        $this->addRelation('Healthhistory', '\\Healthhistory', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':patient_id',
    1 => ':ID',
  ),
), null, null, 'Healthhistories', false);
        $this->addRelation('Patientphone', '\\Patientphone', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':patient_id',
    1 => ':ID',
  ),
), null, null, 'Patientphones', false);
        $this->addRelation('Prescription', '\\Prescription', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':patient_id',
    1 => ':ID',
  ),
), null, null, 'Prescriptions', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PatientTableMap::CLASS_DEFAULT : PatientTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Patient object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PatientTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PatientTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PatientTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PatientTableMap::OM_CLASS;
            /** @var Patient $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PatientTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PatientTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PatientTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Patient $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PatientTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PatientTableMap::COL_ID);
            $criteria->addSelectColumn(PatientTableMap::COL_FIRST_NAME);
            $criteria->addSelectColumn(PatientTableMap::COL_LAST_NAME);
            $criteria->addSelectColumn(PatientTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(PatientTableMap::COL_DATE_OF_BIRTH);
            $criteria->addSelectColumn(PatientTableMap::COL_INSURANCE);
            $criteria->addSelectColumn(PatientTableMap::COL_USERNAME);
            $criteria->addSelectColumn(PatientTableMap::COL_PASSWORD_HASH);
            $criteria->addSelectColumn(PatientTableMap::COL_EMAIL);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.date_of_birth');
            $criteria->addSelectColumn($alias . '.insurance');
            $criteria->addSelectColumn($alias . '.username');
            $criteria->addSelectColumn($alias . '.password_hash');
            $criteria->addSelectColumn($alias . '.email');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PatientTableMap::DATABASE_NAME)->getTable(PatientTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PatientTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PatientTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PatientTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Patient or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Patient object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Patient) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PatientTableMap::DATABASE_NAME);
            $criteria->add(PatientTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PatientQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PatientTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PatientTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the patient table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PatientQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Patient or Criteria object.
     *
     * @param mixed               $criteria Criteria or Patient object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Patient object
        }

        if ($criteria->containsKey(PatientTableMap::COL_ID) && $criteria->keyContainsValue(PatientTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PatientTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PatientQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PatientTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PatientTableMap::buildTableMap();
