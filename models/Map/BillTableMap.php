<?php

namespace Map;

use \Bill;
use \BillQuery;
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
 * This class defines the structure of the 'bill' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BillTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.BillTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'bill';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Bill';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Bill';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'bill.ID';

    /**
     * the column name for the patient_id field
     */
    const COL_PATIENT_ID = 'bill.patient_id';

    /**
     * the column name for the employee_id field
     */
    const COL_EMPLOYEE_ID = 'bill.employee_id';

    /**
     * the column name for the due_date field
     */
    const COL_DUE_DATE = 'bill.due_date';

    /**
     * the column name for the transaction_id field
     */
    const COL_TRANSACTION_ID = 'bill.transaction_id';

    /**
     * the column name for the cost field
     */
    const COL_COST = 'bill.cost';

    /**
     * the column name for the bill_payed field
     */
    const COL_BILL_PAYED = 'bill.bill_payed';

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
        self::TYPE_PHPNAME       => array('Id', 'PatientId', 'EmployeeId', 'DueDate', 'TransactionId', 'Cost', 'BillPayed', ),
        self::TYPE_CAMELNAME     => array('id', 'patientId', 'employeeId', 'dueDate', 'transactionId', 'cost', 'billPayed', ),
        self::TYPE_COLNAME       => array(BillTableMap::COL_ID, BillTableMap::COL_PATIENT_ID, BillTableMap::COL_EMPLOYEE_ID, BillTableMap::COL_DUE_DATE, BillTableMap::COL_TRANSACTION_ID, BillTableMap::COL_COST, BillTableMap::COL_BILL_PAYED, ),
        self::TYPE_FIELDNAME     => array('ID', 'patient_id', 'employee_id', 'due_date', 'transaction_id', 'cost', 'bill_payed', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PatientId' => 1, 'EmployeeId' => 2, 'DueDate' => 3, 'TransactionId' => 4, 'Cost' => 5, 'BillPayed' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'patientId' => 1, 'employeeId' => 2, 'dueDate' => 3, 'transactionId' => 4, 'cost' => 5, 'billPayed' => 6, ),
        self::TYPE_COLNAME       => array(BillTableMap::COL_ID => 0, BillTableMap::COL_PATIENT_ID => 1, BillTableMap::COL_EMPLOYEE_ID => 2, BillTableMap::COL_DUE_DATE => 3, BillTableMap::COL_TRANSACTION_ID => 4, BillTableMap::COL_COST => 5, BillTableMap::COL_BILL_PAYED => 6, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'patient_id' => 1, 'employee_id' => 2, 'due_date' => 3, 'transaction_id' => 4, 'cost' => 5, 'bill_payed' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('bill');
        $this->setPhpName('Bill');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Bill');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('patient_id', 'PatientId', 'INTEGER', 'patient', 'ID', true, null, null);
        $this->addForeignKey('employee_id', 'EmployeeId', 'INTEGER', 'employee', 'ID', true, null, null);
        $this->addColumn('due_date', 'DueDate', 'VARCHAR', true, 255, null);
        $this->addColumn('transaction_id', 'TransactionId', 'INTEGER', true, null, null);
        $this->addColumn('cost', 'Cost', 'INTEGER', true, null, null);
        $this->addColumn('bill_payed', 'BillPayed', 'VARCHAR', true, 1, null);
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
        $this->addRelation('Payment', '\\Payment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':bill_id',
    1 => ':ID',
  ),
), null, null, 'Payments', false);
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
        return $withPrefix ? BillTableMap::CLASS_DEFAULT : BillTableMap::OM_CLASS;
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
     * @return array           (Bill object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BillTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BillTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BillTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BillTableMap::OM_CLASS;
            /** @var Bill $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BillTableMap::addInstanceToPool($obj, $key);
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
            $key = BillTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BillTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Bill $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BillTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BillTableMap::COL_ID);
            $criteria->addSelectColumn(BillTableMap::COL_PATIENT_ID);
            $criteria->addSelectColumn(BillTableMap::COL_EMPLOYEE_ID);
            $criteria->addSelectColumn(BillTableMap::COL_DUE_DATE);
            $criteria->addSelectColumn(BillTableMap::COL_TRANSACTION_ID);
            $criteria->addSelectColumn(BillTableMap::COL_COST);
            $criteria->addSelectColumn(BillTableMap::COL_BILL_PAYED);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.patient_id');
            $criteria->addSelectColumn($alias . '.employee_id');
            $criteria->addSelectColumn($alias . '.due_date');
            $criteria->addSelectColumn($alias . '.transaction_id');
            $criteria->addSelectColumn($alias . '.cost');
            $criteria->addSelectColumn($alias . '.bill_payed');
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
        return Propel::getServiceContainer()->getDatabaseMap(BillTableMap::DATABASE_NAME)->getTable(BillTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BillTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BillTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BillTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Bill or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Bill object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BillTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Bill) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BillTableMap::DATABASE_NAME);
            $criteria->add(BillTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BillQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BillTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BillTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the bill table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BillQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Bill or Criteria object.
     *
     * @param mixed               $criteria Criteria or Bill object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BillTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Bill object
        }

        if ($criteria->containsKey(BillTableMap::COL_ID) && $criteria->keyContainsValue(BillTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BillTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BillQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BillTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BillTableMap::buildTableMap();
