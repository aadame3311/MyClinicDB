<?php

namespace Base;

use \Appointment as ChildAppointment;
use \AppointmentQuery as ChildAppointmentQuery;
use \Bill as ChildBill;
use \BillQuery as ChildBillQuery;
use \Healthhistory as ChildHealthhistory;
use \HealthhistoryQuery as ChildHealthhistoryQuery;
use \Patient as ChildPatient;
use \PatientQuery as ChildPatientQuery;
use \Patientphone as ChildPatientphone;
use \PatientphoneQuery as ChildPatientphoneQuery;
use \Prescription as ChildPrescription;
use \PrescriptionQuery as ChildPrescriptionQuery;
use \Exception;
use \PDO;
use Map\AppointmentTableMap;
use Map\BillTableMap;
use Map\HealthhistoryTableMap;
use Map\PatientTableMap;
use Map\PatientphoneTableMap;
use Map\PrescriptionTableMap;
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
 * Base class that represents a row from the 'patient' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Patient implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PatientTableMap';


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
     * The value for the insurance field.
     *
     * @var        string
     */
    protected $insurance;

    /**
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the password_hash field.
     *
     * @var        string
     */
    protected $password_hash;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

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
     * @var        ObjectCollection|ChildHealthhistory[] Collection to store aggregation of ChildHealthhistory objects.
     */
    protected $collHealthhistories;
    protected $collHealthhistoriesPartial;

    /**
     * @var        ObjectCollection|ChildPatientphone[] Collection to store aggregation of ChildPatientphone objects.
     */
    protected $collPatientphones;
    protected $collPatientphonesPartial;

    /**
     * @var        ObjectCollection|ChildPrescription[] Collection to store aggregation of ChildPrescription objects.
     */
    protected $collPrescriptions;
    protected $collPrescriptionsPartial;

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
     * @var ObjectCollection|ChildHealthhistory[]
     */
    protected $healthhistoriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPatientphone[]
     */
    protected $patientphonesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPrescription[]
     */
    protected $prescriptionsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Patient object.
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
     * Compares this with another <code>Patient</code> instance.  If
     * <code>obj</code> is an instance of <code>Patient</code>, delegates to
     * <code>equals(Patient)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Patient The current object, for fluid interface
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
     * Get the [insurance] column value.
     *
     * @return string
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password_hash] column value.
     *
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PatientTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [first_name] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[PatientTableMap::COL_FIRST_NAME] = true;
        }

        return $this;
    } // setFirstName()

    /**
     * Set the value of [last_name] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[PatientTableMap::COL_LAST_NAME] = true;
        }

        return $this;
    } // setLastName()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[PatientTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [date_of_birth] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setDateOfBirth($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->date_of_birth !== $v) {
            $this->date_of_birth = $v;
            $this->modifiedColumns[PatientTableMap::COL_DATE_OF_BIRTH] = true;
        }

        return $this;
    } // setDateOfBirth()

    /**
     * Set the value of [insurance] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setInsurance($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->insurance !== $v) {
            $this->insurance = $v;
            $this->modifiedColumns[PatientTableMap::COL_INSURANCE] = true;
        }

        return $this;
    } // setInsurance()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[PatientTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password_hash] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setPasswordHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password_hash !== $v) {
            $this->password_hash = $v;
            $this->modifiedColumns[PatientTableMap::COL_PASSWORD_HASH] = true;
        }

        return $this;
    } // setPasswordHash()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[PatientTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PatientTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PatientTableMap::translateFieldName('FirstName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PatientTableMap::translateFieldName('LastName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PatientTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PatientTableMap::translateFieldName('DateOfBirth', TableMap::TYPE_PHPNAME, $indexType)];
            $this->date_of_birth = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PatientTableMap::translateFieldName('Insurance', TableMap::TYPE_PHPNAME, $indexType)];
            $this->insurance = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PatientTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PatientTableMap::translateFieldName('PasswordHash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password_hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PatientTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = PatientTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Patient'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PatientTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPatientQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAppointments = null;

            $this->collBills = null;

            $this->collHealthhistories = null;

            $this->collPatientphones = null;

            $this->collPrescriptions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Patient::setDeleted()
     * @see Patient::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPatientQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
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
                PatientTableMap::addInstanceToPool($this);
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

            if ($this->healthhistoriesScheduledForDeletion !== null) {
                if (!$this->healthhistoriesScheduledForDeletion->isEmpty()) {
                    \HealthhistoryQuery::create()
                        ->filterByPrimaryKeys($this->healthhistoriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->healthhistoriesScheduledForDeletion = null;
                }
            }

            if ($this->collHealthhistories !== null) {
                foreach ($this->collHealthhistories as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->patientphonesScheduledForDeletion !== null) {
                if (!$this->patientphonesScheduledForDeletion->isEmpty()) {
                    \PatientphoneQuery::create()
                        ->filterByPrimaryKeys($this->patientphonesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->patientphonesScheduledForDeletion = null;
                }
            }

            if ($this->collPatientphones !== null) {
                foreach ($this->collPatientphones as $referrerFK) {
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

        $this->modifiedColumns[PatientTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PatientTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PatientTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(PatientTableMap::COL_FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'first_name';
        }
        if ($this->isColumnModified(PatientTableMap::COL_LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'last_name';
        }
        if ($this->isColumnModified(PatientTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'address';
        }
        if ($this->isColumnModified(PatientTableMap::COL_DATE_OF_BIRTH)) {
            $modifiedColumns[':p' . $index++]  = 'date_of_birth';
        }
        if ($this->isColumnModified(PatientTableMap::COL_INSURANCE)) {
            $modifiedColumns[':p' . $index++]  = 'insurance';
        }
        if ($this->isColumnModified(PatientTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(PatientTableMap::COL_PASSWORD_HASH)) {
            $modifiedColumns[':p' . $index++]  = 'password_hash';
        }
        if ($this->isColumnModified(PatientTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }

        $sql = sprintf(
            'INSERT INTO patient (%s) VALUES (%s)',
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
                    case 'address':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'date_of_birth':
                        $stmt->bindValue($identifier, $this->date_of_birth, PDO::PARAM_STR);
                        break;
                    case 'insurance':
                        $stmt->bindValue($identifier, $this->insurance, PDO::PARAM_STR);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password_hash':
                        $stmt->bindValue($identifier, $this->password_hash, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
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
        $pos = PatientTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAddress();
                break;
            case 4:
                return $this->getDateOfBirth();
                break;
            case 5:
                return $this->getInsurance();
                break;
            case 6:
                return $this->getUsername();
                break;
            case 7:
                return $this->getPasswordHash();
                break;
            case 8:
                return $this->getEmail();
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

        if (isset($alreadyDumpedObjects['Patient'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Patient'][$this->hashCode()] = true;
        $keys = PatientTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFirstName(),
            $keys[2] => $this->getLastName(),
            $keys[3] => $this->getAddress(),
            $keys[4] => $this->getDateOfBirth(),
            $keys[5] => $this->getInsurance(),
            $keys[6] => $this->getUsername(),
            $keys[7] => $this->getPasswordHash(),
            $keys[8] => $this->getEmail(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collHealthhistories) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'healthhistories';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'healthhistories';
                        break;
                    default:
                        $key = 'Healthhistories';
                }

                $result[$key] = $this->collHealthhistories->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPatientphones) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'patientphones';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'patientphones';
                        break;
                    default:
                        $key = 'Patientphones';
                }

                $result[$key] = $this->collPatientphones->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Patient
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PatientTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Patient
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
                $this->setAddress($value);
                break;
            case 4:
                $this->setDateOfBirth($value);
                break;
            case 5:
                $this->setInsurance($value);
                break;
            case 6:
                $this->setUsername($value);
                break;
            case 7:
                $this->setPasswordHash($value);
                break;
            case 8:
                $this->setEmail($value);
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
        $keys = PatientTableMap::getFieldNames($keyType);

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
            $this->setAddress($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDateOfBirth($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setInsurance($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUsername($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPasswordHash($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setEmail($arr[$keys[8]]);
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
     * @return $this|\Patient The current object, for fluid interface
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
        $criteria = new Criteria(PatientTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PatientTableMap::COL_ID)) {
            $criteria->add(PatientTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PatientTableMap::COL_FIRST_NAME)) {
            $criteria->add(PatientTableMap::COL_FIRST_NAME, $this->first_name);
        }
        if ($this->isColumnModified(PatientTableMap::COL_LAST_NAME)) {
            $criteria->add(PatientTableMap::COL_LAST_NAME, $this->last_name);
        }
        if ($this->isColumnModified(PatientTableMap::COL_ADDRESS)) {
            $criteria->add(PatientTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(PatientTableMap::COL_DATE_OF_BIRTH)) {
            $criteria->add(PatientTableMap::COL_DATE_OF_BIRTH, $this->date_of_birth);
        }
        if ($this->isColumnModified(PatientTableMap::COL_INSURANCE)) {
            $criteria->add(PatientTableMap::COL_INSURANCE, $this->insurance);
        }
        if ($this->isColumnModified(PatientTableMap::COL_USERNAME)) {
            $criteria->add(PatientTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(PatientTableMap::COL_PASSWORD_HASH)) {
            $criteria->add(PatientTableMap::COL_PASSWORD_HASH, $this->password_hash);
        }
        if ($this->isColumnModified(PatientTableMap::COL_EMAIL)) {
            $criteria->add(PatientTableMap::COL_EMAIL, $this->email);
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
        $criteria = ChildPatientQuery::create();
        $criteria->add(PatientTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Patient (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setLastName($this->getLastName());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setDateOfBirth($this->getDateOfBirth());
        $copyObj->setInsurance($this->getInsurance());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPasswordHash($this->getPasswordHash());
        $copyObj->setEmail($this->getEmail());

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

            foreach ($this->getHealthhistories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHealthhistory($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPatientphones() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPatientphone($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPrescriptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPrescription($relObj->copy($deepCopy));
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
     * @return \Patient Clone of current object.
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
        if ('Healthhistory' == $relationName) {
            $this->initHealthhistories();
            return;
        }
        if ('Patientphone' == $relationName) {
            $this->initPatientphones();
            return;
        }
        if ('Prescription' == $relationName) {
            $this->initPrescriptions();
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
     * If this ChildPatient is new, it will return
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
                    ->filterByPatient($this)
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
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function setAppointments(Collection $appointments, ConnectionInterface $con = null)
    {
        /** @var ChildAppointment[] $appointmentsToDelete */
        $appointmentsToDelete = $this->getAppointments(new Criteria(), $con)->diff($appointments);


        $this->appointmentsScheduledForDeletion = $appointmentsToDelete;

        foreach ($appointmentsToDelete as $appointmentRemoved) {
            $appointmentRemoved->setPatient(null);
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
                ->filterByPatient($this)
                ->count($con);
        }

        return count($this->collAppointments);
    }

    /**
     * Method called to associate a ChildAppointment object to this object
     * through the ChildAppointment foreign key attribute.
     *
     * @param  ChildAppointment $l ChildAppointment
     * @return $this|\Patient The current object (for fluent API support)
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
        $appointment->setPatient($this);
    }

    /**
     * @param  ChildAppointment $appointment The ChildAppointment object to remove.
     * @return $this|ChildPatient The current object (for fluent API support)
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
            $appointment->setPatient(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Patient is new, it will return
     * an empty collection; or if this Patient has previously
     * been saved, it will retrieve related Appointments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Patient.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAppointment[] List of ChildAppointment objects
     */
    public function getAppointmentsJoinEmployee(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAppointmentQuery::create(null, $criteria);
        $query->joinWith('Employee', $joinBehavior);

        return $this->getAppointments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Patient is new, it will return
     * an empty collection; or if this Patient has previously
     * been saved, it will retrieve related Appointments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Patient.
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
     * If this ChildPatient is new, it will return
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
                    ->filterByPatient($this)
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
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function setBills(Collection $bills, ConnectionInterface $con = null)
    {
        /** @var ChildBill[] $billsToDelete */
        $billsToDelete = $this->getBills(new Criteria(), $con)->diff($bills);


        $this->billsScheduledForDeletion = $billsToDelete;

        foreach ($billsToDelete as $billRemoved) {
            $billRemoved->setPatient(null);
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
                ->filterByPatient($this)
                ->count($con);
        }

        return count($this->collBills);
    }

    /**
     * Method called to associate a ChildBill object to this object
     * through the ChildBill foreign key attribute.
     *
     * @param  ChildBill $l ChildBill
     * @return $this|\Patient The current object (for fluent API support)
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
        $bill->setPatient($this);
    }

    /**
     * @param  ChildBill $bill The ChildBill object to remove.
     * @return $this|ChildPatient The current object (for fluent API support)
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
            $bill->setPatient(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Patient is new, it will return
     * an empty collection; or if this Patient has previously
     * been saved, it will retrieve related Bills from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Patient.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBill[] List of ChildBill objects
     */
    public function getBillsJoinEmployee(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBillQuery::create(null, $criteria);
        $query->joinWith('Employee', $joinBehavior);

        return $this->getBills($query, $con);
    }

    /**
     * Clears out the collHealthhistories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHealthhistories()
     */
    public function clearHealthhistories()
    {
        $this->collHealthhistories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHealthhistories collection loaded partially.
     */
    public function resetPartialHealthhistories($v = true)
    {
        $this->collHealthhistoriesPartial = $v;
    }

    /**
     * Initializes the collHealthhistories collection.
     *
     * By default this just sets the collHealthhistories collection to an empty array (like clearcollHealthhistories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHealthhistories($overrideExisting = true)
    {
        if (null !== $this->collHealthhistories && !$overrideExisting) {
            return;
        }

        $collectionClassName = HealthhistoryTableMap::getTableMap()->getCollectionClassName();

        $this->collHealthhistories = new $collectionClassName;
        $this->collHealthhistories->setModel('\Healthhistory');
    }

    /**
     * Gets an array of ChildHealthhistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPatient is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildHealthhistory[] List of ChildHealthhistory objects
     * @throws PropelException
     */
    public function getHealthhistories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHealthhistoriesPartial && !$this->isNew();
        if (null === $this->collHealthhistories || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHealthhistories) {
                // return empty collection
                $this->initHealthhistories();
            } else {
                $collHealthhistories = ChildHealthhistoryQuery::create(null, $criteria)
                    ->filterByPatient($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHealthhistoriesPartial && count($collHealthhistories)) {
                        $this->initHealthhistories(false);

                        foreach ($collHealthhistories as $obj) {
                            if (false == $this->collHealthhistories->contains($obj)) {
                                $this->collHealthhistories->append($obj);
                            }
                        }

                        $this->collHealthhistoriesPartial = true;
                    }

                    return $collHealthhistories;
                }

                if ($partial && $this->collHealthhistories) {
                    foreach ($this->collHealthhistories as $obj) {
                        if ($obj->isNew()) {
                            $collHealthhistories[] = $obj;
                        }
                    }
                }

                $this->collHealthhistories = $collHealthhistories;
                $this->collHealthhistoriesPartial = false;
            }
        }

        return $this->collHealthhistories;
    }

    /**
     * Sets a collection of ChildHealthhistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $healthhistories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function setHealthhistories(Collection $healthhistories, ConnectionInterface $con = null)
    {
        /** @var ChildHealthhistory[] $healthhistoriesToDelete */
        $healthhistoriesToDelete = $this->getHealthhistories(new Criteria(), $con)->diff($healthhistories);


        $this->healthhistoriesScheduledForDeletion = $healthhistoriesToDelete;

        foreach ($healthhistoriesToDelete as $healthhistoryRemoved) {
            $healthhistoryRemoved->setPatient(null);
        }

        $this->collHealthhistories = null;
        foreach ($healthhistories as $healthhistory) {
            $this->addHealthhistory($healthhistory);
        }

        $this->collHealthhistories = $healthhistories;
        $this->collHealthhistoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Healthhistory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Healthhistory objects.
     * @throws PropelException
     */
    public function countHealthhistories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHealthhistoriesPartial && !$this->isNew();
        if (null === $this->collHealthhistories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHealthhistories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHealthhistories());
            }

            $query = ChildHealthhistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPatient($this)
                ->count($con);
        }

        return count($this->collHealthhistories);
    }

    /**
     * Method called to associate a ChildHealthhistory object to this object
     * through the ChildHealthhistory foreign key attribute.
     *
     * @param  ChildHealthhistory $l ChildHealthhistory
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function addHealthhistory(ChildHealthhistory $l)
    {
        if ($this->collHealthhistories === null) {
            $this->initHealthhistories();
            $this->collHealthhistoriesPartial = true;
        }

        if (!$this->collHealthhistories->contains($l)) {
            $this->doAddHealthhistory($l);

            if ($this->healthhistoriesScheduledForDeletion and $this->healthhistoriesScheduledForDeletion->contains($l)) {
                $this->healthhistoriesScheduledForDeletion->remove($this->healthhistoriesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildHealthhistory $healthhistory The ChildHealthhistory object to add.
     */
    protected function doAddHealthhistory(ChildHealthhistory $healthhistory)
    {
        $this->collHealthhistories[]= $healthhistory;
        $healthhistory->setPatient($this);
    }

    /**
     * @param  ChildHealthhistory $healthhistory The ChildHealthhistory object to remove.
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function removeHealthhistory(ChildHealthhistory $healthhistory)
    {
        if ($this->getHealthhistories()->contains($healthhistory)) {
            $pos = $this->collHealthhistories->search($healthhistory);
            $this->collHealthhistories->remove($pos);
            if (null === $this->healthhistoriesScheduledForDeletion) {
                $this->healthhistoriesScheduledForDeletion = clone $this->collHealthhistories;
                $this->healthhistoriesScheduledForDeletion->clear();
            }
            $this->healthhistoriesScheduledForDeletion[]= clone $healthhistory;
            $healthhistory->setPatient(null);
        }

        return $this;
    }

    /**
     * Clears out the collPatientphones collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPatientphones()
     */
    public function clearPatientphones()
    {
        $this->collPatientphones = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPatientphones collection loaded partially.
     */
    public function resetPartialPatientphones($v = true)
    {
        $this->collPatientphonesPartial = $v;
    }

    /**
     * Initializes the collPatientphones collection.
     *
     * By default this just sets the collPatientphones collection to an empty array (like clearcollPatientphones());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPatientphones($overrideExisting = true)
    {
        if (null !== $this->collPatientphones && !$overrideExisting) {
            return;
        }

        $collectionClassName = PatientphoneTableMap::getTableMap()->getCollectionClassName();

        $this->collPatientphones = new $collectionClassName;
        $this->collPatientphones->setModel('\Patientphone');
    }

    /**
     * Gets an array of ChildPatientphone objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPatient is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPatientphone[] List of ChildPatientphone objects
     * @throws PropelException
     */
    public function getPatientphones(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPatientphonesPartial && !$this->isNew();
        if (null === $this->collPatientphones || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPatientphones) {
                // return empty collection
                $this->initPatientphones();
            } else {
                $collPatientphones = ChildPatientphoneQuery::create(null, $criteria)
                    ->filterByPatient($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPatientphonesPartial && count($collPatientphones)) {
                        $this->initPatientphones(false);

                        foreach ($collPatientphones as $obj) {
                            if (false == $this->collPatientphones->contains($obj)) {
                                $this->collPatientphones->append($obj);
                            }
                        }

                        $this->collPatientphonesPartial = true;
                    }

                    return $collPatientphones;
                }

                if ($partial && $this->collPatientphones) {
                    foreach ($this->collPatientphones as $obj) {
                        if ($obj->isNew()) {
                            $collPatientphones[] = $obj;
                        }
                    }
                }

                $this->collPatientphones = $collPatientphones;
                $this->collPatientphonesPartial = false;
            }
        }

        return $this->collPatientphones;
    }

    /**
     * Sets a collection of ChildPatientphone objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $patientphones A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function setPatientphones(Collection $patientphones, ConnectionInterface $con = null)
    {
        /** @var ChildPatientphone[] $patientphonesToDelete */
        $patientphonesToDelete = $this->getPatientphones(new Criteria(), $con)->diff($patientphones);


        $this->patientphonesScheduledForDeletion = $patientphonesToDelete;

        foreach ($patientphonesToDelete as $patientphoneRemoved) {
            $patientphoneRemoved->setPatient(null);
        }

        $this->collPatientphones = null;
        foreach ($patientphones as $patientphone) {
            $this->addPatientphone($patientphone);
        }

        $this->collPatientphones = $patientphones;
        $this->collPatientphonesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Patientphone objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Patientphone objects.
     * @throws PropelException
     */
    public function countPatientphones(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPatientphonesPartial && !$this->isNew();
        if (null === $this->collPatientphones || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPatientphones) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPatientphones());
            }

            $query = ChildPatientphoneQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPatient($this)
                ->count($con);
        }

        return count($this->collPatientphones);
    }

    /**
     * Method called to associate a ChildPatientphone object to this object
     * through the ChildPatientphone foreign key attribute.
     *
     * @param  ChildPatientphone $l ChildPatientphone
     * @return $this|\Patient The current object (for fluent API support)
     */
    public function addPatientphone(ChildPatientphone $l)
    {
        if ($this->collPatientphones === null) {
            $this->initPatientphones();
            $this->collPatientphonesPartial = true;
        }

        if (!$this->collPatientphones->contains($l)) {
            $this->doAddPatientphone($l);

            if ($this->patientphonesScheduledForDeletion and $this->patientphonesScheduledForDeletion->contains($l)) {
                $this->patientphonesScheduledForDeletion->remove($this->patientphonesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPatientphone $patientphone The ChildPatientphone object to add.
     */
    protected function doAddPatientphone(ChildPatientphone $patientphone)
    {
        $this->collPatientphones[]= $patientphone;
        $patientphone->setPatient($this);
    }

    /**
     * @param  ChildPatientphone $patientphone The ChildPatientphone object to remove.
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function removePatientphone(ChildPatientphone $patientphone)
    {
        if ($this->getPatientphones()->contains($patientphone)) {
            $pos = $this->collPatientphones->search($patientphone);
            $this->collPatientphones->remove($pos);
            if (null === $this->patientphonesScheduledForDeletion) {
                $this->patientphonesScheduledForDeletion = clone $this->collPatientphones;
                $this->patientphonesScheduledForDeletion->clear();
            }
            $this->patientphonesScheduledForDeletion[]= clone $patientphone;
            $patientphone->setPatient(null);
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
     * If this ChildPatient is new, it will return
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
                    ->filterByPatient($this)
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
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function setPrescriptions(Collection $prescriptions, ConnectionInterface $con = null)
    {
        /** @var ChildPrescription[] $prescriptionsToDelete */
        $prescriptionsToDelete = $this->getPrescriptions(new Criteria(), $con)->diff($prescriptions);


        $this->prescriptionsScheduledForDeletion = $prescriptionsToDelete;

        foreach ($prescriptionsToDelete as $prescriptionRemoved) {
            $prescriptionRemoved->setPatient(null);
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
                ->filterByPatient($this)
                ->count($con);
        }

        return count($this->collPrescriptions);
    }

    /**
     * Method called to associate a ChildPrescription object to this object
     * through the ChildPrescription foreign key attribute.
     *
     * @param  ChildPrescription $l ChildPrescription
     * @return $this|\Patient The current object (for fluent API support)
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
        $prescription->setPatient($this);
    }

    /**
     * @param  ChildPrescription $prescription The ChildPrescription object to remove.
     * @return $this|ChildPatient The current object (for fluent API support)
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
            $prescription->setPatient(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Patient is new, it will return
     * an empty collection; or if this Patient has previously
     * been saved, it will retrieve related Prescriptions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Patient.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPrescription[] List of ChildPrescription objects
     */
    public function getPrescriptionsJoinEmployee(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPrescriptionQuery::create(null, $criteria);
        $query->joinWith('Employee', $joinBehavior);

        return $this->getPrescriptions($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->address = null;
        $this->date_of_birth = null;
        $this->insurance = null;
        $this->username = null;
        $this->password_hash = null;
        $this->email = null;
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
            if ($this->collHealthhistories) {
                foreach ($this->collHealthhistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPatientphones) {
                foreach ($this->collPatientphones as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPrescriptions) {
                foreach ($this->collPrescriptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAppointments = null;
        $this->collBills = null;
        $this->collHealthhistories = null;
        $this->collPatientphones = null;
        $this->collPrescriptions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PatientTableMap::DEFAULT_STRING_FORMAT);
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
