<?php

namespace Base;

use \Patientphone as ChildPatientphone;
use \PatientphoneQuery as ChildPatientphoneQuery;
use \Exception;
use \PDO;
use Map\PatientphoneTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'patientphone' table.
 *
 *
 *
 * @method     ChildPatientphoneQuery orderByPhoneNumber($order = Criteria::ASC) Order by the phone_number column
 * @method     ChildPatientphoneQuery orderByPatientId($order = Criteria::ASC) Order by the patient_id column
 *
 * @method     ChildPatientphoneQuery groupByPhoneNumber() Group by the phone_number column
 * @method     ChildPatientphoneQuery groupByPatientId() Group by the patient_id column
 *
 * @method     ChildPatientphoneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPatientphoneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPatientphoneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPatientphoneQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPatientphoneQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPatientphoneQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPatientphoneQuery leftJoinPatient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patient relation
 * @method     ChildPatientphoneQuery rightJoinPatient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patient relation
 * @method     ChildPatientphoneQuery innerJoinPatient($relationAlias = null) Adds a INNER JOIN clause to the query using the Patient relation
 *
 * @method     ChildPatientphoneQuery joinWithPatient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patient relation
 *
 * @method     ChildPatientphoneQuery leftJoinWithPatient() Adds a LEFT JOIN clause and with to the query using the Patient relation
 * @method     ChildPatientphoneQuery rightJoinWithPatient() Adds a RIGHT JOIN clause and with to the query using the Patient relation
 * @method     ChildPatientphoneQuery innerJoinWithPatient() Adds a INNER JOIN clause and with to the query using the Patient relation
 *
 * @method     \PatientQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPatientphone findOne(ConnectionInterface $con = null) Return the first ChildPatientphone matching the query
 * @method     ChildPatientphone findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPatientphone matching the query, or a new ChildPatientphone object populated from the query conditions when no match is found
 *
 * @method     ChildPatientphone findOneByPhoneNumber(int $phone_number) Return the first ChildPatientphone filtered by the phone_number column
 * @method     ChildPatientphone findOneByPatientId(int $patient_id) Return the first ChildPatientphone filtered by the patient_id column *

 * @method     ChildPatientphone requirePk($key, ConnectionInterface $con = null) Return the ChildPatientphone by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatientphone requireOne(ConnectionInterface $con = null) Return the first ChildPatientphone matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPatientphone requireOneByPhoneNumber(int $phone_number) Return the first ChildPatientphone filtered by the phone_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatientphone requireOneByPatientId(int $patient_id) Return the first ChildPatientphone filtered by the patient_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPatientphone[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPatientphone objects based on current ModelCriteria
 * @method     ChildPatientphone[]|ObjectCollection findByPhoneNumber(int $phone_number) Return ChildPatientphone objects filtered by the phone_number column
 * @method     ChildPatientphone[]|ObjectCollection findByPatientId(int $patient_id) Return ChildPatientphone objects filtered by the patient_id column
 * @method     ChildPatientphone[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PatientphoneQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PatientphoneQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Patientphone', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPatientphoneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPatientphoneQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPatientphoneQuery) {
            return $criteria;
        }
        $query = new ChildPatientphoneQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPatientphone|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PatientphoneTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PatientphoneTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPatientphone A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT phone_number, patient_id FROM patientphone WHERE phone_number = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPatientphone $obj */
            $obj = new ChildPatientphone();
            $obj->hydrate($row);
            PatientphoneTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPatientphone|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildPatientphoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PatientphoneTableMap::COL_PHONE_NUMBER, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPatientphoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PatientphoneTableMap::COL_PHONE_NUMBER, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the phone_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoneNumber(1234); // WHERE phone_number = 1234
     * $query->filterByPhoneNumber(array(12, 34)); // WHERE phone_number IN (12, 34)
     * $query->filterByPhoneNumber(array('min' => 12)); // WHERE phone_number > 12
     * </code>
     *
     * @param     mixed $phoneNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientphoneQuery The current query, for fluid interface
     */
    public function filterByPhoneNumber($phoneNumber = null, $comparison = null)
    {
        if (is_array($phoneNumber)) {
            $useMinMax = false;
            if (isset($phoneNumber['min'])) {
                $this->addUsingAlias(PatientphoneTableMap::COL_PHONE_NUMBER, $phoneNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($phoneNumber['max'])) {
                $this->addUsingAlias(PatientphoneTableMap::COL_PHONE_NUMBER, $phoneNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientphoneTableMap::COL_PHONE_NUMBER, $phoneNumber, $comparison);
    }

    /**
     * Filter the query on the patient_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPatientId(1234); // WHERE patient_id = 1234
     * $query->filterByPatientId(array(12, 34)); // WHERE patient_id IN (12, 34)
     * $query->filterByPatientId(array('min' => 12)); // WHERE patient_id > 12
     * </code>
     *
     * @see       filterByPatient()
     *
     * @param     mixed $patientId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientphoneQuery The current query, for fluid interface
     */
    public function filterByPatientId($patientId = null, $comparison = null)
    {
        if (is_array($patientId)) {
            $useMinMax = false;
            if (isset($patientId['min'])) {
                $this->addUsingAlias(PatientphoneTableMap::COL_PATIENT_ID, $patientId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($patientId['max'])) {
                $this->addUsingAlias(PatientphoneTableMap::COL_PATIENT_ID, $patientId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientphoneTableMap::COL_PATIENT_ID, $patientId, $comparison);
    }

    /**
     * Filter the query by a related \Patient object
     *
     * @param \Patient|ObjectCollection $patient The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPatientphoneQuery The current query, for fluid interface
     */
    public function filterByPatient($patient, $comparison = null)
    {
        if ($patient instanceof \Patient) {
            return $this
                ->addUsingAlias(PatientphoneTableMap::COL_PATIENT_ID, $patient->getId(), $comparison);
        } elseif ($patient instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PatientphoneTableMap::COL_PATIENT_ID, $patient->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPatient() only accepts arguments of type \Patient or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Patient relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPatientphoneQuery The current query, for fluid interface
     */
    public function joinPatient($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Patient');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Patient');
        }

        return $this;
    }

    /**
     * Use the Patient relation Patient object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PatientQuery A secondary query class using the current class as primary query
     */
    public function usePatientQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPatient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Patient', '\PatientQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPatientphone $patientphone Object to remove from the list of results
     *
     * @return $this|ChildPatientphoneQuery The current query, for fluid interface
     */
    public function prune($patientphone = null)
    {
        if ($patientphone) {
            $this->addUsingAlias(PatientphoneTableMap::COL_PHONE_NUMBER, $patientphone->getPhoneNumber(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the patientphone table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientphoneTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PatientphoneTableMap::clearInstancePool();
            PatientphoneTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientphoneTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PatientphoneTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PatientphoneTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PatientphoneTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PatientphoneQuery
