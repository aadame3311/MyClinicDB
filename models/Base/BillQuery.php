<?php

namespace Base;

use \Bill as ChildBill;
use \BillQuery as ChildBillQuery;
use \Exception;
use \PDO;
use Map\BillTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'bill' table.
 *
 *
 *
 * @method     ChildBillQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildBillQuery orderByPatientId($order = Criteria::ASC) Order by the patient_id column
 * @method     ChildBillQuery orderByEmployeeId($order = Criteria::ASC) Order by the employee_id column
 * @method     ChildBillQuery orderByDueDate($order = Criteria::ASC) Order by the due_date column
 * @method     ChildBillQuery orderByCost($order = Criteria::ASC) Order by the cost column
 * @method     ChildBillQuery orderByBillPayed($order = Criteria::ASC) Order by the bill_payed column
 * @method     ChildBillQuery orderByAppointmentId($order = Criteria::ASC) Order by the appointment_id column
 * @method     ChildBillQuery orderByType($order = Criteria::ASC) Order by the type column
 *
 * @method     ChildBillQuery groupById() Group by the ID column
 * @method     ChildBillQuery groupByPatientId() Group by the patient_id column
 * @method     ChildBillQuery groupByEmployeeId() Group by the employee_id column
 * @method     ChildBillQuery groupByDueDate() Group by the due_date column
 * @method     ChildBillQuery groupByCost() Group by the cost column
 * @method     ChildBillQuery groupByBillPayed() Group by the bill_payed column
 * @method     ChildBillQuery groupByAppointmentId() Group by the appointment_id column
 * @method     ChildBillQuery groupByType() Group by the type column
 *
 * @method     ChildBillQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBillQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBillQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBillQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBillQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBillQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBillQuery leftJoinPatient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patient relation
 * @method     ChildBillQuery rightJoinPatient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patient relation
 * @method     ChildBillQuery innerJoinPatient($relationAlias = null) Adds a INNER JOIN clause to the query using the Patient relation
 *
 * @method     ChildBillQuery joinWithPatient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patient relation
 *
 * @method     ChildBillQuery leftJoinWithPatient() Adds a LEFT JOIN clause and with to the query using the Patient relation
 * @method     ChildBillQuery rightJoinWithPatient() Adds a RIGHT JOIN clause and with to the query using the Patient relation
 * @method     ChildBillQuery innerJoinWithPatient() Adds a INNER JOIN clause and with to the query using the Patient relation
 *
 * @method     ChildBillQuery leftJoinEmployee($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employee relation
 * @method     ChildBillQuery rightJoinEmployee($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employee relation
 * @method     ChildBillQuery innerJoinEmployee($relationAlias = null) Adds a INNER JOIN clause to the query using the Employee relation
 *
 * @method     ChildBillQuery joinWithEmployee($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employee relation
 *
 * @method     ChildBillQuery leftJoinWithEmployee() Adds a LEFT JOIN clause and with to the query using the Employee relation
 * @method     ChildBillQuery rightJoinWithEmployee() Adds a RIGHT JOIN clause and with to the query using the Employee relation
 * @method     ChildBillQuery innerJoinWithEmployee() Adds a INNER JOIN clause and with to the query using the Employee relation
 *
 * @method     ChildBillQuery leftJoinPayment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Payment relation
 * @method     ChildBillQuery rightJoinPayment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Payment relation
 * @method     ChildBillQuery innerJoinPayment($relationAlias = null) Adds a INNER JOIN clause to the query using the Payment relation
 *
 * @method     ChildBillQuery joinWithPayment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Payment relation
 *
 * @method     ChildBillQuery leftJoinWithPayment() Adds a LEFT JOIN clause and with to the query using the Payment relation
 * @method     ChildBillQuery rightJoinWithPayment() Adds a RIGHT JOIN clause and with to the query using the Payment relation
 * @method     ChildBillQuery innerJoinWithPayment() Adds a INNER JOIN clause and with to the query using the Payment relation
 *
 * @method     \PatientQuery|\EmployeeQuery|\PaymentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBill findOne(ConnectionInterface $con = null) Return the first ChildBill matching the query
 * @method     ChildBill findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBill matching the query, or a new ChildBill object populated from the query conditions when no match is found
 *
 * @method     ChildBill findOneById(int $ID) Return the first ChildBill filtered by the ID column
 * @method     ChildBill findOneByPatientId(int $patient_id) Return the first ChildBill filtered by the patient_id column
 * @method     ChildBill findOneByEmployeeId(int $employee_id) Return the first ChildBill filtered by the employee_id column
 * @method     ChildBill findOneByDueDate(string $due_date) Return the first ChildBill filtered by the due_date column
 * @method     ChildBill findOneByCost(int $cost) Return the first ChildBill filtered by the cost column
 * @method     ChildBill findOneByBillPayed(int $bill_payed) Return the first ChildBill filtered by the bill_payed column
 * @method     ChildBill findOneByAppointmentId(int $appointment_id) Return the first ChildBill filtered by the appointment_id column
 * @method     ChildBill findOneByType(string $type) Return the first ChildBill filtered by the type column *

 * @method     ChildBill requirePk($key, ConnectionInterface $con = null) Return the ChildBill by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOne(ConnectionInterface $con = null) Return the first ChildBill matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBill requireOneById(int $ID) Return the first ChildBill filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOneByPatientId(int $patient_id) Return the first ChildBill filtered by the patient_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOneByEmployeeId(int $employee_id) Return the first ChildBill filtered by the employee_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOneByDueDate(string $due_date) Return the first ChildBill filtered by the due_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOneByCost(int $cost) Return the first ChildBill filtered by the cost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOneByBillPayed(int $bill_payed) Return the first ChildBill filtered by the bill_payed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOneByAppointmentId(int $appointment_id) Return the first ChildBill filtered by the appointment_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBill requireOneByType(string $type) Return the first ChildBill filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBill[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBill objects based on current ModelCriteria
 * @method     ChildBill[]|ObjectCollection findById(int $ID) Return ChildBill objects filtered by the ID column
 * @method     ChildBill[]|ObjectCollection findByPatientId(int $patient_id) Return ChildBill objects filtered by the patient_id column
 * @method     ChildBill[]|ObjectCollection findByEmployeeId(int $employee_id) Return ChildBill objects filtered by the employee_id column
 * @method     ChildBill[]|ObjectCollection findByDueDate(string $due_date) Return ChildBill objects filtered by the due_date column
 * @method     ChildBill[]|ObjectCollection findByCost(int $cost) Return ChildBill objects filtered by the cost column
 * @method     ChildBill[]|ObjectCollection findByBillPayed(int $bill_payed) Return ChildBill objects filtered by the bill_payed column
 * @method     ChildBill[]|ObjectCollection findByAppointmentId(int $appointment_id) Return ChildBill objects filtered by the appointment_id column
 * @method     ChildBill[]|ObjectCollection findByType(string $type) Return ChildBill objects filtered by the type column
 * @method     ChildBill[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BillQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BillQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Bill', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBillQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBillQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBillQuery) {
            return $criteria;
        }
        $query = new ChildBillQuery();
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
     * @return ChildBill|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BillTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BillTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBill A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, patient_id, employee_id, due_date, cost, bill_payed, appointment_id, type FROM bill WHERE ID = :p0';
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
            /** @var ChildBill $obj */
            $obj = new ChildBill();
            $obj->hydrate($row);
            BillTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBill|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BillTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BillTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BillTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BillTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByPatientId($patientId = null, $comparison = null)
    {
        if (is_array($patientId)) {
            $useMinMax = false;
            if (isset($patientId['min'])) {
                $this->addUsingAlias(BillTableMap::COL_PATIENT_ID, $patientId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($patientId['max'])) {
                $this->addUsingAlias(BillTableMap::COL_PATIENT_ID, $patientId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_PATIENT_ID, $patientId, $comparison);
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
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByEmployeeId($employeeId = null, $comparison = null)
    {
        if (is_array($employeeId)) {
            $useMinMax = false;
            if (isset($employeeId['min'])) {
                $this->addUsingAlias(BillTableMap::COL_EMPLOYEE_ID, $employeeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeeId['max'])) {
                $this->addUsingAlias(BillTableMap::COL_EMPLOYEE_ID, $employeeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_EMPLOYEE_ID, $employeeId, $comparison);
    }

    /**
     * Filter the query on the due_date column
     *
     * Example usage:
     * <code>
     * $query->filterByDueDate('2011-03-14'); // WHERE due_date = '2011-03-14'
     * $query->filterByDueDate('now'); // WHERE due_date = '2011-03-14'
     * $query->filterByDueDate(array('max' => 'yesterday')); // WHERE due_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $dueDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByDueDate($dueDate = null, $comparison = null)
    {
        if (is_array($dueDate)) {
            $useMinMax = false;
            if (isset($dueDate['min'])) {
                $this->addUsingAlias(BillTableMap::COL_DUE_DATE, $dueDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dueDate['max'])) {
                $this->addUsingAlias(BillTableMap::COL_DUE_DATE, $dueDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_DUE_DATE, $dueDate, $comparison);
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
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByCost($cost = null, $comparison = null)
    {
        if (is_array($cost)) {
            $useMinMax = false;
            if (isset($cost['min'])) {
                $this->addUsingAlias(BillTableMap::COL_COST, $cost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cost['max'])) {
                $this->addUsingAlias(BillTableMap::COL_COST, $cost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_COST, $cost, $comparison);
    }

    /**
     * Filter the query on the bill_payed column
     *
     * Example usage:
     * <code>
     * $query->filterByBillPayed(1234); // WHERE bill_payed = 1234
     * $query->filterByBillPayed(array(12, 34)); // WHERE bill_payed IN (12, 34)
     * $query->filterByBillPayed(array('min' => 12)); // WHERE bill_payed > 12
     * </code>
     *
     * @param     mixed $billPayed The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByBillPayed($billPayed = null, $comparison = null)
    {
        if (is_array($billPayed)) {
            $useMinMax = false;
            if (isset($billPayed['min'])) {
                $this->addUsingAlias(BillTableMap::COL_BILL_PAYED, $billPayed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($billPayed['max'])) {
                $this->addUsingAlias(BillTableMap::COL_BILL_PAYED, $billPayed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_BILL_PAYED, $billPayed, $comparison);
    }

    /**
     * Filter the query on the appointment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAppointmentId(1234); // WHERE appointment_id = 1234
     * $query->filterByAppointmentId(array(12, 34)); // WHERE appointment_id IN (12, 34)
     * $query->filterByAppointmentId(array('min' => 12)); // WHERE appointment_id > 12
     * </code>
     *
     * @param     mixed $appointmentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByAppointmentId($appointmentId = null, $comparison = null)
    {
        if (is_array($appointmentId)) {
            $useMinMax = false;
            if (isset($appointmentId['min'])) {
                $this->addUsingAlias(BillTableMap::COL_APPOINTMENT_ID, $appointmentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($appointmentId['max'])) {
                $this->addUsingAlias(BillTableMap::COL_APPOINTMENT_ID, $appointmentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_APPOINTMENT_ID, $appointmentId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query by a related \Patient object
     *
     * @param \Patient|ObjectCollection $patient The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBillQuery The current query, for fluid interface
     */
    public function filterByPatient($patient, $comparison = null)
    {
        if ($patient instanceof \Patient) {
            return $this
                ->addUsingAlias(BillTableMap::COL_PATIENT_ID, $patient->getId(), $comparison);
        } elseif ($patient instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BillTableMap::COL_PATIENT_ID, $patient->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildBillQuery The current query, for fluid interface
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
     * @return ChildBillQuery The current query, for fluid interface
     */
    public function filterByEmployee($employee, $comparison = null)
    {
        if ($employee instanceof \Employee) {
            return $this
                ->addUsingAlias(BillTableMap::COL_EMPLOYEE_ID, $employee->getId(), $comparison);
        } elseif ($employee instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BillTableMap::COL_EMPLOYEE_ID, $employee->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildBillQuery The current query, for fluid interface
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
     * Filter the query by a related \Payment object
     *
     * @param \Payment|ObjectCollection $payment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillQuery The current query, for fluid interface
     */
    public function filterByPayment($payment, $comparison = null)
    {
        if ($payment instanceof \Payment) {
            return $this
                ->addUsingAlias(BillTableMap::COL_ID, $payment->getBillId(), $comparison);
        } elseif ($payment instanceof ObjectCollection) {
            return $this
                ->usePaymentQuery()
                ->filterByPrimaryKeys($payment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPayment() only accepts arguments of type \Payment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Payment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function joinPayment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Payment');

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
            $this->addJoinObject($join, 'Payment');
        }

        return $this;
    }

    /**
     * Use the Payment relation Payment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PaymentQuery A secondary query class using the current class as primary query
     */
    public function usePaymentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPayment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Payment', '\PaymentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBill $bill Object to remove from the list of results
     *
     * @return $this|ChildBillQuery The current query, for fluid interface
     */
    public function prune($bill = null)
    {
        if ($bill) {
            $this->addUsingAlias(BillTableMap::COL_ID, $bill->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the bill table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BillTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BillTableMap::clearInstancePool();
            BillTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BillTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BillTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BillTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BillTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BillQuery
