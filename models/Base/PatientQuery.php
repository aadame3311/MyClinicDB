<?php

namespace Base;

use \Patient as ChildPatient;
use \PatientQuery as ChildPatientQuery;
use \Exception;
use \PDO;
use Map\PatientTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'patient' table.
 *
 *
 *
 * @method     ChildPatientQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildPatientQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildPatientQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildPatientQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildPatientQuery orderByDateOfBirth($order = Criteria::ASC) Order by the date_of_birth column
 * @method     ChildPatientQuery orderByInsurance($order = Criteria::ASC) Order by the insurance column
 *
 * @method     ChildPatientQuery groupById() Group by the ID column
 * @method     ChildPatientQuery groupByFirstName() Group by the first_name column
 * @method     ChildPatientQuery groupByLastName() Group by the last_name column
 * @method     ChildPatientQuery groupByAddress() Group by the address column
 * @method     ChildPatientQuery groupByDateOfBirth() Group by the date_of_birth column
 * @method     ChildPatientQuery groupByInsurance() Group by the insurance column
 *
 * @method     ChildPatientQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPatientQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPatientQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPatientQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPatientQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPatientQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPatientQuery leftJoinAppointment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appointment relation
 * @method     ChildPatientQuery rightJoinAppointment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appointment relation
 * @method     ChildPatientQuery innerJoinAppointment($relationAlias = null) Adds a INNER JOIN clause to the query using the Appointment relation
 *
 * @method     ChildPatientQuery joinWithAppointment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Appointment relation
 *
 * @method     ChildPatientQuery leftJoinWithAppointment() Adds a LEFT JOIN clause and with to the query using the Appointment relation
 * @method     ChildPatientQuery rightJoinWithAppointment() Adds a RIGHT JOIN clause and with to the query using the Appointment relation
 * @method     ChildPatientQuery innerJoinWithAppointment() Adds a INNER JOIN clause and with to the query using the Appointment relation
 *
 * @method     ChildPatientQuery leftJoinBill($relationAlias = null) Adds a LEFT JOIN clause to the query using the Bill relation
 * @method     ChildPatientQuery rightJoinBill($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Bill relation
 * @method     ChildPatientQuery innerJoinBill($relationAlias = null) Adds a INNER JOIN clause to the query using the Bill relation
 *
 * @method     ChildPatientQuery joinWithBill($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Bill relation
 *
 * @method     ChildPatientQuery leftJoinWithBill() Adds a LEFT JOIN clause and with to the query using the Bill relation
 * @method     ChildPatientQuery rightJoinWithBill() Adds a RIGHT JOIN clause and with to the query using the Bill relation
 * @method     ChildPatientQuery innerJoinWithBill() Adds a INNER JOIN clause and with to the query using the Bill relation
 *
 * @method     ChildPatientQuery leftJoinHealthhistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Healthhistory relation
 * @method     ChildPatientQuery rightJoinHealthhistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Healthhistory relation
 * @method     ChildPatientQuery innerJoinHealthhistory($relationAlias = null) Adds a INNER JOIN clause to the query using the Healthhistory relation
 *
 * @method     ChildPatientQuery joinWithHealthhistory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Healthhistory relation
 *
 * @method     ChildPatientQuery leftJoinWithHealthhistory() Adds a LEFT JOIN clause and with to the query using the Healthhistory relation
 * @method     ChildPatientQuery rightJoinWithHealthhistory() Adds a RIGHT JOIN clause and with to the query using the Healthhistory relation
 * @method     ChildPatientQuery innerJoinWithHealthhistory() Adds a INNER JOIN clause and with to the query using the Healthhistory relation
 *
 * @method     ChildPatientQuery leftJoinPatientphone($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patientphone relation
 * @method     ChildPatientQuery rightJoinPatientphone($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patientphone relation
 * @method     ChildPatientQuery innerJoinPatientphone($relationAlias = null) Adds a INNER JOIN clause to the query using the Patientphone relation
 *
 * @method     ChildPatientQuery joinWithPatientphone($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patientphone relation
 *
 * @method     ChildPatientQuery leftJoinWithPatientphone() Adds a LEFT JOIN clause and with to the query using the Patientphone relation
 * @method     ChildPatientQuery rightJoinWithPatientphone() Adds a RIGHT JOIN clause and with to the query using the Patientphone relation
 * @method     ChildPatientQuery innerJoinWithPatientphone() Adds a INNER JOIN clause and with to the query using the Patientphone relation
 *
 * @method     ChildPatientQuery leftJoinPrescription($relationAlias = null) Adds a LEFT JOIN clause to the query using the Prescription relation
 * @method     ChildPatientQuery rightJoinPrescription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Prescription relation
 * @method     ChildPatientQuery innerJoinPrescription($relationAlias = null) Adds a INNER JOIN clause to the query using the Prescription relation
 *
 * @method     ChildPatientQuery joinWithPrescription($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Prescription relation
 *
 * @method     ChildPatientQuery leftJoinWithPrescription() Adds a LEFT JOIN clause and with to the query using the Prescription relation
 * @method     ChildPatientQuery rightJoinWithPrescription() Adds a RIGHT JOIN clause and with to the query using the Prescription relation
 * @method     ChildPatientQuery innerJoinWithPrescription() Adds a INNER JOIN clause and with to the query using the Prescription relation
 *
 * @method     \AppointmentQuery|\BillQuery|\HealthhistoryQuery|\PatientphoneQuery|\PrescriptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPatient findOne(ConnectionInterface $con = null) Return the first ChildPatient matching the query
 * @method     ChildPatient findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPatient matching the query, or a new ChildPatient object populated from the query conditions when no match is found
 *
 * @method     ChildPatient findOneById(int $ID) Return the first ChildPatient filtered by the ID column
 * @method     ChildPatient findOneByFirstName(string $first_name) Return the first ChildPatient filtered by the first_name column
 * @method     ChildPatient findOneByLastName(string $last_name) Return the first ChildPatient filtered by the last_name column
 * @method     ChildPatient findOneByAddress(string $address) Return the first ChildPatient filtered by the address column
 * @method     ChildPatient findOneByDateOfBirth(string $date_of_birth) Return the first ChildPatient filtered by the date_of_birth column
 * @method     ChildPatient findOneByInsurance(string $insurance) Return the first ChildPatient filtered by the insurance column *

 * @method     ChildPatient requirePk($key, ConnectionInterface $con = null) Return the ChildPatient by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOne(ConnectionInterface $con = null) Return the first ChildPatient matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPatient requireOneById(int $ID) Return the first ChildPatient filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByFirstName(string $first_name) Return the first ChildPatient filtered by the first_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByLastName(string $last_name) Return the first ChildPatient filtered by the last_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByAddress(string $address) Return the first ChildPatient filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByDateOfBirth(string $date_of_birth) Return the first ChildPatient filtered by the date_of_birth column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByInsurance(string $insurance) Return the first ChildPatient filtered by the insurance column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPatient[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPatient objects based on current ModelCriteria
 * @method     ChildPatient[]|ObjectCollection findById(int $ID) Return ChildPatient objects filtered by the ID column
 * @method     ChildPatient[]|ObjectCollection findByFirstName(string $first_name) Return ChildPatient objects filtered by the first_name column
 * @method     ChildPatient[]|ObjectCollection findByLastName(string $last_name) Return ChildPatient objects filtered by the last_name column
 * @method     ChildPatient[]|ObjectCollection findByAddress(string $address) Return ChildPatient objects filtered by the address column
 * @method     ChildPatient[]|ObjectCollection findByDateOfBirth(string $date_of_birth) Return ChildPatient objects filtered by the date_of_birth column
 * @method     ChildPatient[]|ObjectCollection findByInsurance(string $insurance) Return ChildPatient objects filtered by the insurance column
 * @method     ChildPatient[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PatientQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PatientQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Patient', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPatientQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPatientQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPatientQuery) {
            return $criteria;
        }
        $query = new ChildPatientQuery();
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
     * @return ChildPatient|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PatientTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PatientTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPatient A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, first_name, last_name, address, date_of_birth, insurance FROM patient WHERE ID = :p0';
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
            /** @var ChildPatient $obj */
            $obj = new ChildPatient();
            $obj->hydrate($row);
            PatientTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPatient|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PatientTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PatientTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PatientTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PatientTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%', Criteria::LIKE); // WHERE first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_FIRST_NAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%', Criteria::LIKE); // WHERE last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the date_of_birth column
     *
     * Example usage:
     * <code>
     * $query->filterByDateOfBirth('fooValue');   // WHERE date_of_birth = 'fooValue'
     * $query->filterByDateOfBirth('%fooValue%', Criteria::LIKE); // WHERE date_of_birth LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dateOfBirth The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByDateOfBirth($dateOfBirth = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dateOfBirth)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_DATE_OF_BIRTH, $dateOfBirth, $comparison);
    }

    /**
     * Filter the query on the insurance column
     *
     * Example usage:
     * <code>
     * $query->filterByInsurance('fooValue');   // WHERE insurance = 'fooValue'
     * $query->filterByInsurance('%fooValue%', Criteria::LIKE); // WHERE insurance LIKE '%fooValue%'
     * </code>
     *
     * @param     string $insurance The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByInsurance($insurance = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($insurance)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_INSURANCE, $insurance, $comparison);
    }

    /**
     * Filter the query by a related \Appointment object
     *
     * @param \Appointment|ObjectCollection $appointment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByAppointment($appointment, $comparison = null)
    {
        if ($appointment instanceof \Appointment) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_ID, $appointment->getPatientId(), $comparison);
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
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
     * Filter the query by a related \Bill object
     *
     * @param \Bill|ObjectCollection $bill the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByBill($bill, $comparison = null)
    {
        if ($bill instanceof \Bill) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_ID, $bill->getPatientId(), $comparison);
        } elseif ($bill instanceof ObjectCollection) {
            return $this
                ->useBillQuery()
                ->filterByPrimaryKeys($bill->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBill() only accepts arguments of type \Bill or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Bill relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function joinBill($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Bill');

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
            $this->addJoinObject($join, 'Bill');
        }

        return $this;
    }

    /**
     * Use the Bill relation Bill object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BillQuery A secondary query class using the current class as primary query
     */
    public function useBillQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBill($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Bill', '\BillQuery');
    }

    /**
     * Filter the query by a related \Healthhistory object
     *
     * @param \Healthhistory|ObjectCollection $healthhistory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByHealthhistory($healthhistory, $comparison = null)
    {
        if ($healthhistory instanceof \Healthhistory) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_ID, $healthhistory->getPatientId(), $comparison);
        } elseif ($healthhistory instanceof ObjectCollection) {
            return $this
                ->useHealthhistoryQuery()
                ->filterByPrimaryKeys($healthhistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHealthhistory() only accepts arguments of type \Healthhistory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Healthhistory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function joinHealthhistory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Healthhistory');

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
            $this->addJoinObject($join, 'Healthhistory');
        }

        return $this;
    }

    /**
     * Use the Healthhistory relation Healthhistory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \HealthhistoryQuery A secondary query class using the current class as primary query
     */
    public function useHealthhistoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHealthhistory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Healthhistory', '\HealthhistoryQuery');
    }

    /**
     * Filter the query by a related \Patientphone object
     *
     * @param \Patientphone|ObjectCollection $patientphone the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPatientphone($patientphone, $comparison = null)
    {
        if ($patientphone instanceof \Patientphone) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_ID, $patientphone->getPatientId(), $comparison);
        } elseif ($patientphone instanceof ObjectCollection) {
            return $this
                ->usePatientphoneQuery()
                ->filterByPrimaryKeys($patientphone->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPatientphone() only accepts arguments of type \Patientphone or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Patientphone relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function joinPatientphone($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Patientphone');

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
            $this->addJoinObject($join, 'Patientphone');
        }

        return $this;
    }

    /**
     * Use the Patientphone relation Patientphone object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PatientphoneQuery A secondary query class using the current class as primary query
     */
    public function usePatientphoneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPatientphone($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Patientphone', '\PatientphoneQuery');
    }

    /**
     * Filter the query by a related \Prescription object
     *
     * @param \Prescription|ObjectCollection $prescription the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPrescription($prescription, $comparison = null)
    {
        if ($prescription instanceof \Prescription) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_ID, $prescription->getPatientId(), $comparison);
        } elseif ($prescription instanceof ObjectCollection) {
            return $this
                ->usePrescriptionQuery()
                ->filterByPrimaryKeys($prescription->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPrescription() only accepts arguments of type \Prescription or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Prescription relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function joinPrescription($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Prescription');

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
            $this->addJoinObject($join, 'Prescription');
        }

        return $this;
    }

    /**
     * Use the Prescription relation Prescription object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PrescriptionQuery A secondary query class using the current class as primary query
     */
    public function usePrescriptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPrescription($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Prescription', '\PrescriptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPatient $patient Object to remove from the list of results
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function prune($patient = null)
    {
        if ($patient) {
            $this->addUsingAlias(PatientTableMap::COL_ID, $patient->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the patient table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PatientTableMap::clearInstancePool();
            PatientTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PatientTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PatientTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PatientTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PatientQuery
