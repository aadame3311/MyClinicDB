<?php

namespace Base;

use \Appointment as ChildAppointment;
use \AppointmentQuery as ChildAppointmentQuery;
use \Bill as ChildBill;
use \BillQuery as ChildBillQuery;
use \Department as ChildDepartment;
use \DepartmentQuery as ChildDepartmentQuery;
use \Employee as ChildEmployee;
use \EmployeeQuery as ChildEmployeeQuery;
use \Employeephone as ChildEmployeephone;
use \EmployeephoneQuery as ChildEmployeephoneQuery;
use \Prescription as ChildPrescription;
use \PrescriptionQuery as ChildPrescriptionQuery;
use \Timeslot as ChildTimeslot;
use \TimeslotQuery as ChildTimeslotQuery;
use \Exception;
use \PDO;
use Map\AppointmentTableMap;
use Map\BillTableMap;
use Map\EmployeeTableMap;
use Map\EmployeephoneTableMap;
use Map\PrescriptionTableMap;
use Map\TimeslotTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'employee' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Employee implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\EmployeeTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the first_name field.
     *
     * @var        string
     */
    protected $first_name;

    /**
     * The value for the last_name field.
     *
     * @var        string
     */
    protected $last_name;

    /**
     * The value for the salary field.
     *
     * @var        int
     */
    protected $salary;

    /**
     * The value for the department_id field.
     *
     * @var        int
     */
    protected $department_id;

    /**
     * The value for the address field.
     *
     * @var        string
     */
    protected $address;

    /**
     * The value for the date_of_birth field.
     *
     * @var        string
     */
    protected $date_of_birth;

    /**
     * @var        ChildDepartment
     */
    protected $aDepartment;

    /**
     * @var        ObjectCollection|ChildAppointment[] Collection to store aggregation of ChildAppointment objects.
     */
    protected $collAppointments;
    protected $collAppointmentsPartial;

    /**
     * @var        ObjectCollection|ChildBill[] Collection to store aggregation of ChildBill objects.
     */
    protected $collBills;
    protected $collBillsPartial;

    /**
     * @var        ObjectCollection|ChildEmployeephone[] Collection to store aggregation of ChildEmployeephone objects.
     */
    protected $collEmployeephones;
    protected $collEmployeephonesPartial;

    /**
     * @var        ObjectCollection|ChildPrescription[] Collection to store aggregation of ChildPrescription objects.
     */
    protected $collPrescriptions;
    protected $collPrescriptionsPartial;

    /**
     * @var        ObjectCollection|ChildTimeslot[] Collection to store aggregation of ChildTimeslot objects.
     */
    protected $collTimeslots;
    protected $collTimeslotsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAppointment[]
     */
    protected $appointmentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBill[]
     */
    protected $billsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEmployeephone[]
     */
    protected $employeephonesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPrescription[]
     */
    protected $prescriptionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTimeslot[]
     */
    protected $timeslotsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Employee object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Employee</code> instance.  If
     * <code>obj</code> is an instance of <code>Employee</code>, delegates to
     * <code>equals(Employee)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Employee The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [first_name] column value.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the [last_name] column value.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Get the [salary] column value.
     *
     * @return int
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Get the [department_id] column value.
     *
     * @return int
     */
    public function getDepartmentId()
    {
        return $this->department_id;
    }

    /**
     * Get the [address] column value.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the [date_of_birth] column value.
     *
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [first_name] column.
     *
     * @param string $v new value
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_FIRST_NAME] = true;
        }

        return $this;
    } // setFirstName()

    /**
     * Set the value of [last_name] column.
     *
     * @param string $v new value
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_LAST_NAME] = true;
        }

        return $this;
    } // setLastName()

    /**
     * Set the value of [salary] column.
     *
     * @param int $v new value
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function setSalary($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->salary !== $v) {
            $this->salary = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_SALARY] = true;
        }

        return $this;
    } // setSalary()

    /**
     * Set the value of [department_id] column.
     *
     * @param int $v new value
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function setDepartmentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->department_id !== $v) {
            $this->department_id = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_DEPARTMENT_ID] = true;
        }

        if ($this->aDepartment !== null && $this->aDepartment->getId() !== $v) {
            $this->aDepartment = null;
        }

        return $this;
    } // setDepartmentId()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [date_of_birth] column.
     *
     * @param string $v new value
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function setDateOfBirth($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->date_of_birth !== $v) {
            $this->date_of_birth = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_DATE_OF_BIRTH] = true;
        }

        return $this;
    } // setDateOfBirth()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EmployeeTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EmployeeTableMap::translateFieldName('FirstName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EmployeeTableMap::translateFieldName('LastName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EmployeeTableMap::translateFieldName('Salary', TableMap::TYPE_PHPNAME, $indexType)];
            $this->salary = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EmployeeTableMap::translateFieldName('DepartmentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->department_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EmployeeTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EmployeeTableMap::translateFieldName('DateOfBirth', TableMap::TYPE_PHPNAME, $indexType)];
            $this->date_of_birth = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = EmployeeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Employee'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aDepartment !== null && $this->department_id !== $this->aDepartment->getId()) {
            $this->aDepartment = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EmployeeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEmployeeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDepartment = null;
            $this->collAppointments = null;

            $this->collBills = null;

            $this->collEmployeephones = null;

            $this->collPrescriptions = null;

            $this->collTimeslots = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Employee::setDeleted()
     * @see Employee::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEmployeeQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                EmployeeTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aDepartment !== null) {
                if ($this->aDepartment->isModified() || $this->aDepartment->isNew()) {
                    $affectedRows += $this->aDepartment->save($con);
                }
                $this->setDepartment($this->aDepartment);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->appointmentsScheduledForDeletion !== null) {
                if (!$this->appointmentsScheduledForDeletion->isEmpty()) {
                    \AppointmentQuery::create()
                        ->filterByPrimaryKeys($this->appointmentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->appointmentsScheduledForDeletion = null;
                }
            }

            if ($this->collAppointments !== null) {
                foreach ($this->collAppointments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->billsScheduledForDeletion !== null) {
                if (!$this->billsScheduledForDeletion->isEmpty()) {
                    \BillQuery::create()
                        ->filterByPrimaryKeys($this->billsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->billsScheduledForDeletion = null;
                }
            }

            if ($this->collBills !== null) {
                foreach ($this->collBills as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->employeephonesScheduledForDeletion !== null) {
                if (!$this->employeephonesScheduledForDeletion->isEmpty()) {
                    \EmployeephoneQuery::create()
                        ->filterByPrimaryKeys($this->employeephonesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->employeephonesScheduledForDeletion = null;
                }
            }

            if ($this->collEmployeephones !== null) {
                foreach ($this->collEmployeephones as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->prescriptionsScheduledForDeletion !== null) {
                if (!$this->prescriptionsScheduledForDeletion->isEmpty()) {
                    \PrescriptionQuery::create()
                        ->filterByPrimaryKeys($this->prescriptionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->prescriptionsScheduledForDeletion = null;
                }
            }

            if ($this->collPrescriptions !== null) {
                foreach ($this->collPrescriptions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->timeslotsScheduledForDeletion !== null) {
                if (!$this->timeslotsScheduledForDeletion->isEmpty()) {
                    \TimeslotQuery::create()
                        ->filterByPrimaryKeys($this->timeslotsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->timeslotsScheduledForDeletion = null;
                }
            }

            if ($this->collTimeslots !== null) {
                foreach ($this->collTimeslots as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[EmployeeTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EmployeeTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EmployeeTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'first_name';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'last_name';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_SALARY)) {
            $modifiedColumns[':p' . $index++]  = 'salary';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_DEPARTMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'department_id';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'address';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_DATE_OF_BIRTH)) {
            $modifiedColumns[':p' . $index++]  = 'date_of_birth';
        }

        $sql = sprintf(
            'INSERT INTO employee (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'first_name':
                        $stmt->bindValue($identifier, $this->first_name, PDO::PARAM_STR);
                        break;
                    case 'last_name':
                        $stmt->bindValue($identifier, $this->last_name, PDO::PARAM_STR);
                        break;
                    case 'salary':
                        $stmt->bindValue($identifier, $this->salary, PDO::PARAM_INT);
                        break;
                    case 'department_id':
                        $stmt->bindValue($identifier, $this->department_id, PDO::PARAM_INT);
                        break;
                    case 'address':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'date_of_birth':
                        $stmt->bindValue($identifier, $this->date_of_birth, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmployeeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getFirstName();
                break;
            case 2:
                return $this->getLastName();
                break;
            case 3:
                return $this->getSalary();
                break;
            case 4:
                return $this->getDepartmentId();
                break;
            case 5:
                return $this->getAddress();
                break;
            case 6:
                return $this->getDateOfBirth();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Employee'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Employee'][$this->hashCode()] = true;
        $keys = EmployeeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFirstName(),
            $keys[2] => $this->getLastName(),
            $keys[3] => $this->getSalary(),
            $keys[4] => $this->getDepartmentId(),
            $keys[5] => $this->getAddress(),
            $keys[6] => $this->getDateOfBirth(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aDepartment) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'department';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'department';
                        break;
                    default:
                        $key = 'Department';
                }

                $result[$key] = $this->aDepartment->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAppointments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'appointments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'appointments';
                        break;
                    default:
                        $key = 'Appointments';
                }

                $result[$key] = $this->collAppointments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBills) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bills';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'bills';
                        break;
                    default:
                        $key = 'Bills';
                }

                $result[$key] = $this->collBills->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEmployeephones) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'employeephones';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'employeephones';
                        break;
                    default:
                        $key = 'Employeephones';
                }

                $result[$key] = $this->collEmployeephones->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPrescriptions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'prescriptions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'prescriptions';
                        break;
                    default:
                        $key = 'Prescriptions';
                }

                $result[$key] = $this->collPrescriptions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTimeslots) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'timeslots';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'timeslots';
                        break;
                    default:
                        $key = 'Timeslots';
                }

                $result[$key] = $this->collTimeslots->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Employee
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmployeeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Employee
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFirstName($value);
                break;
            case 2:
                $this->setLastName($value);
                break;
            case 3:
                $this->setSalary($value);
                break;
            case 4:
                $this->setDepartmentId($value);
                break;
            case 5:
                $this->setAddress($value);
                break;
            case 6:
                $this->setDateOfBirth($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = EmployeeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFirstName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLastName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSalary($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDepartmentId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAddress($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDateOfBirth($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Employee The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(EmployeeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EmployeeTableMap::COL_ID)) {
            $criteria->add(EmployeeTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_FIRST_NAME)) {
            $criteria->add(EmployeeTableMap::COL_FIRST_NAME, $this->first_name);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_LAST_NAME)) {
            $criteria->add(EmployeeTableMap::COL_LAST_NAME, $this->last_name);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_SALARY)) {
            $criteria->add(EmployeeTableMap::COL_SALARY, $this->salary);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_DEPARTMENT_ID)) {
            $criteria->add(EmployeeTableMap::COL_DEPARTMENT_ID, $this->department_id);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_ADDRESS)) {
            $criteria->add(EmployeeTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_DATE_OF_BIRTH)) {
            $criteria->add(EmployeeTableMap::COL_DATE_OF_BIRTH, $this->date_of_birth);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildEmployeeQuery::create();
        $criteria->add(EmployeeTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Employee (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setLastName($this->getLastName());
        $copyObj->setSalary($this->getSalary());
        $copyObj->setDepartmentId($this->getDepartmentId());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setDateOfBirth($this->getDateOfBirth());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAppointments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAppointment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBills() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBill($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEmployeephones() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEmployeephone($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPrescriptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPrescription($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTimeslots() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTimeslot($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Employee Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildDepartment object.
     *
     * @param  ChildDepartment $v
     * @return $this|\Employee The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDepartment(ChildDepartment $v = null)
    {
        if ($v === null) {
            $this->setDepartmentId(NULL);
        } else {
            $this->setDepartmentId($v->getId());
        }

        $this->aDepartment = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildDepartment object, it will not be re-added.
        if ($v !== null) {
            $v->addEmployee($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildDepartment object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildDepartment The associated ChildDepartment object.
     * @throws PropelException
     */
    public function getDepartment(ConnectionInterface $con = null)
    {
        if ($this->aDepartment === null && ($this->department_id != 0)) {
            $this->aDepartment = ChildDepartmentQuery::create()->findPk($this->department_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDepartment->addEmployees($this);
             */
        }

        return $this->aDepartment;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Appointment' == $relationName) {
            $this->initAppointments();
            return;
        }
        if ('Bill' == $relationName) {
            $this->initBills();
            return;
        }
        if ('Employeephone' == $relationName) {
            $this->initEmployeephones();
            return;
        }
        if ('Prescription' == $relationName) {
            $this->initPrescriptions();
            return;
        }
        if ('Timeslot' == $relationName) {
            $this->initTimeslots();
            return;
        }
    }

    /**
     * Clears out the collAppointments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAppointments()
     */
    public function clearAppointments()
    {
        $this->collAppointments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAppointments collection loaded partially.
     */
    public function resetPartialAppointments($v = true)
    {
        $this->collAppointmentsPartial = $v;
    }

    /**
     * Initializes the collAppointments collection.
     *
     * By default this just sets the collAppointments collection to an empty array (like clearcollAppointments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAppointments($overrideExisting = true)
    {
        if (null !== $this->collAppointments && !$overrideExisting) {
            return;
        }

        $collectionClassName = AppointmentTableMap::getTableMap()->getCollectionClassName();

        $this->collAppointments = new $collectionClassName;
        $this->collAppointments->setModel('\Appointment');
    }

    /**
     * Gets an array of ChildAppointment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmployee is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAppointment[] List of ChildAppointment objects
     * @throws PropelException
     */
    public function getAppointments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAppointmentsPartial && !$this->isNew();
        if (null === $this->collAppointments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAppointments) {
                // return empty collection
                $this->initAppointments();
            } else {
                $collAppointments = ChildAppointmentQuery::create(null, $criteria)
                    ->filterByEmployee($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAppointmentsPartial && count($collAppointments)) {
                        $this->initAppointments(false);

                        foreach ($collAppointments as $obj) {
                            if (false == $this->collAppointments->contains($obj)) {
                                $this->collAppointments->append($obj);
                            }
                        }

                        $this->collAppointmentsPartial = true;
                    }

                    return $collAppointments;
                }

                if ($partial && $this->collAppointments) {
                    foreach ($this->collAppointments as $obj) {
                        if ($obj->isNew()) {
                            $collAppointments[] = $obj;
                        }
                    }
                }

                $this->collAppointments = $collAppointments;
                $this->collAppointmentsPartial = false;
            }
        }

        return $this->collAppointments;
    }

    /**
     * Sets a collection of ChildAppointment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $appointments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function setAppointments(Collection $appointments, ConnectionInterface $con = null)
    {
        /** @var ChildAppointment[] $appointmentsToDelete */
        $appointmentsToDelete = $this->getAppointments(new Criteria(), $con)->diff($appointments);


        $this->appointmentsScheduledForDeletion = $appointmentsToDelete;

        foreach ($appointmentsToDelete as $appointmentRemoved) {
            $appointmentRemoved->setEmployee(null);
        }

        $this->collAppointments = null;
        foreach ($appointments as $appointment) {
            $this->addAppointment($appointment);
        }

        $this->collAppointments = $appointments;
        $this->collAppointmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Appointment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Appointment objects.
     * @throws PropelException
     */
    public function countAppointments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAppointmentsPartial && !$this->isNew();
        if (null === $this->collAppointments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAppointments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAppointments());
            }

            $query = ChildAppointmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmployee($this)
                ->count($con);
        }

        return count($this->collAppointments);
    }

    /**
     * Method called to associate a ChildAppointment object to this object
     * through the ChildAppointment foreign key attribute.
     *
     * @param  ChildAppointment $l ChildAppointment
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function addAppointment(ChildAppointment $l)
    {
        if ($this->collAppointments === null) {
            $this->initAppointments();
            $this->collAppointmentsPartial = true;
        }

        if (!$this->collAppointments->contains($l)) {
            $this->doAddAppointment($l);

            if ($this->appointmentsScheduledForDeletion and $this->appointmentsScheduledForDeletion->contains($l)) {
                $this->appointmentsScheduledForDeletion->remove($this->appointmentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAppointment $appointment The ChildAppointment object to add.
     */
    protected function doAddAppointment(ChildAppointment $appointment)
    {
        $this->collAppointments[]= $appointment;
        $appointment->setEmployee($this);
    }

    /**
     * @param  ChildAppointment $appointment The ChildAppointment object to remove.
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function removeAppointment(ChildAppointment $appointment)
    {
        if ($this->getAppointments()->contains($appointment)) {
            $pos = $this->collAppointments->search($appointment);
            $this->collAppointments->remove($pos);
            if (null === $this->appointmentsScheduledForDeletion) {
                $this->appointmentsScheduledForDeletion = clone $this->collAppointments;
                $this->appointmentsScheduledForDeletion->clear();
            }
            $this->appointmentsScheduledForDeletion[]= clone $appointment;
            $appointment->setEmployee(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Employee is new, it will return
     * an empty collection; or if this Employee has previously
     * been saved, it will retrieve related Appointments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Employee.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAppointment[] List of ChildAppointment objects
     */
    public function getAppointmentsJoinPatient(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAppointmentQuery::create(null, $criteria);
        $query->joinWith('Patient', $joinBehavior);

        return $this->getAppointments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Employee is new, it will return
     * an empty collection; or if this Employee has previously
     * been saved, it will retrieve related Appointments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Employee.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAppointment[] List of ChildAppointment objects
     */
    public function getAppointmentsJoinTimeslot(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAppointmentQuery::create(null, $criteria);
        $query->joinWith('Timeslot', $joinBehavior);

        return $this->getAppointments($query, $con);
    }

    /**
     * Clears out the collBills collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBills()
     */
    public function clearBills()
    {
        $this->collBills = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBills collection loaded partially.
     */
    public function resetPartialBills($v = true)
    {
        $this->collBillsPartial = $v;
    }

    /**
     * Initializes the collBills collection.
     *
     * By default this just sets the collBills collection to an empty array (like clearcollBills());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBills($overrideExisting = true)
    {
        if (null !== $this->collBills && !$overrideExisting) {
            return;
        }

        $collectionClassName = BillTableMap::getTableMap()->getCollectionClassName();

        $this->collBills = new $collectionClassName;
        $this->collBills->setModel('\Bill');
    }

    /**
     * Gets an array of ChildBill objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmployee is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBill[] List of ChildBill objects
     * @throws PropelException
     */
    public function getBills(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBillsPartial && !$this->isNew();
        if (null === $this->collBills || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBills) {
                // return empty collection
                $this->initBills();
            } else {
                $collBills = ChildBillQuery::create(null, $criteria)
                    ->filterByEmployee($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBillsPartial && count($collBills)) {
                        $this->initBills(false);

                        foreach ($collBills as $obj) {
                            if (false == $this->collBills->contains($obj)) {
                                $this->collBills->append($obj);
                            }
                        }

                        $this->collBillsPartial = true;
                    }

                    return $collBills;
                }

                if ($partial && $this->collBills) {
                    foreach ($this->collBills as $obj) {
                        if ($obj->isNew()) {
                            $collBills[] = $obj;
                        }
                    }
                }

                $this->collBills = $collBills;
                $this->collBillsPartial = false;
            }
        }

        return $this->collBills;
    }

    /**
     * Sets a collection of ChildBill objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bills A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function setBills(Collection $bills, ConnectionInterface $con = null)
    {
        /** @var ChildBill[] $billsToDelete */
        $billsToDelete = $this->getBills(new Criteria(), $con)->diff($bills);


        $this->billsScheduledForDeletion = $billsToDelete;

        foreach ($billsToDelete as $billRemoved) {
            $billRemoved->setEmployee(null);
        }

        $this->collBills = null;
        foreach ($bills as $bill) {
            $this->addBill($bill);
        }

        $this->collBills = $bills;
        $this->collBillsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Bill objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Bill objects.
     * @throws PropelException
     */
    public function countBills(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBillsPartial && !$this->isNew();
        if (null === $this->collBills || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBills) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBills());
            }

            $query = ChildBillQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmployee($this)
                ->count($con);
        }

        return count($this->collBills);
    }

    /**
     * Method called to associate a ChildBill object to this object
     * through the ChildBill foreign key attribute.
     *
     * @param  ChildBill $l ChildBill
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function addBill(ChildBill $l)
    {
        if ($this->collBills === null) {
            $this->initBills();
            $this->collBillsPartial = true;
        }

        if (!$this->collBills->contains($l)) {
            $this->doAddBill($l);

            if ($this->billsScheduledForDeletion and $this->billsScheduledForDeletion->contains($l)) {
                $this->billsScheduledForDeletion->remove($this->billsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBill $bill The ChildBill object to add.
     */
    protected function doAddBill(ChildBill $bill)
    {
        $this->collBills[]= $bill;
        $bill->setEmployee($this);
    }

    /**
     * @param  ChildBill $bill The ChildBill object to remove.
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function removeBill(ChildBill $bill)
    {
        if ($this->getBills()->contains($bill)) {
            $pos = $this->collBills->search($bill);
            $this->collBills->remove($pos);
            if (null === $this->billsScheduledForDeletion) {
                $this->billsScheduledForDeletion = clone $this->collBills;
                $this->billsScheduledForDeletion->clear();
            }
            $this->billsScheduledForDeletion[]= clone $bill;
            $bill->setEmployee(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Employee is new, it will return
     * an empty collection; or if this Employee has previously
     * been saved, it will retrieve related Bills from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Employee.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBill[] List of ChildBill objects
     */
    public function getBillsJoinPatient(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBillQuery::create(null, $criteria);
        $query->joinWith('Patient', $joinBehavior);

        return $this->getBills($query, $con);
    }

    /**
     * Clears out the collEmployeephones collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEmployeephones()
     */
    public function clearEmployeephones()
    {
        $this->collEmployeephones = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEmployeephones collection loaded partially.
     */
    public function resetPartialEmployeephones($v = true)
    {
        $this->collEmployeephonesPartial = $v;
    }

    /**
     * Initializes the collEmployeephones collection.
     *
     * By default this just sets the collEmployeephones collection to an empty array (like clearcollEmployeephones());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEmployeephones($overrideExisting = true)
    {
        if (null !== $this->collEmployeephones && !$overrideExisting) {
            return;
        }

        $collectionClassName = EmployeephoneTableMap::getTableMap()->getCollectionClassName();

        $this->collEmployeephones = new $collectionClassName;
        $this->collEmployeephones->setModel('\Employeephone');
    }

    /**
     * Gets an array of ChildEmployeephone objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmployee is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEmployeephone[] List of ChildEmployeephone objects
     * @throws PropelException
     */
    public function getEmployeephones(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEmployeephonesPartial && !$this->isNew();
        if (null === $this->collEmployeephones || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEmployeephones) {
                // return empty collection
                $this->initEmployeephones();
            } else {
                $collEmployeephones = ChildEmployeephoneQuery::create(null, $criteria)
                    ->filterByEmployee($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEmployeephonesPartial && count($collEmployeephones)) {
                        $this->initEmployeephones(false);

                        foreach ($collEmployeephones as $obj) {
                            if (false == $this->collEmployeephones->contains($obj)) {
                                $this->collEmployeephones->append($obj);
                            }
                        }

                        $this->collEmployeephonesPartial = true;
                    }

                    return $collEmployeephones;
                }

                if ($partial && $this->collEmployeephones) {
                    foreach ($this->collEmployeephones as $obj) {
                        if ($obj->isNew()) {
                            $collEmployeephones[] = $obj;
                        }
                    }
                }

                $this->collEmployeephones = $collEmployeephones;
                $this->collEmployeephonesPartial = false;
            }
        }

        return $this->collEmployeephones;
    }

    /**
     * Sets a collection of ChildEmployeephone objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $employeephones A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function setEmployeephones(Collection $employeephones, ConnectionInterface $con = null)
    {
        /** @var ChildEmployeephone[] $employeephonesToDelete */
        $employeephonesToDelete = $this->getEmployeephones(new Criteria(), $con)->diff($employeephones);


        $this->employeephonesScheduledForDeletion = $employeephonesToDelete;

        foreach ($employeephonesToDelete as $employeephoneRemoved) {
            $employeephoneRemoved->setEmployee(null);
        }

        $this->collEmployeephones = null;
        foreach ($employeephones as $employeephone) {
            $this->addEmployeephone($employeephone);
        }

        $this->collEmployeephones = $employeephones;
        $this->collEmployeephonesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Employeephone objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Employeephone objects.
     * @throws PropelException
     */
    public function countEmployeephones(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEmployeephonesPartial && !$this->isNew();
        if (null === $this->collEmployeephones || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEmployeephones) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEmployeephones());
            }

            $query = ChildEmployeephoneQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmployee($this)
                ->count($con);
        }

        return count($this->collEmployeephones);
    }

    /**
     * Method called to associate a ChildEmployeephone object to this object
     * through the ChildEmployeephone foreign key attribute.
     *
     * @param  ChildEmployeephone $l ChildEmployeephone
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function addEmployeephone(ChildEmployeephone $l)
    {
        if ($this->collEmployeephones === null) {
            $this->initEmployeephones();
            $this->collEmployeephonesPartial = true;
        }

        if (!$this->collEmployeephones->contains($l)) {
            $this->doAddEmployeephone($l);

            if ($this->employeephonesScheduledForDeletion and $this->employeephonesScheduledForDeletion->contains($l)) {
                $this->employeephonesScheduledForDeletion->remove($this->employeephonesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEmployeephone $employeephone The ChildEmployeephone object to add.
     */
    protected function doAddEmployeephone(ChildEmployeephone $employeephone)
    {
        $this->collEmployeephones[]= $employeephone;
        $employeephone->setEmployee($this);
    }

    /**
     * @param  ChildEmployeephone $employeephone The ChildEmployeephone object to remove.
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function removeEmployeephone(ChildEmployeephone $employeephone)
    {
        if ($this->getEmployeephones()->contains($employeephone)) {
            $pos = $this->collEmployeephones->search($employeephone);
            $this->collEmployeephones->remove($pos);
            if (null === $this->employeephonesScheduledForDeletion) {
                $this->employeephonesScheduledForDeletion = clone $this->collEmployeephones;
                $this->employeephonesScheduledForDeletion->clear();
            }
            $this->employeephonesScheduledForDeletion[]= clone $employeephone;
            $employeephone->setEmployee(null);
        }

        return $this;
    }

    /**
     * Clears out the collPrescriptions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPrescriptions()
     */
    public function clearPrescriptions()
    {
        $this->collPrescriptions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPrescriptions collection loaded partially.
     */
    public function resetPartialPrescriptions($v = true)
    {
        $this->collPrescriptionsPartial = $v;
    }

    /**
     * Initializes the collPrescriptions collection.
     *
     * By default this just sets the collPrescriptions collection to an empty array (like clearcollPrescriptions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPrescriptions($overrideExisting = true)
    {
        if (null !== $this->collPrescriptions && !$overrideExisting) {
            return;
        }

        $collectionClassName = PrescriptionTableMap::getTableMap()->getCollectionClassName();

        $this->collPrescriptions = new $collectionClassName;
        $this->collPrescriptions->setModel('\Prescription');
    }

    /**
     * Gets an array of ChildPrescription objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmployee is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPrescription[] List of ChildPrescription objects
     * @throws PropelException
     */
    public function getPrescriptions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPrescriptionsPartial && !$this->isNew();
        if (null === $this->collPrescriptions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPrescriptions) {
                // return empty collection
                $this->initPrescriptions();
            } else {
                $collPrescriptions = ChildPrescriptionQuery::create(null, $criteria)
                    ->filterByEmployee($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPrescriptionsPartial && count($collPrescriptions)) {
                        $this->initPrescriptions(false);

                        foreach ($collPrescriptions as $obj) {
                            if (false == $this->collPrescriptions->contains($obj)) {
                                $this->collPrescriptions->append($obj);
                            }
                        }

                        $this->collPrescriptionsPartial = true;
                    }

                    return $collPrescriptions;
                }

                if ($partial && $this->collPrescriptions) {
                    foreach ($this->collPrescriptions as $obj) {
                        if ($obj->isNew()) {
                            $collPrescriptions[] = $obj;
                        }
                    }
                }

                $this->collPrescriptions = $collPrescriptions;
                $this->collPrescriptionsPartial = false;
            }
        }

        return $this->collPrescriptions;
    }

    /**
     * Sets a collection of ChildPrescription objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $prescriptions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function setPrescriptions(Collection $prescriptions, ConnectionInterface $con = null)
    {
        /** @var ChildPrescription[] $prescriptionsToDelete */
        $prescriptionsToDelete = $this->getPrescriptions(new Criteria(), $con)->diff($prescriptions);


        $this->prescriptionsScheduledForDeletion = $prescriptionsToDelete;

        foreach ($prescriptionsToDelete as $prescriptionRemoved) {
            $prescriptionRemoved->setEmployee(null);
        }

        $this->collPrescriptions = null;
        foreach ($prescriptions as $prescription) {
            $this->addPrescription($prescription);
        }

        $this->collPrescriptions = $prescriptions;
        $this->collPrescriptionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Prescription objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Prescription objects.
     * @throws PropelException
     */
    public function countPrescriptions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPrescriptionsPartial && !$this->isNew();
        if (null === $this->collPrescriptions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPrescriptions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPrescriptions());
            }

            $query = ChildPrescriptionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmployee($this)
                ->count($con);
        }

        return count($this->collPrescriptions);
    }

    /**
     * Method called to associate a ChildPrescription object to this object
     * through the ChildPrescription foreign key attribute.
     *
     * @param  ChildPrescription $l ChildPrescription
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function addPrescription(ChildPrescription $l)
    {
        if ($this->collPrescriptions === null) {
            $this->initPrescriptions();
            $this->collPrescriptionsPartial = true;
        }

        if (!$this->collPrescriptions->contains($l)) {
            $this->doAddPrescription($l);

            if ($this->prescriptionsScheduledForDeletion and $this->prescriptionsScheduledForDeletion->contains($l)) {
                $this->prescriptionsScheduledForDeletion->remove($this->prescriptionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPrescription $prescription The ChildPrescription object to add.
     */
    protected function doAddPrescription(ChildPrescription $prescription)
    {
        $this->collPrescriptions[]= $prescription;
        $prescription->setEmployee($this);
    }

    /**
     * @param  ChildPrescription $prescription The ChildPrescription object to remove.
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function removePrescription(ChildPrescription $prescription)
    {
        if ($this->getPrescriptions()->contains($prescription)) {
            $pos = $this->collPrescriptions->search($prescription);
            $this->collPrescriptions->remove($pos);
            if (null === $this->prescriptionsScheduledForDeletion) {
                $this->prescriptionsScheduledForDeletion = clone $this->collPrescriptions;
                $this->prescriptionsScheduledForDeletion->clear();
            }
            $this->prescriptionsScheduledForDeletion[]= clone $prescription;
            $prescription->setEmployee(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Employee is new, it will return
     * an empty collection; or if this Employee has previously
     * been saved, it will retrieve related Prescriptions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Employee.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPrescription[] List of ChildPrescription objects
     */
    public function getPrescriptionsJoinPatient(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPrescriptionQuery::create(null, $criteria);
        $query->joinWith('Patient', $joinBehavior);

        return $this->getPrescriptions($query, $con);
    }

    /**
     * Clears out the collTimeslots collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTimeslots()
     */
    public function clearTimeslots()
    {
        $this->collTimeslots = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTimeslots collection loaded partially.
     */
    public function resetPartialTimeslots($v = true)
    {
        $this->collTimeslotsPartial = $v;
    }

    /**
     * Initializes the collTimeslots collection.
     *
     * By default this just sets the collTimeslots collection to an empty array (like clearcollTimeslots());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTimeslots($overrideExisting = true)
    {
        if (null !== $this->collTimeslots && !$overrideExisting) {
            return;
        }

        $collectionClassName = TimeslotTableMap::getTableMap()->getCollectionClassName();

        $this->collTimeslots = new $collectionClassName;
        $this->collTimeslots->setModel('\Timeslot');
    }

    /**
     * Gets an array of ChildTimeslot objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmployee is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTimeslot[] List of ChildTimeslot objects
     * @throws PropelException
     */
    public function getTimeslots(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTimeslotsPartial && !$this->isNew();
        if (null === $this->collTimeslots || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTimeslots) {
                // return empty collection
                $this->initTimeslots();
            } else {
                $collTimeslots = ChildTimeslotQuery::create(null, $criteria)
                    ->filterByEmployee($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTimeslotsPartial && count($collTimeslots)) {
                        $this->initTimeslots(false);

                        foreach ($collTimeslots as $obj) {
                            if (false == $this->collTimeslots->contains($obj)) {
                                $this->collTimeslots->append($obj);
                            }
                        }

                        $this->collTimeslotsPartial = true;
                    }

                    return $collTimeslots;
                }

                if ($partial && $this->collTimeslots) {
                    foreach ($this->collTimeslots as $obj) {
                        if ($obj->isNew()) {
                            $collTimeslots[] = $obj;
                        }
                    }
                }

                $this->collTimeslots = $collTimeslots;
                $this->collTimeslotsPartial = false;
            }
        }

        return $this->collTimeslots;
    }

    /**
     * Sets a collection of ChildTimeslot objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $timeslots A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function setTimeslots(Collection $timeslots, ConnectionInterface $con = null)
    {
        /** @var ChildTimeslot[] $timeslotsToDelete */
        $timeslotsToDelete = $this->getTimeslots(new Criteria(), $con)->diff($timeslots);


        $this->timeslotsScheduledForDeletion = $timeslotsToDelete;

        foreach ($timeslotsToDelete as $timeslotRemoved) {
            $timeslotRemoved->setEmployee(null);
        }

        $this->collTimeslots = null;
        foreach ($timeslots as $timeslot) {
            $this->addTimeslot($timeslot);
        }

        $this->collTimeslots = $timeslots;
        $this->collTimeslotsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Timeslot objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Timeslot objects.
     * @throws PropelException
     */
    public function countTimeslots(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTimeslotsPartial && !$this->isNew();
        if (null === $this->collTimeslots || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTimeslots) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTimeslots());
            }

            $query = ChildTimeslotQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmployee($this)
                ->count($con);
        }

        return count($this->collTimeslots);
    }

    /**
     * Method called to associate a ChildTimeslot object to this object
     * through the ChildTimeslot foreign key attribute.
     *
     * @param  ChildTimeslot $l ChildTimeslot
     * @return $this|\Employee The current object (for fluent API support)
     */
    public function addTimeslot(ChildTimeslot $l)
    {
        if ($this->collTimeslots === null) {
            $this->initTimeslots();
            $this->collTimeslotsPartial = true;
        }

        if (!$this->collTimeslots->contains($l)) {
            $this->doAddTimeslot($l);

            if ($this->timeslotsScheduledForDeletion and $this->timeslotsScheduledForDeletion->contains($l)) {
                $this->timeslotsScheduledForDeletion->remove($this->timeslotsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTimeslot $timeslot The ChildTimeslot object to add.
     */
    protected function doAddTimeslot(ChildTimeslot $timeslot)
    {
        $this->collTimeslots[]= $timeslot;
        $timeslot->setEmployee($this);
    }

    /**
     * @param  ChildTimeslot $timeslot The ChildTimeslot object to remove.
     * @return $this|ChildEmployee The current object (for fluent API support)
     */
    public function removeTimeslot(ChildTimeslot $timeslot)
    {
        if ($this->getTimeslots()->contains($timeslot)) {
            $pos = $this->collTimeslots->search($timeslot);
            $this->collTimeslots->remove($pos);
            if (null === $this->timeslotsScheduledForDeletion) {
                $this->timeslotsScheduledForDeletion = clone $this->collTimeslots;
                $this->timeslotsScheduledForDeletion->clear();
            }
            $this->timeslotsScheduledForDeletion[]= clone $timeslot;
            $timeslot->setEmployee(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aDepartment) {
            $this->aDepartment->removeEmployee($this);
        }
        $this->id = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->salary = null;
        $this->department_id = null;
        $this->address = null;
        $this->date_of_birth = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAppointments) {
                foreach ($this->collAppointments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBills) {
                foreach ($this->collBills as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEmployeephones) {
                foreach ($this->collEmployeephones as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPrescriptions) {
                foreach ($this->collPrescriptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTimeslots) {
                foreach ($this->collTimeslots as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAppointments = null;
        $this->collBills = null;
        $this->collEmployeephones = null;
        $this->collPrescriptions = null;
        $this->collTimeslots = null;
        $this->aDepartment = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EmployeeTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
