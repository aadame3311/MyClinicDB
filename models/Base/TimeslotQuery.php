<?php

namespace Base;

use \Timeslot as ChildTimeslot;
use \TimeslotQuery as ChildTimeslotQuery;
use \Exception;
use \PDO;
use Map\TimeslotTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'timeslot' table.
 *
 *
 *
 * @method     ChildTimeslotQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildTimeslotQuery orderByStartTime($order = Criteria::ASC) Order by the start_time column
 * @method     ChildTimeslotQuery orderByEndTime($order = Criteria::ASC) Order by the end_time column
 * @method     ChildTimeslotQuery orderByEmployeeId($order = Criteria::ASC) Order by the employee_id column
 * @method     ChildTimeslotQuery orderByAvailability($order = Criteria::ASC) Order by the availability column
 *
 * @method     ChildTimeslotQuery groupById() Group by the ID column
 * @method     ChildTimeslotQuery groupByStartTime() Group by the start_time column
 * @method     ChildTimeslotQuery groupByEndTime() Group by the end_time column
 * @method     ChildTimeslotQuery groupByEmployeeId() Group by the employee_id column
 * @method     ChildTimeslotQuery groupByAvailability() Group by the availability column
 *
 * @method     ChildTimeslotQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTimeslotQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTimeslotQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTimeslotQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTimeslotQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTimeslotQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTimeslotQuery leftJoinEmployee($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employee relation
 * @method     ChildTimeslotQuery rightJoinEmployee($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employee relation
 * @method     ChildTimeslotQuery innerJoinEmployee($relationAlias = null) Adds a INNER JOIN clause to the query using the Employee relation
 *
 * @method     ChildTimeslotQuery joinWithEmployee($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employee relation
 *
 * @method     ChildTimeslotQuery leftJoinWithEmployee() Adds a LEFT JOIN clause and with to the query using the Employee relation
 * @method     ChildTimeslotQuery rightJoinWithEmployee() Adds a RIGHT JOIN clause and with to the query using the Employee relation
 * @method     ChildTimeslotQuery innerJoinWithEmployee() Adds a INNER JOIN clause and with to the query using the Employee relation
 *
 * @method     ChildTimeslotQuery leftJoinAppointment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appointment relation
 * @method     ChildTimeslotQuery rightJoinAppointment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appointment relation
 * @method     ChildTimeslotQuery innerJoinAppointment($relationAlias = null) Adds a INNER JOIN clause to the query using the Appointment relation
 *
 * @method     ChildTimeslotQuery joinWithAppointment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Appointment relation
 *
 * @method     ChildTimeslotQuery leftJoinWithAppointment() Adds a LEFT JOIN clause and with to the query using the Appointment relation
 * @method     ChildTimeslotQuery rightJoinWithAppointment() Adds a RIGHT JOIN clause and with to the query using the Appointment relation
 * @method     ChildTimeslotQuery innerJoinWithAppointment() Adds a INNER JOIN clause and with to the query using the Appointment relation
 *
 * @method     \EmployeeQuery|\AppointmentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTimeslot findOne(ConnectionInterface $con = null) Return the first ChildTimeslot matching the query
 * @method     ChildTimeslot findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTimeslot matching the query, or a new ChildTimeslot object populated from the query conditions when no match is found
 *
 * @method     ChildTimeslot findOneById(int $ID) Return the first ChildTimeslot filtered by the ID column
 * @method     ChildTimeslot findOneByStartTime(int $start_time) Return the first ChildTimeslot filtered by the start_time column
 * @method     ChildTimeslot findOneByEndTime(int $end_time) Return the first ChildTimeslot filtered by the end_time column
 * @method     ChildTimeslot findOneByEmployeeId(int $employee_id) Return the first ChildTimeslot filtered by the employee_id column
 * @method     ChildTimeslot findOneByAvailability(int $availability) Return the first ChildTimeslot filtered by the availability column *

 * @method     ChildTimeslot requirePk($key, ConnectionInterface $con = null) Return the ChildTimeslot by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeslot requireOne(ConnectionInterface $con = null) Return the first ChildTimeslot matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTimeslot requireOneById(int $ID) Return the first ChildTimeslot filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeslot requireOneByStartTime(int $start_time) Return the first ChildTimeslot filtered by the start_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeslot requireOneByEndTime(int $end_time) Return the first ChildTimeslot filtered by the end_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeslot requireOneByEmployeeId(int $employee_id) Return the first ChildTimeslot filtered by the employee_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeslot requireOneByAvailability(int $availability) Return the first ChildTimeslot filtered by the availability column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTimeslot[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTimeslot objects based on current ModelCriteria
 * @method     ChildTimeslot[]|ObjectCollection findById(int $ID) Return ChildTimeslot objects filtered by the ID column
 * @method     ChildTimeslot[]|ObjectCollection findByStartTime(int $start_time) Return ChildTimeslot objects filtered by the start_time column
 * @method     ChildTimeslot[]|ObjectCollection findByEndTime(int $end_time) Return ChildTimeslot objects filtered by the end_time column
 * @method     ChildTimeslot[]|ObjectCollection findByEmployeeId(int $employee_id) Return ChildTimeslot objects filtered by the employee_id column
 * @method     ChildTimeslot[]|ObjectCollection findByAvailability(int $availability) Return ChildTimeslot objects filtered by the availability column
 * @method     ChildTimeslot[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TimeslotQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TimeslotQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Timeslot', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTimeslotQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTimeslotQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTimeslotQuery) {
            return $criteria;
        }
        $query = new ChildTimeslotQuery();
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
     * @return ChildTimeslot|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TimeslotTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TimeslotTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTimeslot A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, start_time, end_time, employee_id, availability FROM timeslot WHERE ID = :p0';
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
            /** @var ChildTimeslot $obj */
            $obj = new ChildTimeslot();
            $obj->hydrate($row);
            TimeslotTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTimeslot|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TimeslotTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TimeslotTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE ID = 1234
     * $query->filterById(array(12, 34)); // WHERE ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE ID > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeslotTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the start_time column
     *
     * Example usage:
     * <code>
     * $query->filterByStartTime(1234); // WHERE start_time = 1234
     * $query->filterByStartTime(array(12, 34)); // WHERE start_time IN (12, 34)
     * $query->filterByStartTime(array('min' => 12)); // WHERE start_time > 12
     * </code>
     *
     * @param     mixed $startTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByStartTime($startTime = null, $comparison = null)
    {
        if (is_array($startTime)) {
            $useMinMax = false;
            if (isset($startTime['min'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_START_TIME, $startTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startTime['max'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_START_TIME, $startTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeslotTableMap::COL_START_TIME, $startTime, $comparison);
    }

    /**
     * Filter the query on the end_time column
     *
     * Example usage:
     * <code>
     * $query->filterByEndTime(1234); // WHERE end_time = 1234
     * $query->filterByEndTime(array(12, 34)); // WHERE end_time IN (12, 34)
     * $query->filterByEndTime(array('min' => 12)); // WHERE end_time > 12
     * </code>
     *
     * @param     mixed $endTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByEndTime($endTime = null, $comparison = null)
    {
        if (is_array($endTime)) {
            $useMinMax = false;
            if (isset($endTime['min'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_END_TIME, $endTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endTime['max'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_END_TIME, $endTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeslotTableMap::COL_END_TIME, $endTime, $comparison);
    }

    /**
     * Filter the query on the employee_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEmployeeId(1234); // WHERE employee_id = 1234
     * $query->filterByEmployeeId(array(12, 34)); // WHERE employee_id IN (12, 34)
     * $query->filterByEmployeeId(array('min' => 12)); // WHERE employee_id > 12
     * </code>
     *
     * @see       filterByEmployee()
     *
     * @param     mixed $employeeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByEmployeeId($employeeId = null, $comparison = null)
    {
        if (is_array($employeeId)) {
            $useMinMax = false;
            if (isset($employeeId['min'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_EMPLOYEE_ID, $employeeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeeId['max'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_EMPLOYEE_ID, $employeeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeslotTableMap::COL_EMPLOYEE_ID, $employeeId, $comparison);
    }

    /**
     * Filter the query on the availability column
     *
     * Example usage:
     * <code>
     * $query->filterByAvailability(1234); // WHERE availability = 1234
     * $query->filterByAvailability(array(12, 34)); // WHERE availability IN (12, 34)
     * $query->filterByAvailability(array('min' => 12)); // WHERE availability > 12
     * </code>
     *
     * @param     mixed $availability The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByAvailability($availability = null, $comparison = null)
    {
        if (is_array($availability)) {
            $useMinMax = false;
            if (isset($availability['min'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_AVAILABILITY, $availability['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($availability['max'])) {
                $this->addUsingAlias(TimeslotTableMap::COL_AVAILABILITY, $availability['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeslotTableMap::COL_AVAILABILITY, $availability, $comparison);
    }

    /**
     * Filter the query by a related \Employee object
     *
     * @param \Employee|ObjectCollection $employee The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByEmployee($employee, $comparison = null)
    {
        if ($employee instanceof \Employee) {
            return $this
                ->addUsingAlias(TimeslotTableMap::COL_EMPLOYEE_ID, $employee->getId(), $comparison);
        } elseif ($employee instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TimeslotTableMap::COL_EMPLOYEE_ID, $employee->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEmployee() only accepts arguments of type \Employee or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Employee relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function joinEmployee($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Employee');

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
            $this->addJoinObject($join, 'Employee');
        }

        return $this;
    }

    /**
     * Use the Employee relation Employee object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EmployeeQuery A secondary query class using the current class as primary query
     */
    public function useEmployeeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEmployee($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Employee', '\EmployeeQuery');
    }

    /**
     * Filter the query by a related \Appointment object
     *
     * @param \Appointment|ObjectCollection $appointment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTimeslotQuery The current query, for fluid interface
     */
    public function filterByAppointment($appointment, $comparison = null)
    {
        if ($appointment instanceof \Appointment) {
            return $this
                ->addUsingAlias(TimeslotTableMap::COL_ID, $appointment->getTimeslotId(), $comparison);
        } elseif ($appointment instanceof ObjectCollection) {
            return $this
                ->useAppointmentQuery()
                ->filterByPrimaryKeys($appointment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAppointment() only accepts arguments of type \Appointment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Appointment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function joinAppointment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Appointment');

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
            $this->addJoinObject($join, 'Appointment');
        }

        return $this;
    }

    /**
     * Use the Appointment relation Appointment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppointmentQuery A secondary query class using the current class as primary query
     */
    public function useAppointmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAppointment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Appointment', '\AppointmentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTimeslot $timeslot Object to remove from the list of results
     *
     * @return $this|ChildTimeslotQuery The current query, for fluid interface
     */
    public function prune($timeslot = null)
    {
        if ($timeslot) {
            $this->addUsingAlias(TimeslotTableMap::COL_ID, $timeslot->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the timeslot table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TimeslotTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TimeslotTableMap::clearInstancePool();
            TimeslotTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TimeslotTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TimeslotTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TimeslotTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TimeslotTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TimeslotQuery
