<?php

namespace Map;

use \Appointment;
use \AppointmentQuery;
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
 * This class defines the structure of the 'appointment' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AppointmentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AppointmentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'appointment';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Appointment';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Appointment';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'appointment.ID';

    /**
     * the column name for the patient_id field
     */
    const COL_PATIENT_ID = 'appointment.patient_id';

    /**
     * the column name for the timeslot_id field
     */
    const COL_TIMESLOT_ID = 'appointment.timeslot_id';

    /**
     * the column name for the employee_id field
     */
    const COL_EMPLOYEE_ID = 'appointment.employee_id';

    /**
     * the column name for the room field
     */
    const COL_ROOM = 'appointment.room';

    /**
     * the column name for the cost field
     */
    const COL_COST = 'appointment.cost';

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
        self::TYPE_PHPNAME       => array('Id', 'PatientId', 'TimeslotId', 'EmployeeId', 'Room', 'Cost', ),
        self::TYPE_CAMELNAME     => array('id', 'patientId', 'timeslotId', 'employeeId', 'room', 'cost', ),
        self::TYPE_COLNAME       => array(AppointmentTableMap::COL_ID, AppointmentTableMap::COL_PATIENT_ID, AppointmentTableMap::COL_TIMESLOT_ID, AppointmentTableMap::COL_EMPLOYEE_ID, AppointmentTableMap::COL_ROOM, AppointmentTableMap::COL_COST, ),
        self::TYPE_FIELDNAME     => array('ID', 'patient_id', 'timeslot_id', 'employee_id', 'room', 'cost', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PatientId' => 1, 'TimeslotId' => 2, 'EmployeeId' => 3, 'Room' => 4, 'Cost' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'patientId' => 1, 'timeslotId' => 2, 'employeeId' => 3, 'room' => 4, 'cost' => 5, ),
        self::TYPE_COLNAME       => array(AppointmentTableMap::COL_ID => 0, AppointmentTableMap::COL_PATIENT_ID => 1, AppointmentTableMap::COL_TIMESLOT_ID => 2, AppointmentTableMap::COL_EMPLOYEE_ID => 3, AppointmentTableMap::COL_ROOM => 4, AppointmentTableMap::COL_COST => 5, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'patient_id' => 1, 'timeslot_id' => 2, 'employee_id' => 3, 'room' => 4, 'cost' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('appointment');
        $this->setPhpName('Appointment');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Appointment');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('patient_id', 'PatientId', 'INTEGER', 'patient', 'ID', true, null, null);
        $this->addForeignKey('timeslot_id', 'TimeslotId', 'INTEGER', 'timeslot', 'ID', true, null, null);
        $this->addForeignKey('employee_id', 'EmployeeId', 'INTEGER', 'employee', 'ID', true, null, null);
        $this->addColumn('room', 'Room', 'INTEGER', true, null, null);
        $this->addColumn('cost', 'Cost', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Patient', '\\Patient', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':patient_id',
    1 => ':ID',
  ),
), null, null, null, false);
        $this->addRelation('Employee', '\\Employee', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':employee_id',
    1 => ':ID',
  ),
), null, null, null, false);
        $this->addRelation('Timeslot', '\\Timeslot', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':timeslot_id',
    1 => ':ID',
  ),
), null, null, null, false);
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
        return $withPrefix ? AppointmentTableMap::CLASS_DEFAULT : AppointmentTableMap::OM_CLASS;
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
     * @return array           (Appointment object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AppointmentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AppointmentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AppointmentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AppointmentTableMap::OM_CLASS;
            /** @var Appointment $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AppointmentTableMap::addInstanceToPool($obj, $key);
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
            $key = AppointmentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AppointmentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Appointment $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AppointmentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AppointmentTableMap::COL_ID);
            $criteria->addSelectColumn(AppointmentTableMap::COL_PATIENT_ID);
            $criteria->addSelectColumn(AppointmentTableMap::COL_TIMESLOT_ID);
            $criteria->addSelectColumn(AppointmentTableMap::COL_EMPLOYEE_ID);
            $criteria->addSelectColumn(AppointmentTableMap::COL_ROOM);
            $criteria->addSelectColumn(AppointmentTableMap::COL_COST);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.patient_id');
            $criteria->addSelectColumn($alias . '.timeslot_id');
            $criteria->addSelectColumn($alias . '.employee_id');
            $criteria->addSelectColumn($alias . '.room');
            $criteria->addSelectColumn($alias . '.cost');
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
        return Propel::getServiceContainer()->getDatabaseMap(AppointmentTableMap::DATABASE_NAME)->getTable(AppointmentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AppointmentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AppointmentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AppointmentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Appointment or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Appointment object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AppointmentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Appointment) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AppointmentTableMap::DATABASE_NAME);
            $criteria->add(AppointmentTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AppointmentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AppointmentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AppointmentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the appointment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AppointmentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Appointment or Criteria object.
     *
     * @param mixed               $criteria Criteria or Appointment object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AppointmentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Appointment object
        }

        if ($criteria->containsKey(AppointmentTableMap::COL_ID) && $criteria->keyContainsValue(AppointmentTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AppointmentTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AppointmentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AppointmentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AppointmentTableMap::buildTableMap();
