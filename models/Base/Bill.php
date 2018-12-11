<?php

namespace Base;

use \Bill as ChildBill;
use \BillQuery as ChildBillQuery;
use \Employee as ChildEmployee;
use \EmployeeQuery as ChildEmployeeQuery;
use \Patient as ChildPatient;
use \PatientQuery as ChildPatientQuery;
use \Payment as ChildPayment;
use \PaymentQuery as ChildPaymentQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\BillTableMap;
use Map\PaymentTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'bill' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Bill implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\BillTableMap';


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
     * The value for the patient_id field.
     *
     * @var        int
     */
    protected $patient_id;

    /**
     * The value for the employee_id field.
     *
     * @var        int
     */
    protected $employee_id;

    /**
     * The value for the due_date field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $due_date;

    /**
     * The value for the cost field.
     *
     * @var        int
     */
    protected $cost;

    /**
     * The value for the bill_payed field.
     *
     * @var        int
     */
    protected $bill_payed;

    /**
     * The value for the appointment_id field.
     *
     * @var        int
     */
    protected $appointment_id;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * @var        ChildPatient
     */
    protected $aPatient;

    /**
     * @var        ChildEmployee
     */
    protected $aEmployee;

    /**
     * @var        ObjectCollection|ChildPayment[] Collection to store aggregation of ChildPayment objects.
     */
    protected $collPayments;
    protected $collPaymentsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPayment[]
     */
    protected $paymentsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of Base\Bill object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Bill</code> instance.  If
     * <code>obj</code> is an instance of <code>Bill</code>, delegates to
     * <code>equals(Bill)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Bill The current object, for fluid interface
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
     * Get the [patient_id] column value.
     *
     * @return int
     */
    public function getPatientId()
    {
        return $this->patient_id;
    }

    /**
     * Get the [employee_id] column value.
     *
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * Get the [optionally formatted] temporal [due_date] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDueDate($format = NULL)
    {
        if ($format === null) {
            return $this->due_date;
        } else {
            return $this->due_date instanceof \DateTimeInterface ? $this->due_date->format($format) : null;
        }
    }

    /**
     * Get the [cost] column value.
     *
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Get the [bill_payed] column value.
     *
     * @return int
     */
    public function getBillPayed()
    {
        return $this->bill_payed;
    }

    /**
     * Get the [appointment_id] column value.
     *
     * @return int
     */
    public function getAppointmentId()
    {
        return $this->appointment_id;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BillTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [patient_id] column.
     *
     * @param int $v new value
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setPatientId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->patient_id !== $v) {
            $this->patient_id = $v;
            $this->modifiedColumns[BillTableMap::COL_PATIENT_ID] = true;
        }

        if ($this->aPatient !== null && $this->aPatient->getId() !== $v) {
            $this->aPatient = null;
        }

        return $this;
    } // setPatientId()

    /**
     * Set the value of [employee_id] column.
     *
     * @param int $v new value
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setEmployeeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->employee_id !== $v) {
            $this->employee_id = $v;
            $this->modifiedColumns[BillTableMap::COL_EMPLOYEE_ID] = true;
        }

        if ($this->aEmployee !== null && $this->aEmployee->getId() !== $v) {
            $this->aEmployee = null;
        }

        return $this;
    } // setEmployeeId()

    /**
     * Sets the value of [due_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setDueDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->due_date !== null || $dt !== null) {
            if ($this->due_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->due_date->format("Y-m-d H:i:s.u")) {
                $this->due_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BillTableMap::COL_DUE_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setDueDate()

    /**
     * Set the value of [cost] column.
     *
     * @param int $v new value
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setCost($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cost !== $v) {
            $this->cost = $v;
            $this->modifiedColumns[BillTableMap::COL_COST] = true;
        }

        return $this;
    } // setCost()

    /**
     * Set the value of [bill_payed] column.
     *
     * @param int $v new value
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setBillPayed($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bill_payed !== $v) {
            $this->bill_payed = $v;
            $this->modifiedColumns[BillTableMap::COL_BILL_PAYED] = true;
        }

        return $this;
    } // setBillPayed()

    /**
     * Set the value of [appointment_id] column.
     *
     * @param int $v new value
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setAppointmentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->appointment_id !== $v) {
            $this->appointment_id = $v;
            $this->modifiedColumns[BillTableMap::COL_APPOINTMENT_ID] = true;
        }

        return $this;
    } // setAppointmentId()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[BillTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BillTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BillTableMap::translateFieldName('PatientId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->patient_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BillTableMap::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->employee_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BillTableMap::translateFieldName('DueDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->due_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BillTableMap::translateFieldName('Cost', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cost = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BillTableMap::translateFieldName('BillPayed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bill_payed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BillTableMap::translateFieldName('AppointmentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->appointment_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BillTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = BillTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Bill'), 0, $e);
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
        if ($this->aPatient !== null && $this->patient_id !== $this->aPatient->getId()) {
            $this->aPatient = null;
        }
        if ($this->aEmployee !== null && $this->employee_id !== $this->aEmployee->getId()) {
            $this->aEmployee = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(BillTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBillQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPatient = null;
            $this->aEmployee = null;
            $this->collPayments = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Bill::setDeleted()
     * @see Bill::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BillTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBillQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BillTableMap::DATABASE_NAME);
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
                BillTableMap::addInstanceToPool($this);
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

            if ($this->aPatient !== null) {
                if ($this->aPatient->isModified() || $this->aPatient->isNew()) {
                    $affectedRows += $this->aPatient->save($con);
                }
                $this->setPatient($this->aPatient);
            }

            if ($this->aEmployee !== null) {
                if ($this->aEmployee->isModified() || $this->aEmployee->isNew()) {
                    $affectedRows += $this->aEmployee->save($con);
                }
                $this->setEmployee($this->aEmployee);
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

            if ($this->paymentsScheduledForDeletion !== null) {
                if (!$this->paymentsScheduledForDeletion->isEmpty()) {
                    \PaymentQuery::create()
                        ->filterByPrimaryKeys($this->paymentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->paymentsScheduledForDeletion = null;
                }
            }

            if ($this->collPayments !== null) {
                foreach ($this->collPayments as $referrerFK) {
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

        $this->modifiedColumns[BillTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BillTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BillTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(BillTableMap::COL_PATIENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'patient_id';
        }
        if ($this->isColumnModified(BillTableMap::COL_EMPLOYEE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'employee_id';
        }
        if ($this->isColumnModified(BillTableMap::COL_DUE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'due_date';
        }
        if ($this->isColumnModified(BillTableMap::COL_COST)) {
            $modifiedColumns[':p' . $index++]  = 'cost';
        }
        if ($this->isColumnModified(BillTableMap::COL_BILL_PAYED)) {
            $modifiedColumns[':p' . $index++]  = 'bill_payed';
        }
        if ($this->isColumnModified(BillTableMap::COL_APPOINTMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'appointment_id';
        }
        if ($this->isColumnModified(BillTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }

        $sql = sprintf(
            'INSERT INTO bill (%s) VALUES (%s)',
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
                    case 'patient_id':
                        $stmt->bindValue($identifier, $this->patient_id, PDO::PARAM_INT);
                        break;
                    case 'employee_id':
                        $stmt->bindValue($identifier, $this->employee_id, PDO::PARAM_INT);
                        break;
                    case 'due_date':
                        $stmt->bindValue($identifier, $this->due_date ? $this->due_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'cost':
                        $stmt->bindValue($identifier, $this->cost, PDO::PARAM_INT);
                        break;
                    case 'bill_payed':
                        $stmt->bindValue($identifier, $this->bill_payed, PDO::PARAM_INT);
                        break;
                    case 'appointment_id':
                        $stmt->bindValue($identifier, $this->appointment_id, PDO::PARAM_INT);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
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
        $pos = BillTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPatientId();
                break;
            case 2:
                return $this->getEmployeeId();
                break;
            case 3:
                return $this->getDueDate();
                break;
            case 4:
                return $this->getCost();
                break;
            case 5:
                return $this->getBillPayed();
                break;
            case 6:
                return $this->getAppointmentId();
                break;
            case 7:
                return $this->getType();
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

        if (isset($alreadyDumpedObjects['Bill'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Bill'][$this->hashCode()] = true;
        $keys = BillTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPatientId(),
            $keys[2] => $this->getEmployeeId(),
            $keys[3] => $this->getDueDate(),
            $keys[4] => $this->getCost(),
            $keys[5] => $this->getBillPayed(),
            $keys[6] => $this->getAppointmentId(),
            $keys[7] => $this->getType(),
        );
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPatient) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'patient';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'patient';
                        break;
                    default:
                        $key = 'Patient';
                }

                $result[$key] = $this->aPatient->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aEmployee) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'employee';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'employee';
                        break;
                    default:
                        $key = 'Employee';
                }

                $result[$key] = $this->aEmployee->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPayments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'payments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'payments';
                        break;
                    default:
                        $key = 'Payments';
                }

                $result[$key] = $this->collPayments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Bill
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BillTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Bill
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPatientId($value);
                break;
            case 2:
                $this->setEmployeeId($value);
                break;
            case 3:
                $this->setDueDate($value);
                break;
            case 4:
                $this->setCost($value);
                break;
            case 5:
                $this->setBillPayed($value);
                break;
            case 6:
                $this->setAppointmentId($value);
                break;
            case 7:
                $this->setType($value);
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
        $keys = BillTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPatientId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmployeeId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDueDate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCost($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setBillPayed($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAppointmentId($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setType($arr[$keys[7]]);
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
     * @return $this|\Bill The current object, for fluid interface
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
        $criteria = new Criteria(BillTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BillTableMap::COL_ID)) {
            $criteria->add(BillTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BillTableMap::COL_PATIENT_ID)) {
            $criteria->add(BillTableMap::COL_PATIENT_ID, $this->patient_id);
        }
        if ($this->isColumnModified(BillTableMap::COL_EMPLOYEE_ID)) {
            $criteria->add(BillTableMap::COL_EMPLOYEE_ID, $this->employee_id);
        }
        if ($this->isColumnModified(BillTableMap::COL_DUE_DATE)) {
            $criteria->add(BillTableMap::COL_DUE_DATE, $this->due_date);
        }
        if ($this->isColumnModified(BillTableMap::COL_COST)) {
            $criteria->add(BillTableMap::COL_COST, $this->cost);
        }
        if ($this->isColumnModified(BillTableMap::COL_BILL_PAYED)) {
            $criteria->add(BillTableMap::COL_BILL_PAYED, $this->bill_payed);
        }
        if ($this->isColumnModified(BillTableMap::COL_APPOINTMENT_ID)) {
            $criteria->add(BillTableMap::COL_APPOINTMENT_ID, $this->appointment_id);
        }
        if ($this->isColumnModified(BillTableMap::COL_TYPE)) {
            $criteria->add(BillTableMap::COL_TYPE, $this->type);
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
        $criteria = ChildBillQuery::create();
        $criteria->add(BillTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Bill (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPatientId($this->getPatientId());
        $copyObj->setEmployeeId($this->getEmployeeId());
        $copyObj->setDueDate($this->getDueDate());
        $copyObj->setCost($this->getCost());
        $copyObj->setBillPayed($this->getBillPayed());
        $copyObj->setAppointmentId($this->getAppointmentId());
        $copyObj->setType($this->getType());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPayments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPayment($relObj->copy($deepCopy));
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
     * @return \Bill Clone of current object.
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
     * Declares an association between this object and a ChildPatient object.
     *
     * @param  ChildPatient $v
     * @return $this|\Bill The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPatient(ChildPatient $v = null)
    {
        if ($v === null) {
            $this->setPatientId(NULL);
        } else {
            $this->setPatientId($v->getId());
        }

        $this->aPatient = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPatient object, it will not be re-added.
        if ($v !== null) {
            $v->addBill($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPatient object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPatient The associated ChildPatient object.
     * @throws PropelException
     */
    public function getPatient(ConnectionInterface $con = null)
    {
        if ($this->aPatient === null && ($this->patient_id != 0)) {
            $this->aPatient = ChildPatientQuery::create()->findPk($this->patient_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPatient->addBills($this);
             */
        }

        return $this->aPatient;
    }

    /**
     * Declares an association between this object and a ChildEmployee object.
     *
     * @param  ChildEmployee $v
     * @return $this|\Bill The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEmployee(ChildEmployee $v = null)
    {
        if ($v === null) {
            $this->setEmployeeId(NULL);
        } else {
            $this->setEmployeeId($v->getId());
        }

        $this->aEmployee = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEmployee object, it will not be re-added.
        if ($v !== null) {
            $v->addBill($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEmployee object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEmployee The associated ChildEmployee object.
     * @throws PropelException
     */
    public function getEmployee(ConnectionInterface $con = null)
    {
        if ($this->aEmployee === null && ($this->employee_id != 0)) {
            $this->aEmployee = ChildEmployeeQuery::create()->findPk($this->employee_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEmployee->addBills($this);
             */
        }

        return $this->aEmployee;
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
        if ('Payment' == $relationName) {
            $this->initPayments();
            return;
        }
    }

    /**
     * Clears out the collPayments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPayments()
     */
    public function clearPayments()
    {
        $this->collPayments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPayments collection loaded partially.
     */
    public function resetPartialPayments($v = true)
    {
        $this->collPaymentsPartial = $v;
    }

    /**
     * Initializes the collPayments collection.
     *
     * By default this just sets the collPayments collection to an empty array (like clearcollPayments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPayments($overrideExisting = true)
    {
        if (null !== $this->collPayments && !$overrideExisting) {
            return;
        }

        $collectionClassName = PaymentTableMap::getTableMap()->getCollectionClassName();

        $this->collPayments = new $collectionClassName;
        $this->collPayments->setModel('\Payment');
    }

    /**
     * Gets an array of ChildPayment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBill is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPayment[] List of ChildPayment objects
     * @throws PropelException
     */
    public function getPayments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPaymentsPartial && !$this->isNew();
        if (null === $this->collPayments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPayments) {
                // return empty collection
                $this->initPayments();
            } else {
                $collPayments = ChildPaymentQuery::create(null, $criteria)
                    ->filterByBill($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPaymentsPartial && count($collPayments)) {
                        $this->initPayments(false);

                        foreach ($collPayments as $obj) {
                            if (false == $this->collPayments->contains($obj)) {
                                $this->collPayments->append($obj);
                            }
                        }

                        $this->collPaymentsPartial = true;
                    }

                    return $collPayments;
                }

                if ($partial && $this->collPayments) {
                    foreach ($this->collPayments as $obj) {
                        if ($obj->isNew()) {
                            $collPayments[] = $obj;
                        }
                    }
                }

                $this->collPayments = $collPayments;
                $this->collPaymentsPartial = false;
            }
        }

        return $this->collPayments;
    }

    /**
     * Sets a collection of ChildPayment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $payments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBill The current object (for fluent API support)
     */
    public function setPayments(Collection $payments, ConnectionInterface $con = null)
    {
        /** @var ChildPayment[] $paymentsToDelete */
        $paymentsToDelete = $this->getPayments(new Criteria(), $con)->diff($payments);


        $this->paymentsScheduledForDeletion = $paymentsToDelete;

        foreach ($paymentsToDelete as $paymentRemoved) {
            $paymentRemoved->setBill(null);
        }

        $this->collPayments = null;
        foreach ($payments as $payment) {
            $this->addPayment($payment);
        }

        $this->collPayments = $payments;
        $this->collPaymentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Payment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Payment objects.
     * @throws PropelException
     */
    public function countPayments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPaymentsPartial && !$this->isNew();
        if (null === $this->collPayments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPayments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPayments());
            }

            $query = ChildPaymentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBill($this)
                ->count($con);
        }

        return count($this->collPayments);
    }

    /**
     * Method called to associate a ChildPayment object to this object
     * through the ChildPayment foreign key attribute.
     *
     * @param  ChildPayment $l ChildPayment
     * @return $this|\Bill The current object (for fluent API support)
     */
    public function addPayment(ChildPayment $l)
    {
        if ($this->collPayments === null) {
            $this->initPayments();
            $this->collPaymentsPartial = true;
        }

        if (!$this->collPayments->contains($l)) {
            $this->doAddPayment($l);

            if ($this->paymentsScheduledForDeletion and $this->paymentsScheduledForDeletion->contains($l)) {
                $this->paymentsScheduledForDeletion->remove($this->paymentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPayment $payment The ChildPayment object to add.
     */
    protected function doAddPayment(ChildPayment $payment)
    {
        $this->collPayments[]= $payment;
        $payment->setBill($this);
    }

    /**
     * @param  ChildPayment $payment The ChildPayment object to remove.
     * @return $this|ChildBill The current object (for fluent API support)
     */
    public function removePayment(ChildPayment $payment)
    {
        if ($this->getPayments()->contains($payment)) {
            $pos = $this->collPayments->search($payment);
            $this->collPayments->remove($pos);
            if (null === $this->paymentsScheduledForDeletion) {
                $this->paymentsScheduledForDeletion = clone $this->collPayments;
                $this->paymentsScheduledForDeletion->clear();
            }
            $this->paymentsScheduledForDeletion[]= clone $payment;
            $payment->setBill(null);
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
        if (null !== $this->aPatient) {
            $this->aPatient->removeBill($this);
        }
        if (null !== $this->aEmployee) {
            $this->aEmployee->removeBill($this);
        }
        $this->id = null;
        $this->patient_id = null;
        $this->employee_id = null;
        $this->due_date = null;
        $this->cost = null;
        $this->bill_payed = null;
        $this->appointment_id = null;
        $this->type = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collPayments) {
                foreach ($this->collPayments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPayments = null;
        $this->aPatient = null;
        $this->aEmployee = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BillTableMap::DEFAULT_STRING_FORMAT);
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
