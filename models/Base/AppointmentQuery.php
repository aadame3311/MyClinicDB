<?php

namespace Base;

use \Appointment as ChildAppointment;
use \AppointmentQuery as ChildAppointmentQuery;
use \Exception;
use \PDO;
use Map\AppointmentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'appointment' table.
 *
 *
 *
 * @method     ChildAppointmentQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildAppointmentQuery orderByPatientId($order = Criteria::ASC) Order by the patient_id column
 * @method     ChildAppointmentQuery orderByTimeslotId($order = Criteria::ASC) Order by the timeslot_id column
 * @method     ChildAppointmentQuery orderByEmployeeId($order = Criteria::ASC) Order by the employee_id column
 * @method     ChildAppointmentQuery orderByRoom($order = Criteria::ASC) Order by the room column
 * @method     ChildAppointmentQuery orderByCost($order = Criteria::ASC) Order by the cost column
 *
 * @method     ChildAppointmentQuery groupById() Group by the ID column
 * @method     ChildAppointmentQuery groupByPatientId() Group by the patient_id column
 * @method     ChildAppointmentQuery groupByTimeslotId() Group by the timeslot_id column
 * @method     ChildAppointmentQuery groupByEmployeeId() Group by the employee_id column
 * @method     ChildAppointmentQuery groupByRoom() Group by the room column
 * @method     ChildAppointmentQuery groupByCost() Group by the cost column
 *
 * @method     ChildAppointmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAppointmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAppointmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAppointmentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAppointmentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAppointmentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAppointmentQuery leftJoinPatient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patient relation
 * @method     ChildAppointmentQuery rightJoinPatient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patient relation
 * @method     ChildAppointmentQuery innerJoinPatient($relationAlias = null) Adds a INNER JOIN clause to the query using the Patient relation
 *
 * @method     ChildAppointmentQuery joinWithPatient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patient relation
 *
 * @method     ChildAppointmentQuery leftJoinWithPatient() Adds a LEFT JOIN clause and with to the query using the Patient relation
 * @method     ChildAppointmentQuery rightJoinWithPatient() Adds a RIGHT JOIN clause and with to the query using the Patient relation
 * @method     ChildAppointmentQuery innerJoinWithPatient() Adds a INNER JOIN clause and with to the query using the Patient relation
 *
 * @method     ChildAppointmentQuery leftJoinEmployee($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employee relation
 * @method     ChildAppointmentQuery rightJoinEmployee($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employee relation
 * @method     ChildAppointmentQuery innerJoinEmployee($relationAlias = null) Adds a INNER JOIN clause to the query using the Employee relation
 *
 * @method     ChildAppointmentQuery joinWithEmployee($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employee relation
 *
 * @method     ChildAppointmentQuery leftJoinWithEmployee() Adds a LEFT JOIN clause and with to the query using the Employee relation
 * @method     ChildAppointmentQuery rightJoinWithEmployee() Adds a RIGHT JOIN clause and with to the query using the Employee relation
 * @method     ChildAppointmentQuery innerJoinWithEmployee() Adds a INNER JOIN clause and with to the query using the Employee relation
 *
 * @method     ChildAppointmentQuery leftJoinTimeslot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Timeslot relation
 * @method     ChildAppointmentQuery rightJoinTimeslot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Timeslot relation
 * @method     ChildAppointmentQuery innerJoinTimeslot($relationAlias = null) Adds a INNER JOIN clause to the query using the Timeslot relation
 *
 * @method     ChildAppointmentQuery joinWithTimeslot($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Timeslot relation
 *
 * @method     ChildAppointmentQuery leftJoinWithTimeslot() Adds a LEFT JOIN clause and with to the query using the Timeslot relation
 * @method     ChildAppointmentQuery rightJoinWithTimeslot() Adds a RIGHT JOIN clause and with to the query using the Timeslot relation
 * @method     ChildAppointmentQuery innerJoinWithTimeslot() Adds a INNER JOIN clause and with to the query using the Timeslot relation
 *
 * @method     \PatientQuery|\EmployeeQuery|\TimeslotQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAppointment findOne(ConnectionInterface $con = null) Return the first ChildAppointment matching the query
 * @method     ChildAppointment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAppointment matching the query, or a new ChildAppointment object populated from the query conditions when no match is found
 *
 * @method     ChildAppointment findOneById(int $ID) Return the first ChildAppointment filtered by the ID column
 * @method     ChildAppointment findOneByPatientId(int $patient_id) Return the first ChildAppointment filtered by the patient_id column
 * @method     ChildAppointment findOneByTimeslotId(int $timeslot_id) Return the first ChildAppointment filtered by the timeslot_id column
 * @method     ChildAppointment findOneByEmployeeId(int $employee_id) Return the first ChildAppointment filtered by the employee_id column
 * @method     ChildAppointment findOneByRoom(int $room) Return the first ChildAppointment filtered by the room column
 * @method     ChildAppointment findOneByCost(int $cost) Return the first ChildAppointment filtered by the cost column *

 * @method     ChildAppointment requirePk($key, ConnectionInterface $con = null) Return the ChildAppointment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppointment requireOne(ConnectionInterface $con = null) Return the first ChildAppointment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAppointment requireOneById(int $ID) Return the first ChildAppointment filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppointment requireOneByPatientId(int $patient_id) Return the first ChildAppointment filtered by the patient_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppointment requireOneByTimeslotId(int $timeslot_id) Return the first ChildAppointment filtered by the timeslot_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppointment requireOneByEmployeeId(int $employee_id) Return the first ChildAppointment filtered by the employee_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppointment requireOneByRoom(int $room) Return the first ChildAppointment filtered by the room column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppointment requireOneByCost(int $cost) Return the first ChildAppointment filtered by the cost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAppointment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAppointment objects based on current ModelCriteria
 * @method     ChildAppointment[]|ObjectCollection findById(int $ID) Return ChildAppointment objects filtered by the ID column
 * @method     ChildAppointment[]|ObjectCollection findByPatientId(int $patient_id) Return ChildAppointment objects filtered by the patient_id column
 * @method     ChildAppointment[]|ObjectCollection findByTimeslotId(int $timeslot_id) Return ChildAppointment objects filtered by the timeslot_id column
 * @method     ChildAppointment[]|ObjectCollection findByEmployeeId(int $employee_id) Return ChildAppointment objects filtered by the employee_id column
 * @method     ChildAppointment[]|ObjectCollection findByRoom(int $room) Return ChildAppointment objects filtered by the room column
 * @method     ChildAppointment[]|ObjectCollection findByCost(int $cost) Return ChildAppointment objects filtered by the cost column
 * @method     ChildAppointment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AppointmentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AppointmentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Appointment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAppointmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAppointmentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAppointmentQuery) {
            return $criteria;
        }
        $query = new ChildAppointmentQuery();
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
     * @return ChildAppointment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AppointmentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AppointmentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAppointment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, patient_id, timeslot_id, employee_id, room, cost FROM appointment WHERE ID = :p0';
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
            /** @var ChildAppointment $obj */
            $obj = new ChildAppointment();
            $obj->hydrate($row);
            AppointmentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAppointment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AppointmentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AppointmentTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppointmentTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByPatientId($patientId = null, $comparison = null)
    {
        if (is_array($patientId)) {
            $useMinMax = false;
            if (isset($patientId['min'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_PATIENT_ID, $patientId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($patientId['max'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_PATIENT_ID, $patientId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppointmentTableMap::COL_PATIENT_ID, $patientId, $comparison);
    }

    /**
     * Filter the query on the timeslot_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeslotId(1234); // WHERE timeslot_id = 1234
     * $query->filterByTimeslotId(array(12, 34)); // WHERE timeslot_id IN (12, 34)
     * $query->filterByTimeslotId(array('min' => 12)); // WHERE timeslot_id > 12
     * </code>
     *
     * @see       filterByTimeslot()
     *
     * @param     mixed $timeslotId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByTimeslotId($timeslotId = null, $comparison = null)
    {
        if (is_array($timeslotId)) {
            $useMinMax = false;
            if (isset($timeslotId['min'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_TIMESLOT_ID, $timeslotId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeslotId['max'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_TIMESLOT_ID, $timeslotId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppointmentTableMap::COL_TIMESLOT_ID, $timeslotId, $comparison);
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
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByEmployeeId($employeeId = null, $comparison = null)
    {
        if (is_array($employeeId)) {
            $useMinMax = false;
            if (isset($employeeId['min'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_EMPLOYEE_ID, $employeeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeeId['max'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_EMPLOYEE_ID, $employeeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppointmentTableMap::COL_EMPLOYEE_ID, $employeeId, $comparison);
    }

    /**
     * Filter the query on the room column
     *
     * Example usage:
     * <code>
     * $query->filterByRoom(1234); // WHERE room = 1234
     * $query->filterByRoom(array(12, 34)); // WHERE room IN (12, 34)
     * $query->filterByRoom(array('min' => 12)); // WHERE room > 12
     * </code>
     *
     * @param     mixed $room The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByRoom($room = null, $comparison = null)
    {
        if (is_array($room)) {
            $useMinMax = false;
            if (isset($room['min'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_ROOM, $room['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($room['max'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_ROOM, $room['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppointmentTableMap::COL_ROOM, $room, $comparison);
    }

    /**
     * Filter the query on the cost column
     *
     * Example usage:
     * <code>
     * $query->filterByCost(1234); // WHERE cost = 1234
     * $query->filterByCost(array(12, 34)); // WHERE cost IN (12, 34)
     * $query->filterByCost(array('min' => 12)); // WHERE cost > 12
     * </code>
     *
     * @param     mixed $cost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByCost($cost = null, $comparison = null)
    {
        if (is_array($cost)) {
            $useMinMax = false;
            if (isset($cost['min'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_COST, $cost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cost['max'])) {
                $this->addUsingAlias(AppointmentTableMap::COL_COST, $cost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppointmentTableMap::COL_COST, $cost, $comparison);
    }

    /**
     * Filter the query by a related \Patient object
     *
     * @param \Patient|ObjectCollection $patient The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByPatient($patient, $comparison = null)
    {
        if ($patient instanceof \Patient) {
            return $this
                ->addUsingAlias(AppointmentTableMap::COL_PATIENT_ID, $patient->getId(), $comparison);
        } elseif ($patient instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AppointmentTableMap::COL_PATIENT_ID, $patient->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
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
     * Filter the query by a related \Employee object
     *
     * @param \Employee|ObjectCollection $employee The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByEmployee($employee, $comparison = null)
    {
        if ($employee instanceof \Employee) {
            return $this
                ->addUsingAlias(AppointmentTableMap::COL_EMPLOYEE_ID, $employee->getId(), $comparison);
        } elseif ($employee instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AppointmentTableMap::COL_EMPLOYEE_ID, $employee->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
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
     * Filter the query by a related \Timeslot object
     *
     * @param \Timeslot|ObjectCollection $timeslot The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAppointmentQuery The current query, for fluid interface
     */
    public function filterByTimeslot($timeslot, $comparison = null)
    {
        if ($timeslot instanceof \Timeslot) {
            return $this
                ->addUsingAlias(AppointmentTableMap::COL_TIMESLOT_ID, $timeslot->getId(), $comparison);
        } elseif ($timeslot instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AppointmentTableMap::COL_TIMESLOT_ID, $timeslot->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTimeslot() only accepts arguments of type \Timeslot or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Timeslot relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function joinTimeslot($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Timeslot');

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
            $this->addJoinObject($join, 'Timeslot');
        }

        return $this;
    }

    /**
     * Use the Timeslot relation Timeslot object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TimeslotQuery A secondary query class using the current class as primary query
     */
    public function useTimeslotQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTimeslot($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Timeslot', '\TimeslotQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAppointment $appointment Object to remove from the list of results
     *
     * @return $this|ChildAppointmentQuery The current query, for fluid interface
     */
    public function prune($appointment = null)
    {
        if ($appointment) {
            $this->addUsingAlias(AppointmentTableMap::COL_ID, $appointment->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the appointment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AppointmentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AppointmentTableMap::clearInstancePool();
            AppointmentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AppointmentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AppointmentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AppointmentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AppointmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AppointmentQuery
