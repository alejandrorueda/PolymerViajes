<?php

namespace Base;

use \Mensaje as ChildMensaje;
use \MensajeQuery as ChildMensajeQuery;
use \MensajeRespuesta as ChildMensajeRespuesta;
use \MensajeRespuestaQuery as ChildMensajeRespuestaQuery;
use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \Viaje as ChildViaje;
use \ViajeMensajes as ChildViajeMensajes;
use \ViajeMensajesQuery as ChildViajeMensajesQuery;
use \ViajeQuery as ChildViajeQuery;
use \Exception;
use \PDO;
use Map\MensajeRespuestaTableMap;
use Map\MensajeTableMap;
use Map\ViajeMensajesTableMap;
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
 * Base class that represents a row from the 'mensaje' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class Mensaje implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\MensajeTableMap';


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
     * The value for the idmensaje field.
     * 
     * @var        int
     */
    protected $idmensaje;

    /**
     * The value for the descripcion field.
     * 
     * @var        string
     */
    protected $descripcion;

    /**
     * The value for the asunto field.
     * 
     * @var        string
     */
    protected $asunto;

    /**
     * The value for the idusuario field.
     * 
     * @var        string
     */
    protected $idusuario;

    /**
     * @var        ChildUsuario
     */
    protected $aUsuario;

    /**
     * @var        ObjectCollection|ChildViajeMensajes[] Collection to store aggregation of ChildViajeMensajes objects.
     */
    protected $collViajeMensajess;
    protected $collViajeMensajessPartial;

    /**
     * @var        ObjectCollection|ChildMensajeRespuesta[] Collection to store aggregation of ChildMensajeRespuesta objects.
     */
    protected $collMensajeRespuestasRelatedByIdmensaje;
    protected $collMensajeRespuestasRelatedByIdmensajePartial;

    /**
     * @var        ObjectCollection|ChildMensajeRespuesta[] Collection to store aggregation of ChildMensajeRespuesta objects.
     */
    protected $collMensajeRespuestasRelatedByIdrespuesta;
    protected $collMensajeRespuestasRelatedByIdrespuestaPartial;

    /**
     * @var        ObjectCollection|ChildViaje[] Cross Collection to store aggregation of ChildViaje objects.
     */
    protected $collViajes;

    /**
     * @var bool
     */
    protected $collViajesPartial;

    /**
     * @var        ObjectCollection|ChildMensaje[] Cross Collection to store aggregation of ChildMensaje objects.
     */
    protected $collMensajesRelatedByIdrespuesta;

    /**
     * @var bool
     */
    protected $collMensajesRelatedByIdrespuestaPartial;

    /**
     * @var        ObjectCollection|ChildMensaje[] Cross Collection to store aggregation of ChildMensaje objects.
     */
    protected $collMensajesRelatedByIdmensaje;

    /**
     * @var bool
     */
    protected $collMensajesRelatedByIdmensajePartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildViaje[]
     */
    protected $viajesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMensaje[]
     */
    protected $mensajesRelatedByIdrespuestaScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMensaje[]
     */
    protected $mensajesRelatedByIdmensajeScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildViajeMensajes[]
     */
    protected $viajeMensajessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMensajeRespuesta[]
     */
    protected $mensajeRespuestasRelatedByIdmensajeScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMensajeRespuesta[]
     */
    protected $mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Mensaje object.
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
     * Compares this with another <code>Mensaje</code> instance.  If
     * <code>obj</code> is an instance of <code>Mensaje</code>, delegates to
     * <code>equals(Mensaje)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Mensaje The current object, for fluid interface
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
     * Get the [idmensaje] column value.
     * 
     * @return int
     */
    public function getIdmensaje()
    {
        return $this->idmensaje;
    }

    /**
     * Get the [descripcion] column value.
     * 
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get the [asunto] column value.
     * 
     * @return string
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Get the [idusuario] column value.
     * 
     * @return string
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set the value of [idmensaje] column.
     * 
     * @param int $v new value
     * @return $this|\Mensaje The current object (for fluent API support)
     */
    public function setIdmensaje($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idmensaje !== $v) {
            $this->idmensaje = $v;
            $this->modifiedColumns[MensajeTableMap::COL_IDMENSAJE] = true;
        }

        return $this;
    } // setIdmensaje()

    /**
     * Set the value of [descripcion] column.
     * 
     * @param string $v new value
     * @return $this|\Mensaje The current object (for fluent API support)
     */
    public function setDescripcion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->descripcion !== $v) {
            $this->descripcion = $v;
            $this->modifiedColumns[MensajeTableMap::COL_DESCRIPCION] = true;
        }

        return $this;
    } // setDescripcion()

    /**
     * Set the value of [asunto] column.
     * 
     * @param string $v new value
     * @return $this|\Mensaje The current object (for fluent API support)
     */
    public function setAsunto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->asunto !== $v) {
            $this->asunto = $v;
            $this->modifiedColumns[MensajeTableMap::COL_ASUNTO] = true;
        }

        return $this;
    } // setAsunto()

    /**
     * Set the value of [idusuario] column.
     * 
     * @param string $v new value
     * @return $this|\Mensaje The current object (for fluent API support)
     */
    public function setIdusuario($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->idusuario !== $v) {
            $this->idusuario = $v;
            $this->modifiedColumns[MensajeTableMap::COL_IDUSUARIO] = true;
        }

        if ($this->aUsuario !== null && $this->aUsuario->getIdusuario() !== $v) {
            $this->aUsuario = null;
        }

        return $this;
    } // setIdusuario()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MensajeTableMap::translateFieldName('Idmensaje', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idmensaje = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MensajeTableMap::translateFieldName('Descripcion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->descripcion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MensajeTableMap::translateFieldName('Asunto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->asunto = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MensajeTableMap::translateFieldName('Idusuario', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idusuario = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = MensajeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Mensaje'), 0, $e);
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
        if ($this->aUsuario !== null && $this->idusuario !== $this->aUsuario->getIdusuario()) {
            $this->aUsuario = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(MensajeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMensajeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUsuario = null;
            $this->collViajeMensajess = null;

            $this->collMensajeRespuestasRelatedByIdmensaje = null;

            $this->collMensajeRespuestasRelatedByIdrespuesta = null;

            $this->collViajes = null;
            $this->collMensajesRelatedByIdrespuesta = null;
            $this->collMensajesRelatedByIdmensaje = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Mensaje::setDeleted()
     * @see Mensaje::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MensajeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMensajeQuery::create()
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

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MensajeTableMap::DATABASE_NAME);
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
                MensajeTableMap::addInstanceToPool($this);
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

            if ($this->aUsuario !== null) {
                if ($this->aUsuario->isModified() || $this->aUsuario->isNew()) {
                    $affectedRows += $this->aUsuario->save($con);
                }
                $this->setUsuario($this->aUsuario);
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

            if ($this->viajesScheduledForDeletion !== null) {
                if (!$this->viajesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->viajesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getIdmensaje();
                        $entryPk[0] = $entry->getIdviaje();
                        $pks[] = $entryPk;
                    }

                    \ViajeMensajesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->viajesScheduledForDeletion = null;
                }

            }

            if ($this->collViajes) {
                foreach ($this->collViajes as $viaje) {
                    if (!$viaje->isDeleted() && ($viaje->isNew() || $viaje->isModified())) {
                        $viaje->save($con);
                    }
                }
            }


            if ($this->mensajesRelatedByIdrespuestaScheduledForDeletion !== null) {
                if (!$this->mensajesRelatedByIdrespuestaScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->mensajesRelatedByIdrespuestaScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getIdmensaje();
                        $entryPk[1] = $entry->getIdmensaje();
                        $pks[] = $entryPk;
                    }

                    \MensajeRespuestaQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->mensajesRelatedByIdrespuestaScheduledForDeletion = null;
                }

            }

            if ($this->collMensajesRelatedByIdrespuesta) {
                foreach ($this->collMensajesRelatedByIdrespuesta as $mensajeRelatedByIdrespuesta) {
                    if (!$mensajeRelatedByIdrespuesta->isDeleted() && ($mensajeRelatedByIdrespuesta->isNew() || $mensajeRelatedByIdrespuesta->isModified())) {
                        $mensajeRelatedByIdrespuesta->save($con);
                    }
                }
            }


            if ($this->mensajesRelatedByIdmensajeScheduledForDeletion !== null) {
                if (!$this->mensajesRelatedByIdmensajeScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->mensajesRelatedByIdmensajeScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getIdmensaje();
                        $entryPk[0] = $entry->getIdmensaje();
                        $pks[] = $entryPk;
                    }

                    \MensajeRespuestaQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->mensajesRelatedByIdmensajeScheduledForDeletion = null;
                }

            }

            if ($this->collMensajesRelatedByIdmensaje) {
                foreach ($this->collMensajesRelatedByIdmensaje as $mensajeRelatedByIdmensaje) {
                    if (!$mensajeRelatedByIdmensaje->isDeleted() && ($mensajeRelatedByIdmensaje->isNew() || $mensajeRelatedByIdmensaje->isModified())) {
                        $mensajeRelatedByIdmensaje->save($con);
                    }
                }
            }


            if ($this->viajeMensajessScheduledForDeletion !== null) {
                if (!$this->viajeMensajessScheduledForDeletion->isEmpty()) {
                    \ViajeMensajesQuery::create()
                        ->filterByPrimaryKeys($this->viajeMensajessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->viajeMensajessScheduledForDeletion = null;
                }
            }

            if ($this->collViajeMensajess !== null) {
                foreach ($this->collViajeMensajess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion !== null) {
                if (!$this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion->isEmpty()) {
                    \MensajeRespuestaQuery::create()
                        ->filterByPrimaryKeys($this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion = null;
                }
            }

            if ($this->collMensajeRespuestasRelatedByIdmensaje !== null) {
                foreach ($this->collMensajeRespuestasRelatedByIdmensaje as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion !== null) {
                if (!$this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion->isEmpty()) {
                    \MensajeRespuestaQuery::create()
                        ->filterByPrimaryKeys($this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion = null;
                }
            }

            if ($this->collMensajeRespuestasRelatedByIdrespuesta !== null) {
                foreach ($this->collMensajeRespuestasRelatedByIdrespuesta as $referrerFK) {
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

        $this->modifiedColumns[MensajeTableMap::COL_IDMENSAJE] = true;
        if (null !== $this->idmensaje) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MensajeTableMap::COL_IDMENSAJE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MensajeTableMap::COL_IDMENSAJE)) {
            $modifiedColumns[':p' . $index++]  = 'idmensaje';
        }
        if ($this->isColumnModified(MensajeTableMap::COL_DESCRIPCION)) {
            $modifiedColumns[':p' . $index++]  = 'descripcion';
        }
        if ($this->isColumnModified(MensajeTableMap::COL_ASUNTO)) {
            $modifiedColumns[':p' . $index++]  = 'asunto';
        }
        if ($this->isColumnModified(MensajeTableMap::COL_IDUSUARIO)) {
            $modifiedColumns[':p' . $index++]  = 'idusuario';
        }

        $sql = sprintf(
            'INSERT INTO mensaje (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idmensaje':                        
                        $stmt->bindValue($identifier, $this->idmensaje, PDO::PARAM_INT);
                        break;
                    case 'descripcion':                        
                        $stmt->bindValue($identifier, $this->descripcion, PDO::PARAM_STR);
                        break;
                    case 'asunto':                        
                        $stmt->bindValue($identifier, $this->asunto, PDO::PARAM_STR);
                        break;
                    case 'idusuario':                        
                        $stmt->bindValue($identifier, $this->idusuario, PDO::PARAM_STR);
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
        $this->setIdmensaje($pk);

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
        $pos = MensajeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdmensaje();
                break;
            case 1:
                return $this->getDescripcion();
                break;
            case 2:
                return $this->getAsunto();
                break;
            case 3:
                return $this->getIdusuario();
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

        if (isset($alreadyDumpedObjects['Mensaje'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Mensaje'][$this->hashCode()] = true;
        $keys = MensajeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdmensaje(),
            $keys[1] => $this->getDescripcion(),
            $keys[2] => $this->getAsunto(),
            $keys[3] => $this->getIdusuario(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aUsuario) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'usuario';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'usuario';
                        break;
                    default:
                        $key = 'Usuario';
                }
        
                $result[$key] = $this->aUsuario->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collViajeMensajess) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'viajeMensajess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'viaje_mensajess';
                        break;
                    default:
                        $key = 'ViajeMensajess';
                }
        
                $result[$key] = $this->collViajeMensajess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMensajeRespuestasRelatedByIdmensaje) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mensajeRespuestas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mensaje_respuestas';
                        break;
                    default:
                        $key = 'MensajeRespuestas';
                }
        
                $result[$key] = $this->collMensajeRespuestasRelatedByIdmensaje->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMensajeRespuestasRelatedByIdrespuesta) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mensajeRespuestas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mensaje_respuestas';
                        break;
                    default:
                        $key = 'MensajeRespuestas';
                }
        
                $result[$key] = $this->collMensajeRespuestasRelatedByIdrespuesta->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Mensaje
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MensajeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Mensaje
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdmensaje($value);
                break;
            case 1:
                $this->setDescripcion($value);
                break;
            case 2:
                $this->setAsunto($value);
                break;
            case 3:
                $this->setIdusuario($value);
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
        $keys = MensajeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdmensaje($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDescripcion($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAsunto($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIdusuario($arr[$keys[3]]);
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
     * @return $this|\Mensaje The current object, for fluid interface
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
        $criteria = new Criteria(MensajeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MensajeTableMap::COL_IDMENSAJE)) {
            $criteria->add(MensajeTableMap::COL_IDMENSAJE, $this->idmensaje);
        }
        if ($this->isColumnModified(MensajeTableMap::COL_DESCRIPCION)) {
            $criteria->add(MensajeTableMap::COL_DESCRIPCION, $this->descripcion);
        }
        if ($this->isColumnModified(MensajeTableMap::COL_ASUNTO)) {
            $criteria->add(MensajeTableMap::COL_ASUNTO, $this->asunto);
        }
        if ($this->isColumnModified(MensajeTableMap::COL_IDUSUARIO)) {
            $criteria->add(MensajeTableMap::COL_IDUSUARIO, $this->idusuario);
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
        $criteria = ChildMensajeQuery::create();
        $criteria->add(MensajeTableMap::COL_IDMENSAJE, $this->idmensaje);

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
        $validPk = null !== $this->getIdmensaje();

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
        return $this->getIdmensaje();
    }

    /**
     * Generic method to set the primary key (idmensaje column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdmensaje($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdmensaje();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Mensaje (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDescripcion($this->getDescripcion());
        $copyObj->setAsunto($this->getAsunto());
        $copyObj->setIdusuario($this->getIdusuario());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getViajeMensajess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addViajeMensajes($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMensajeRespuestasRelatedByIdmensaje() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMensajeRespuestaRelatedByIdmensaje($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMensajeRespuestasRelatedByIdrespuesta() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMensajeRespuestaRelatedByIdrespuesta($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdmensaje(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Mensaje Clone of current object.
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
     * Declares an association between this object and a ChildUsuario object.
     *
     * @param  ChildUsuario $v
     * @return $this|\Mensaje The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUsuario(ChildUsuario $v = null)
    {
        if ($v === null) {
            $this->setIdusuario(NULL);
        } else {
            $this->setIdusuario($v->getIdusuario());
        }

        $this->aUsuario = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsuario object, it will not be re-added.
        if ($v !== null) {
            $v->addMensaje($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsuario object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsuario The associated ChildUsuario object.
     * @throws PropelException
     */
    public function getUsuario(ConnectionInterface $con = null)
    {
        if ($this->aUsuario === null && (($this->idusuario !== "" && $this->idusuario !== null))) {
            $this->aUsuario = ChildUsuarioQuery::create()->findPk($this->idusuario, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUsuario->addMensajes($this);
             */
        }

        return $this->aUsuario;
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
        if ('ViajeMensajes' == $relationName) {
            return $this->initViajeMensajess();
        }
        if ('MensajeRespuestaRelatedByIdmensaje' == $relationName) {
            return $this->initMensajeRespuestasRelatedByIdmensaje();
        }
        if ('MensajeRespuestaRelatedByIdrespuesta' == $relationName) {
            return $this->initMensajeRespuestasRelatedByIdrespuesta();
        }
    }

    /**
     * Clears out the collViajeMensajess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addViajeMensajess()
     */
    public function clearViajeMensajess()
    {
        $this->collViajeMensajess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collViajeMensajess collection loaded partially.
     */
    public function resetPartialViajeMensajess($v = true)
    {
        $this->collViajeMensajessPartial = $v;
    }

    /**
     * Initializes the collViajeMensajess collection.
     *
     * By default this just sets the collViajeMensajess collection to an empty array (like clearcollViajeMensajess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initViajeMensajess($overrideExisting = true)
    {
        if (null !== $this->collViajeMensajess && !$overrideExisting) {
            return;
        }

        $collectionClassName = ViajeMensajesTableMap::getTableMap()->getCollectionClassName();

        $this->collViajeMensajess = new $collectionClassName;
        $this->collViajeMensajess->setModel('\ViajeMensajes');
    }

    /**
     * Gets an array of ChildViajeMensajes objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMensaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildViajeMensajes[] List of ChildViajeMensajes objects
     * @throws PropelException
     */
    public function getViajeMensajess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collViajeMensajessPartial && !$this->isNew();
        if (null === $this->collViajeMensajess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collViajeMensajess) {
                // return empty collection
                $this->initViajeMensajess();
            } else {
                $collViajeMensajess = ChildViajeMensajesQuery::create(null, $criteria)
                    ->filterByMensaje($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collViajeMensajessPartial && count($collViajeMensajess)) {
                        $this->initViajeMensajess(false);

                        foreach ($collViajeMensajess as $obj) {
                            if (false == $this->collViajeMensajess->contains($obj)) {
                                $this->collViajeMensajess->append($obj);
                            }
                        }

                        $this->collViajeMensajessPartial = true;
                    }

                    return $collViajeMensajess;
                }

                if ($partial && $this->collViajeMensajess) {
                    foreach ($this->collViajeMensajess as $obj) {
                        if ($obj->isNew()) {
                            $collViajeMensajess[] = $obj;
                        }
                    }
                }

                $this->collViajeMensajess = $collViajeMensajess;
                $this->collViajeMensajessPartial = false;
            }
        }

        return $this->collViajeMensajess;
    }

    /**
     * Sets a collection of ChildViajeMensajes objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $viajeMensajess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function setViajeMensajess(Collection $viajeMensajess, ConnectionInterface $con = null)
    {
        /** @var ChildViajeMensajes[] $viajeMensajessToDelete */
        $viajeMensajessToDelete = $this->getViajeMensajess(new Criteria(), $con)->diff($viajeMensajess);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->viajeMensajessScheduledForDeletion = clone $viajeMensajessToDelete;

        foreach ($viajeMensajessToDelete as $viajeMensajesRemoved) {
            $viajeMensajesRemoved->setMensaje(null);
        }

        $this->collViajeMensajess = null;
        foreach ($viajeMensajess as $viajeMensajes) {
            $this->addViajeMensajes($viajeMensajes);
        }

        $this->collViajeMensajess = $viajeMensajess;
        $this->collViajeMensajessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ViajeMensajes objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ViajeMensajes objects.
     * @throws PropelException
     */
    public function countViajeMensajess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collViajeMensajessPartial && !$this->isNew();
        if (null === $this->collViajeMensajess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collViajeMensajess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getViajeMensajess());
            }

            $query = ChildViajeMensajesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMensaje($this)
                ->count($con);
        }

        return count($this->collViajeMensajess);
    }

    /**
     * Method called to associate a ChildViajeMensajes object to this object
     * through the ChildViajeMensajes foreign key attribute.
     *
     * @param  ChildViajeMensajes $l ChildViajeMensajes
     * @return $this|\Mensaje The current object (for fluent API support)
     */
    public function addViajeMensajes(ChildViajeMensajes $l)
    {
        if ($this->collViajeMensajess === null) {
            $this->initViajeMensajess();
            $this->collViajeMensajessPartial = true;
        }

        if (!$this->collViajeMensajess->contains($l)) {
            $this->doAddViajeMensajes($l);

            if ($this->viajeMensajessScheduledForDeletion and $this->viajeMensajessScheduledForDeletion->contains($l)) {
                $this->viajeMensajessScheduledForDeletion->remove($this->viajeMensajessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildViajeMensajes $viajeMensajes The ChildViajeMensajes object to add.
     */
    protected function doAddViajeMensajes(ChildViajeMensajes $viajeMensajes)
    {
        $this->collViajeMensajess[]= $viajeMensajes;
        $viajeMensajes->setMensaje($this);
    }

    /**
     * @param  ChildViajeMensajes $viajeMensajes The ChildViajeMensajes object to remove.
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function removeViajeMensajes(ChildViajeMensajes $viajeMensajes)
    {
        if ($this->getViajeMensajess()->contains($viajeMensajes)) {
            $pos = $this->collViajeMensajess->search($viajeMensajes);
            $this->collViajeMensajess->remove($pos);
            if (null === $this->viajeMensajessScheduledForDeletion) {
                $this->viajeMensajessScheduledForDeletion = clone $this->collViajeMensajess;
                $this->viajeMensajessScheduledForDeletion->clear();
            }
            $this->viajeMensajessScheduledForDeletion[]= clone $viajeMensajes;
            $viajeMensajes->setMensaje(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Mensaje is new, it will return
     * an empty collection; or if this Mensaje has previously
     * been saved, it will retrieve related ViajeMensajess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Mensaje.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildViajeMensajes[] List of ChildViajeMensajes objects
     */
    public function getViajeMensajessJoinViaje(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildViajeMensajesQuery::create(null, $criteria);
        $query->joinWith('Viaje', $joinBehavior);

        return $this->getViajeMensajess($query, $con);
    }

    /**
     * Clears out the collMensajeRespuestasRelatedByIdmensaje collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMensajeRespuestasRelatedByIdmensaje()
     */
    public function clearMensajeRespuestasRelatedByIdmensaje()
    {
        $this->collMensajeRespuestasRelatedByIdmensaje = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMensajeRespuestasRelatedByIdmensaje collection loaded partially.
     */
    public function resetPartialMensajeRespuestasRelatedByIdmensaje($v = true)
    {
        $this->collMensajeRespuestasRelatedByIdmensajePartial = $v;
    }

    /**
     * Initializes the collMensajeRespuestasRelatedByIdmensaje collection.
     *
     * By default this just sets the collMensajeRespuestasRelatedByIdmensaje collection to an empty array (like clearcollMensajeRespuestasRelatedByIdmensaje());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMensajeRespuestasRelatedByIdmensaje($overrideExisting = true)
    {
        if (null !== $this->collMensajeRespuestasRelatedByIdmensaje && !$overrideExisting) {
            return;
        }

        $collectionClassName = MensajeRespuestaTableMap::getTableMap()->getCollectionClassName();

        $this->collMensajeRespuestasRelatedByIdmensaje = new $collectionClassName;
        $this->collMensajeRespuestasRelatedByIdmensaje->setModel('\MensajeRespuesta');
    }

    /**
     * Gets an array of ChildMensajeRespuesta objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMensaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMensajeRespuesta[] List of ChildMensajeRespuesta objects
     * @throws PropelException
     */
    public function getMensajeRespuestasRelatedByIdmensaje(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajeRespuestasRelatedByIdmensajePartial && !$this->isNew();
        if (null === $this->collMensajeRespuestasRelatedByIdmensaje || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMensajeRespuestasRelatedByIdmensaje) {
                // return empty collection
                $this->initMensajeRespuestasRelatedByIdmensaje();
            } else {
                $collMensajeRespuestasRelatedByIdmensaje = ChildMensajeRespuestaQuery::create(null, $criteria)
                    ->filterByMensajeRelatedByIdmensaje($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMensajeRespuestasRelatedByIdmensajePartial && count($collMensajeRespuestasRelatedByIdmensaje)) {
                        $this->initMensajeRespuestasRelatedByIdmensaje(false);

                        foreach ($collMensajeRespuestasRelatedByIdmensaje as $obj) {
                            if (false == $this->collMensajeRespuestasRelatedByIdmensaje->contains($obj)) {
                                $this->collMensajeRespuestasRelatedByIdmensaje->append($obj);
                            }
                        }

                        $this->collMensajeRespuestasRelatedByIdmensajePartial = true;
                    }

                    return $collMensajeRespuestasRelatedByIdmensaje;
                }

                if ($partial && $this->collMensajeRespuestasRelatedByIdmensaje) {
                    foreach ($this->collMensajeRespuestasRelatedByIdmensaje as $obj) {
                        if ($obj->isNew()) {
                            $collMensajeRespuestasRelatedByIdmensaje[] = $obj;
                        }
                    }
                }

                $this->collMensajeRespuestasRelatedByIdmensaje = $collMensajeRespuestasRelatedByIdmensaje;
                $this->collMensajeRespuestasRelatedByIdmensajePartial = false;
            }
        }

        return $this->collMensajeRespuestasRelatedByIdmensaje;
    }

    /**
     * Sets a collection of ChildMensajeRespuesta objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mensajeRespuestasRelatedByIdmensaje A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function setMensajeRespuestasRelatedByIdmensaje(Collection $mensajeRespuestasRelatedByIdmensaje, ConnectionInterface $con = null)
    {
        /** @var ChildMensajeRespuesta[] $mensajeRespuestasRelatedByIdmensajeToDelete */
        $mensajeRespuestasRelatedByIdmensajeToDelete = $this->getMensajeRespuestasRelatedByIdmensaje(new Criteria(), $con)->diff($mensajeRespuestasRelatedByIdmensaje);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion = clone $mensajeRespuestasRelatedByIdmensajeToDelete;

        foreach ($mensajeRespuestasRelatedByIdmensajeToDelete as $mensajeRespuestaRelatedByIdmensajeRemoved) {
            $mensajeRespuestaRelatedByIdmensajeRemoved->setMensajeRelatedByIdmensaje(null);
        }

        $this->collMensajeRespuestasRelatedByIdmensaje = null;
        foreach ($mensajeRespuestasRelatedByIdmensaje as $mensajeRespuestaRelatedByIdmensaje) {
            $this->addMensajeRespuestaRelatedByIdmensaje($mensajeRespuestaRelatedByIdmensaje);
        }

        $this->collMensajeRespuestasRelatedByIdmensaje = $mensajeRespuestasRelatedByIdmensaje;
        $this->collMensajeRespuestasRelatedByIdmensajePartial = false;

        return $this;
    }

    /**
     * Returns the number of related MensajeRespuesta objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MensajeRespuesta objects.
     * @throws PropelException
     */
    public function countMensajeRespuestasRelatedByIdmensaje(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajeRespuestasRelatedByIdmensajePartial && !$this->isNew();
        if (null === $this->collMensajeRespuestasRelatedByIdmensaje || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMensajeRespuestasRelatedByIdmensaje) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMensajeRespuestasRelatedByIdmensaje());
            }

            $query = ChildMensajeRespuestaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMensajeRelatedByIdmensaje($this)
                ->count($con);
        }

        return count($this->collMensajeRespuestasRelatedByIdmensaje);
    }

    /**
     * Method called to associate a ChildMensajeRespuesta object to this object
     * through the ChildMensajeRespuesta foreign key attribute.
     *
     * @param  ChildMensajeRespuesta $l ChildMensajeRespuesta
     * @return $this|\Mensaje The current object (for fluent API support)
     */
    public function addMensajeRespuestaRelatedByIdmensaje(ChildMensajeRespuesta $l)
    {
        if ($this->collMensajeRespuestasRelatedByIdmensaje === null) {
            $this->initMensajeRespuestasRelatedByIdmensaje();
            $this->collMensajeRespuestasRelatedByIdmensajePartial = true;
        }

        if (!$this->collMensajeRespuestasRelatedByIdmensaje->contains($l)) {
            $this->doAddMensajeRespuestaRelatedByIdmensaje($l);

            if ($this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion and $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion->contains($l)) {
                $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion->remove($this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMensajeRespuesta $mensajeRespuestaRelatedByIdmensaje The ChildMensajeRespuesta object to add.
     */
    protected function doAddMensajeRespuestaRelatedByIdmensaje(ChildMensajeRespuesta $mensajeRespuestaRelatedByIdmensaje)
    {
        $this->collMensajeRespuestasRelatedByIdmensaje[]= $mensajeRespuestaRelatedByIdmensaje;
        $mensajeRespuestaRelatedByIdmensaje->setMensajeRelatedByIdmensaje($this);
    }

    /**
     * @param  ChildMensajeRespuesta $mensajeRespuestaRelatedByIdmensaje The ChildMensajeRespuesta object to remove.
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function removeMensajeRespuestaRelatedByIdmensaje(ChildMensajeRespuesta $mensajeRespuestaRelatedByIdmensaje)
    {
        if ($this->getMensajeRespuestasRelatedByIdmensaje()->contains($mensajeRespuestaRelatedByIdmensaje)) {
            $pos = $this->collMensajeRespuestasRelatedByIdmensaje->search($mensajeRespuestaRelatedByIdmensaje);
            $this->collMensajeRespuestasRelatedByIdmensaje->remove($pos);
            if (null === $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion) {
                $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion = clone $this->collMensajeRespuestasRelatedByIdmensaje;
                $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion->clear();
            }
            $this->mensajeRespuestasRelatedByIdmensajeScheduledForDeletion[]= clone $mensajeRespuestaRelatedByIdmensaje;
            $mensajeRespuestaRelatedByIdmensaje->setMensajeRelatedByIdmensaje(null);
        }

        return $this;
    }

    /**
     * Clears out the collMensajeRespuestasRelatedByIdrespuesta collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMensajeRespuestasRelatedByIdrespuesta()
     */
    public function clearMensajeRespuestasRelatedByIdrespuesta()
    {
        $this->collMensajeRespuestasRelatedByIdrespuesta = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMensajeRespuestasRelatedByIdrespuesta collection loaded partially.
     */
    public function resetPartialMensajeRespuestasRelatedByIdrespuesta($v = true)
    {
        $this->collMensajeRespuestasRelatedByIdrespuestaPartial = $v;
    }

    /**
     * Initializes the collMensajeRespuestasRelatedByIdrespuesta collection.
     *
     * By default this just sets the collMensajeRespuestasRelatedByIdrespuesta collection to an empty array (like clearcollMensajeRespuestasRelatedByIdrespuesta());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMensajeRespuestasRelatedByIdrespuesta($overrideExisting = true)
    {
        if (null !== $this->collMensajeRespuestasRelatedByIdrespuesta && !$overrideExisting) {
            return;
        }

        $collectionClassName = MensajeRespuestaTableMap::getTableMap()->getCollectionClassName();

        $this->collMensajeRespuestasRelatedByIdrespuesta = new $collectionClassName;
        $this->collMensajeRespuestasRelatedByIdrespuesta->setModel('\MensajeRespuesta');
    }

    /**
     * Gets an array of ChildMensajeRespuesta objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMensaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMensajeRespuesta[] List of ChildMensajeRespuesta objects
     * @throws PropelException
     */
    public function getMensajeRespuestasRelatedByIdrespuesta(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajeRespuestasRelatedByIdrespuestaPartial && !$this->isNew();
        if (null === $this->collMensajeRespuestasRelatedByIdrespuesta || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMensajeRespuestasRelatedByIdrespuesta) {
                // return empty collection
                $this->initMensajeRespuestasRelatedByIdrespuesta();
            } else {
                $collMensajeRespuestasRelatedByIdrespuesta = ChildMensajeRespuestaQuery::create(null, $criteria)
                    ->filterByMensajeRelatedByIdrespuesta($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMensajeRespuestasRelatedByIdrespuestaPartial && count($collMensajeRespuestasRelatedByIdrespuesta)) {
                        $this->initMensajeRespuestasRelatedByIdrespuesta(false);

                        foreach ($collMensajeRespuestasRelatedByIdrespuesta as $obj) {
                            if (false == $this->collMensajeRespuestasRelatedByIdrespuesta->contains($obj)) {
                                $this->collMensajeRespuestasRelatedByIdrespuesta->append($obj);
                            }
                        }

                        $this->collMensajeRespuestasRelatedByIdrespuestaPartial = true;
                    }

                    return $collMensajeRespuestasRelatedByIdrespuesta;
                }

                if ($partial && $this->collMensajeRespuestasRelatedByIdrespuesta) {
                    foreach ($this->collMensajeRespuestasRelatedByIdrespuesta as $obj) {
                        if ($obj->isNew()) {
                            $collMensajeRespuestasRelatedByIdrespuesta[] = $obj;
                        }
                    }
                }

                $this->collMensajeRespuestasRelatedByIdrespuesta = $collMensajeRespuestasRelatedByIdrespuesta;
                $this->collMensajeRespuestasRelatedByIdrespuestaPartial = false;
            }
        }

        return $this->collMensajeRespuestasRelatedByIdrespuesta;
    }

    /**
     * Sets a collection of ChildMensajeRespuesta objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mensajeRespuestasRelatedByIdrespuesta A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function setMensajeRespuestasRelatedByIdrespuesta(Collection $mensajeRespuestasRelatedByIdrespuesta, ConnectionInterface $con = null)
    {
        /** @var ChildMensajeRespuesta[] $mensajeRespuestasRelatedByIdrespuestaToDelete */
        $mensajeRespuestasRelatedByIdrespuestaToDelete = $this->getMensajeRespuestasRelatedByIdrespuesta(new Criteria(), $con)->diff($mensajeRespuestasRelatedByIdrespuesta);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion = clone $mensajeRespuestasRelatedByIdrespuestaToDelete;

        foreach ($mensajeRespuestasRelatedByIdrespuestaToDelete as $mensajeRespuestaRelatedByIdrespuestaRemoved) {
            $mensajeRespuestaRelatedByIdrespuestaRemoved->setMensajeRelatedByIdrespuesta(null);
        }

        $this->collMensajeRespuestasRelatedByIdrespuesta = null;
        foreach ($mensajeRespuestasRelatedByIdrespuesta as $mensajeRespuestaRelatedByIdrespuesta) {
            $this->addMensajeRespuestaRelatedByIdrespuesta($mensajeRespuestaRelatedByIdrespuesta);
        }

        $this->collMensajeRespuestasRelatedByIdrespuesta = $mensajeRespuestasRelatedByIdrespuesta;
        $this->collMensajeRespuestasRelatedByIdrespuestaPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MensajeRespuesta objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MensajeRespuesta objects.
     * @throws PropelException
     */
    public function countMensajeRespuestasRelatedByIdrespuesta(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajeRespuestasRelatedByIdrespuestaPartial && !$this->isNew();
        if (null === $this->collMensajeRespuestasRelatedByIdrespuesta || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMensajeRespuestasRelatedByIdrespuesta) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMensajeRespuestasRelatedByIdrespuesta());
            }

            $query = ChildMensajeRespuestaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMensajeRelatedByIdrespuesta($this)
                ->count($con);
        }

        return count($this->collMensajeRespuestasRelatedByIdrespuesta);
    }

    /**
     * Method called to associate a ChildMensajeRespuesta object to this object
     * through the ChildMensajeRespuesta foreign key attribute.
     *
     * @param  ChildMensajeRespuesta $l ChildMensajeRespuesta
     * @return $this|\Mensaje The current object (for fluent API support)
     */
    public function addMensajeRespuestaRelatedByIdrespuesta(ChildMensajeRespuesta $l)
    {
        if ($this->collMensajeRespuestasRelatedByIdrespuesta === null) {
            $this->initMensajeRespuestasRelatedByIdrespuesta();
            $this->collMensajeRespuestasRelatedByIdrespuestaPartial = true;
        }

        if (!$this->collMensajeRespuestasRelatedByIdrespuesta->contains($l)) {
            $this->doAddMensajeRespuestaRelatedByIdrespuesta($l);

            if ($this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion and $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion->contains($l)) {
                $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion->remove($this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMensajeRespuesta $mensajeRespuestaRelatedByIdrespuesta The ChildMensajeRespuesta object to add.
     */
    protected function doAddMensajeRespuestaRelatedByIdrespuesta(ChildMensajeRespuesta $mensajeRespuestaRelatedByIdrespuesta)
    {
        $this->collMensajeRespuestasRelatedByIdrespuesta[]= $mensajeRespuestaRelatedByIdrespuesta;
        $mensajeRespuestaRelatedByIdrespuesta->setMensajeRelatedByIdrespuesta($this);
    }

    /**
     * @param  ChildMensajeRespuesta $mensajeRespuestaRelatedByIdrespuesta The ChildMensajeRespuesta object to remove.
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function removeMensajeRespuestaRelatedByIdrespuesta(ChildMensajeRespuesta $mensajeRespuestaRelatedByIdrespuesta)
    {
        if ($this->getMensajeRespuestasRelatedByIdrespuesta()->contains($mensajeRespuestaRelatedByIdrespuesta)) {
            $pos = $this->collMensajeRespuestasRelatedByIdrespuesta->search($mensajeRespuestaRelatedByIdrespuesta);
            $this->collMensajeRespuestasRelatedByIdrespuesta->remove($pos);
            if (null === $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion) {
                $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion = clone $this->collMensajeRespuestasRelatedByIdrespuesta;
                $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion->clear();
            }
            $this->mensajeRespuestasRelatedByIdrespuestaScheduledForDeletion[]= clone $mensajeRespuestaRelatedByIdrespuesta;
            $mensajeRespuestaRelatedByIdrespuesta->setMensajeRelatedByIdrespuesta(null);
        }

        return $this;
    }

    /**
     * Clears out the collViajes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addViajes()
     */
    public function clearViajes()
    {
        $this->collViajes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collViajes crossRef collection.
     *
     * By default this just sets the collViajes collection to an empty collection (like clearViajes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initViajes()
    {
        $collectionClassName = ViajeMensajesTableMap::getTableMap()->getCollectionClassName();

        $this->collViajes = new $collectionClassName;
        $this->collViajesPartial = true;
        $this->collViajes->setModel('\Viaje');
    }

    /**
     * Checks if the collViajes collection is loaded.
     *
     * @return bool
     */
    public function isViajesLoaded()
    {
        return null !== $this->collViajes;
    }

    /**
     * Gets a collection of ChildViaje objects related by a many-to-many relationship
     * to the current object by way of the viaje_mensajes cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMensaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildViaje[] List of ChildViaje objects
     */
    public function getViajes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collViajesPartial && !$this->isNew();
        if (null === $this->collViajes || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collViajes) {
                    $this->initViajes();
                }
            } else {

                $query = ChildViajeQuery::create(null, $criteria)
                    ->filterByMensaje($this);
                $collViajes = $query->find($con);
                if (null !== $criteria) {
                    return $collViajes;
                }

                if ($partial && $this->collViajes) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collViajes as $obj) {
                        if (!$collViajes->contains($obj)) {
                            $collViajes[] = $obj;
                        }
                    }
                }

                $this->collViajes = $collViajes;
                $this->collViajesPartial = false;
            }
        }

        return $this->collViajes;
    }

    /**
     * Sets a collection of Viaje objects related by a many-to-many relationship
     * to the current object by way of the viaje_mensajes cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $viajes A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function setViajes(Collection $viajes, ConnectionInterface $con = null)
    {
        $this->clearViajes();
        $currentViajes = $this->getViajes();

        $viajesScheduledForDeletion = $currentViajes->diff($viajes);

        foreach ($viajesScheduledForDeletion as $toDelete) {
            $this->removeViaje($toDelete);
        }

        foreach ($viajes as $viaje) {
            if (!$currentViajes->contains($viaje)) {
                $this->doAddViaje($viaje);
            }
        }

        $this->collViajesPartial = false;
        $this->collViajes = $viajes;

        return $this;
    }

    /**
     * Gets the number of Viaje objects related by a many-to-many relationship
     * to the current object by way of the viaje_mensajes cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Viaje objects
     */
    public function countViajes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collViajesPartial && !$this->isNew();
        if (null === $this->collViajes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collViajes) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getViajes());
                }

                $query = ChildViajeQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByMensaje($this)
                    ->count($con);
            }
        } else {
            return count($this->collViajes);
        }
    }

    /**
     * Associate a ChildViaje to this object
     * through the viaje_mensajes cross reference table.
     * 
     * @param ChildViaje $viaje
     * @return ChildMensaje The current object (for fluent API support)
     */
    public function addViaje(ChildViaje $viaje)
    {
        if ($this->collViajes === null) {
            $this->initViajes();
        }

        if (!$this->getViajes()->contains($viaje)) {
            // only add it if the **same** object is not already associated
            $this->collViajes->push($viaje);
            $this->doAddViaje($viaje);
        }

        return $this;
    }

    /**
     * 
     * @param ChildViaje $viaje
     */
    protected function doAddViaje(ChildViaje $viaje)
    {
        $viajeMensajes = new ChildViajeMensajes();

        $viajeMensajes->setViaje($viaje);

        $viajeMensajes->setMensaje($this);

        $this->addViajeMensajes($viajeMensajes);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$viaje->isMensajesLoaded()) {
            $viaje->initMensajes();
            $viaje->getMensajes()->push($this);
        } elseif (!$viaje->getMensajes()->contains($this)) {
            $viaje->getMensajes()->push($this);
        }

    }

    /**
     * Remove viaje of this object
     * through the viaje_mensajes cross reference table.
     * 
     * @param ChildViaje $viaje
     * @return ChildMensaje The current object (for fluent API support)
     */
    public function removeViaje(ChildViaje $viaje)
    {
        if ($this->getViajes()->contains($viaje)) { $viajeMensajes = new ChildViajeMensajes();

            $viajeMensajes->setViaje($viaje);
            if ($viaje->isMensajesLoaded()) {
                //remove the back reference if available
                $viaje->getMensajes()->removeObject($this);
            }

            $viajeMensajes->setMensaje($this);
            $this->removeViajeMensajes(clone $viajeMensajes);
            $viajeMensajes->clear();

            $this->collViajes->remove($this->collViajes->search($viaje));
            
            if (null === $this->viajesScheduledForDeletion) {
                $this->viajesScheduledForDeletion = clone $this->collViajes;
                $this->viajesScheduledForDeletion->clear();
            }

            $this->viajesScheduledForDeletion->push($viaje);
        }


        return $this;
    }

    /**
     * Clears out the collMensajesRelatedByIdrespuesta collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMensajesRelatedByIdrespuesta()
     */
    public function clearMensajesRelatedByIdrespuesta()
    {
        $this->collMensajesRelatedByIdrespuesta = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collMensajesRelatedByIdrespuesta crossRef collection.
     *
     * By default this just sets the collMensajesRelatedByIdrespuesta collection to an empty collection (like clearMensajesRelatedByIdrespuesta());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initMensajesRelatedByIdrespuesta()
    {
        $collectionClassName = MensajeRespuestaTableMap::getTableMap()->getCollectionClassName();

        $this->collMensajesRelatedByIdrespuesta = new $collectionClassName;
        $this->collMensajesRelatedByIdrespuestaPartial = true;
        $this->collMensajesRelatedByIdrespuesta->setModel('\Mensaje');
    }

    /**
     * Checks if the collMensajesRelatedByIdrespuesta collection is loaded.
     *
     * @return bool
     */
    public function isMensajesRelatedByIdrespuestaLoaded()
    {
        return null !== $this->collMensajesRelatedByIdrespuesta;
    }

    /**
     * Gets a collection of ChildMensaje objects related by a many-to-many relationship
     * to the current object by way of the mensaje_respuesta cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMensaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildMensaje[] List of ChildMensaje objects
     */
    public function getMensajesRelatedByIdrespuesta(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesRelatedByIdrespuestaPartial && !$this->isNew();
        if (null === $this->collMensajesRelatedByIdrespuesta || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collMensajesRelatedByIdrespuesta) {
                    $this->initMensajesRelatedByIdrespuesta();
                }
            } else {

                $query = ChildMensajeQuery::create(null, $criteria)
                    ->filterByMensajeRelatedByIdmensaje($this);
                $collMensajesRelatedByIdrespuesta = $query->find($con);
                if (null !== $criteria) {
                    return $collMensajesRelatedByIdrespuesta;
                }

                if ($partial && $this->collMensajesRelatedByIdrespuesta) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collMensajesRelatedByIdrespuesta as $obj) {
                        if (!$collMensajesRelatedByIdrespuesta->contains($obj)) {
                            $collMensajesRelatedByIdrespuesta[] = $obj;
                        }
                    }
                }

                $this->collMensajesRelatedByIdrespuesta = $collMensajesRelatedByIdrespuesta;
                $this->collMensajesRelatedByIdrespuestaPartial = false;
            }
        }

        return $this->collMensajesRelatedByIdrespuesta;
    }

    /**
     * Sets a collection of Mensaje objects related by a many-to-many relationship
     * to the current object by way of the mensaje_respuesta cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $mensajesRelatedByIdrespuesta A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function setMensajesRelatedByIdrespuesta(Collection $mensajesRelatedByIdrespuesta, ConnectionInterface $con = null)
    {
        $this->clearMensajesRelatedByIdrespuesta();
        $currentMensajesRelatedByIdrespuesta = $this->getMensajesRelatedByIdrespuesta();

        $mensajesRelatedByIdrespuestaScheduledForDeletion = $currentMensajesRelatedByIdrespuesta->diff($mensajesRelatedByIdrespuesta);

        foreach ($mensajesRelatedByIdrespuestaScheduledForDeletion as $toDelete) {
            $this->removeMensajeRelatedByIdrespuesta($toDelete);
        }

        foreach ($mensajesRelatedByIdrespuesta as $mensajeRelatedByIdrespuesta) {
            if (!$currentMensajesRelatedByIdrespuesta->contains($mensajeRelatedByIdrespuesta)) {
                $this->doAddMensajeRelatedByIdrespuesta($mensajeRelatedByIdrespuesta);
            }
        }

        $this->collMensajesRelatedByIdrespuestaPartial = false;
        $this->collMensajesRelatedByIdrespuesta = $mensajesRelatedByIdrespuesta;

        return $this;
    }

    /**
     * Gets the number of Mensaje objects related by a many-to-many relationship
     * to the current object by way of the mensaje_respuesta cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Mensaje objects
     */
    public function countMensajesRelatedByIdrespuesta(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesRelatedByIdrespuestaPartial && !$this->isNew();
        if (null === $this->collMensajesRelatedByIdrespuesta || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMensajesRelatedByIdrespuesta) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getMensajesRelatedByIdrespuesta());
                }

                $query = ChildMensajeQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByMensajeRelatedByIdmensaje($this)
                    ->count($con);
            }
        } else {
            return count($this->collMensajesRelatedByIdrespuesta);
        }
    }

    /**
     * Associate a ChildMensaje to this object
     * through the mensaje_respuesta cross reference table.
     * 
     * @param ChildMensaje $mensajeRelatedByIdrespuesta
     * @return ChildMensaje The current object (for fluent API support)
     */
    public function addMensajeRelatedByIdrespuesta(ChildMensaje $mensajeRelatedByIdrespuesta)
    {
        if ($this->collMensajesRelatedByIdrespuesta === null) {
            $this->initMensajesRelatedByIdrespuesta();
        }

        if (!$this->getMensajesRelatedByIdrespuesta()->contains($mensajeRelatedByIdrespuesta)) {
            // only add it if the **same** object is not already associated
            $this->collMensajesRelatedByIdrespuesta->push($mensajeRelatedByIdrespuesta);
            $this->doAddMensajeRelatedByIdrespuesta($mensajeRelatedByIdrespuesta);
        }

        return $this;
    }

    /**
     * 
     * @param ChildMensaje $mensajeRelatedByIdrespuesta
     */
    protected function doAddMensajeRelatedByIdrespuesta(ChildMensaje $mensajeRelatedByIdrespuesta)
    {
        $mensajeRespuesta = new ChildMensajeRespuesta();

        $mensajeRespuesta->setMensajeRelatedByIdrespuesta($mensajeRelatedByIdrespuesta);

        $mensajeRespuesta->setMensajeRelatedByIdmensaje($this);

        $this->addMensajeRespuestaRelatedByIdmensaje($mensajeRespuesta);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$mensajeRelatedByIdrespuesta->isMensajesRelatedByIdmensajeLoaded()) {
            $mensajeRelatedByIdrespuesta->initMensajesRelatedByIdmensaje();
            $mensajeRelatedByIdrespuesta->getMensajesRelatedByIdmensaje()->push($this);
        } elseif (!$mensajeRelatedByIdrespuesta->getMensajesRelatedByIdmensaje()->contains($this)) {
            $mensajeRelatedByIdrespuesta->getMensajesRelatedByIdmensaje()->push($this);
        }

    }

    /**
     * Remove mensajeRelatedByIdrespuesta of this object
     * through the mensaje_respuesta cross reference table.
     * 
     * @param ChildMensaje $mensajeRelatedByIdrespuesta
     * @return ChildMensaje The current object (for fluent API support)
     */
    public function removeMensajeRelatedByIdrespuesta(ChildMensaje $mensajeRelatedByIdrespuesta)
    {
        if ($this->getMensajesRelatedByIdrespuesta()->contains($mensajeRelatedByIdrespuesta)) { $mensajeRespuesta = new ChildMensajeRespuesta();

            $mensajeRespuesta->setMensajeRelatedByIdrespuesta($mensajeRelatedByIdrespuesta);
            if ($mensajeRelatedByIdrespuesta->isMensajeRelatedByIdmensajesLoaded()) {
                //remove the back reference if available
                $mensajeRelatedByIdrespuesta->getMensajeRelatedByIdmensajes()->removeObject($this);
            }

            $mensajeRespuesta->setMensajeRelatedByIdmensaje($this);
            $this->removeMensajeRespuestaRelatedByIdmensaje(clone $mensajeRespuesta);
            $mensajeRespuesta->clear();

            $this->collMensajesRelatedByIdrespuesta->remove($this->collMensajesRelatedByIdrespuesta->search($mensajeRelatedByIdrespuesta));
            
            if (null === $this->mensajesRelatedByIdrespuestaScheduledForDeletion) {
                $this->mensajesRelatedByIdrespuestaScheduledForDeletion = clone $this->collMensajesRelatedByIdrespuesta;
                $this->mensajesRelatedByIdrespuestaScheduledForDeletion->clear();
            }

            $this->mensajesRelatedByIdrespuestaScheduledForDeletion->push($mensajeRelatedByIdrespuesta);
        }


        return $this;
    }

    /**
     * Clears out the collMensajesRelatedByIdmensaje collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMensajesRelatedByIdmensaje()
     */
    public function clearMensajesRelatedByIdmensaje()
    {
        $this->collMensajesRelatedByIdmensaje = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collMensajesRelatedByIdmensaje crossRef collection.
     *
     * By default this just sets the collMensajesRelatedByIdmensaje collection to an empty collection (like clearMensajesRelatedByIdmensaje());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initMensajesRelatedByIdmensaje()
    {
        $collectionClassName = MensajeRespuestaTableMap::getTableMap()->getCollectionClassName();

        $this->collMensajesRelatedByIdmensaje = new $collectionClassName;
        $this->collMensajesRelatedByIdmensajePartial = true;
        $this->collMensajesRelatedByIdmensaje->setModel('\Mensaje');
    }

    /**
     * Checks if the collMensajesRelatedByIdmensaje collection is loaded.
     *
     * @return bool
     */
    public function isMensajesRelatedByIdmensajeLoaded()
    {
        return null !== $this->collMensajesRelatedByIdmensaje;
    }

    /**
     * Gets a collection of ChildMensaje objects related by a many-to-many relationship
     * to the current object by way of the mensaje_respuesta cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMensaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildMensaje[] List of ChildMensaje objects
     */
    public function getMensajesRelatedByIdmensaje(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesRelatedByIdmensajePartial && !$this->isNew();
        if (null === $this->collMensajesRelatedByIdmensaje || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collMensajesRelatedByIdmensaje) {
                    $this->initMensajesRelatedByIdmensaje();
                }
            } else {

                $query = ChildMensajeQuery::create(null, $criteria)
                    ->filterByMensajeRelatedByIdrespuesta($this);
                $collMensajesRelatedByIdmensaje = $query->find($con);
                if (null !== $criteria) {
                    return $collMensajesRelatedByIdmensaje;
                }

                if ($partial && $this->collMensajesRelatedByIdmensaje) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collMensajesRelatedByIdmensaje as $obj) {
                        if (!$collMensajesRelatedByIdmensaje->contains($obj)) {
                            $collMensajesRelatedByIdmensaje[] = $obj;
                        }
                    }
                }

                $this->collMensajesRelatedByIdmensaje = $collMensajesRelatedByIdmensaje;
                $this->collMensajesRelatedByIdmensajePartial = false;
            }
        }

        return $this->collMensajesRelatedByIdmensaje;
    }

    /**
     * Sets a collection of Mensaje objects related by a many-to-many relationship
     * to the current object by way of the mensaje_respuesta cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $mensajesRelatedByIdmensaje A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMensaje The current object (for fluent API support)
     */
    public function setMensajesRelatedByIdmensaje(Collection $mensajesRelatedByIdmensaje, ConnectionInterface $con = null)
    {
        $this->clearMensajesRelatedByIdmensaje();
        $currentMensajesRelatedByIdmensaje = $this->getMensajesRelatedByIdmensaje();

        $mensajesRelatedByIdmensajeScheduledForDeletion = $currentMensajesRelatedByIdmensaje->diff($mensajesRelatedByIdmensaje);

        foreach ($mensajesRelatedByIdmensajeScheduledForDeletion as $toDelete) {
            $this->removeMensajeRelatedByIdmensaje($toDelete);
        }

        foreach ($mensajesRelatedByIdmensaje as $mensajeRelatedByIdmensaje) {
            if (!$currentMensajesRelatedByIdmensaje->contains($mensajeRelatedByIdmensaje)) {
                $this->doAddMensajeRelatedByIdmensaje($mensajeRelatedByIdmensaje);
            }
        }

        $this->collMensajesRelatedByIdmensajePartial = false;
        $this->collMensajesRelatedByIdmensaje = $mensajesRelatedByIdmensaje;

        return $this;
    }

    /**
     * Gets the number of Mensaje objects related by a many-to-many relationship
     * to the current object by way of the mensaje_respuesta cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Mensaje objects
     */
    public function countMensajesRelatedByIdmensaje(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesRelatedByIdmensajePartial && !$this->isNew();
        if (null === $this->collMensajesRelatedByIdmensaje || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMensajesRelatedByIdmensaje) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getMensajesRelatedByIdmensaje());
                }

                $query = ChildMensajeQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByMensajeRelatedByIdrespuesta($this)
                    ->count($con);
            }
        } else {
            return count($this->collMensajesRelatedByIdmensaje);
        }
    }

    /**
     * Associate a ChildMensaje to this object
     * through the mensaje_respuesta cross reference table.
     * 
     * @param ChildMensaje $mensajeRelatedByIdmensaje
     * @return ChildMensaje The current object (for fluent API support)
     */
    public function addMensajeRelatedByIdmensaje(ChildMensaje $mensajeRelatedByIdmensaje)
    {
        if ($this->collMensajesRelatedByIdmensaje === null) {
            $this->initMensajesRelatedByIdmensaje();
        }

        if (!$this->getMensajesRelatedByIdmensaje()->contains($mensajeRelatedByIdmensaje)) {
            // only add it if the **same** object is not already associated
            $this->collMensajesRelatedByIdmensaje->push($mensajeRelatedByIdmensaje);
            $this->doAddMensajeRelatedByIdmensaje($mensajeRelatedByIdmensaje);
        }

        return $this;
    }

    /**
     * 
     * @param ChildMensaje $mensajeRelatedByIdmensaje
     */
    protected function doAddMensajeRelatedByIdmensaje(ChildMensaje $mensajeRelatedByIdmensaje)
    {
        $mensajeRespuesta = new ChildMensajeRespuesta();

        $mensajeRespuesta->setMensajeRelatedByIdmensaje($mensajeRelatedByIdmensaje);

        $mensajeRespuesta->setMensajeRelatedByIdrespuesta($this);

        $this->addMensajeRespuestaRelatedByIdrespuesta($mensajeRespuesta);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$mensajeRelatedByIdmensaje->isMensajesRelatedByIdrespuestaLoaded()) {
            $mensajeRelatedByIdmensaje->initMensajesRelatedByIdrespuesta();
            $mensajeRelatedByIdmensaje->getMensajesRelatedByIdrespuesta()->push($this);
        } elseif (!$mensajeRelatedByIdmensaje->getMensajesRelatedByIdrespuesta()->contains($this)) {
            $mensajeRelatedByIdmensaje->getMensajesRelatedByIdrespuesta()->push($this);
        }

    }

    /**
     * Remove mensajeRelatedByIdmensaje of this object
     * through the mensaje_respuesta cross reference table.
     * 
     * @param ChildMensaje $mensajeRelatedByIdmensaje
     * @return ChildMensaje The current object (for fluent API support)
     */
    public function removeMensajeRelatedByIdmensaje(ChildMensaje $mensajeRelatedByIdmensaje)
    {
        if ($this->getMensajesRelatedByIdmensaje()->contains($mensajeRelatedByIdmensaje)) { $mensajeRespuesta = new ChildMensajeRespuesta();

            $mensajeRespuesta->setMensajeRelatedByIdmensaje($mensajeRelatedByIdmensaje);
            if ($mensajeRelatedByIdmensaje->isMensajeRelatedByIdrespuestasLoaded()) {
                //remove the back reference if available
                $mensajeRelatedByIdmensaje->getMensajeRelatedByIdrespuestas()->removeObject($this);
            }

            $mensajeRespuesta->setMensajeRelatedByIdrespuesta($this);
            $this->removeMensajeRespuestaRelatedByIdrespuesta(clone $mensajeRespuesta);
            $mensajeRespuesta->clear();

            $this->collMensajesRelatedByIdmensaje->remove($this->collMensajesRelatedByIdmensaje->search($mensajeRelatedByIdmensaje));
            
            if (null === $this->mensajesRelatedByIdmensajeScheduledForDeletion) {
                $this->mensajesRelatedByIdmensajeScheduledForDeletion = clone $this->collMensajesRelatedByIdmensaje;
                $this->mensajesRelatedByIdmensajeScheduledForDeletion->clear();
            }

            $this->mensajesRelatedByIdmensajeScheduledForDeletion->push($mensajeRelatedByIdmensaje);
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
        if (null !== $this->aUsuario) {
            $this->aUsuario->removeMensaje($this);
        }
        $this->idmensaje = null;
        $this->descripcion = null;
        $this->asunto = null;
        $this->idusuario = null;
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
            if ($this->collViajeMensajess) {
                foreach ($this->collViajeMensajess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMensajeRespuestasRelatedByIdmensaje) {
                foreach ($this->collMensajeRespuestasRelatedByIdmensaje as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMensajeRespuestasRelatedByIdrespuesta) {
                foreach ($this->collMensajeRespuestasRelatedByIdrespuesta as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collViajes) {
                foreach ($this->collViajes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMensajesRelatedByIdrespuesta) {
                foreach ($this->collMensajesRelatedByIdrespuesta as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMensajesRelatedByIdmensaje) {
                foreach ($this->collMensajesRelatedByIdmensaje as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collViajeMensajess = null;
        $this->collMensajeRespuestasRelatedByIdmensaje = null;
        $this->collMensajeRespuestasRelatedByIdrespuesta = null;
        $this->collViajes = null;
        $this->collMensajesRelatedByIdrespuesta = null;
        $this->collMensajesRelatedByIdmensaje = null;
        $this->aUsuario = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MensajeTableMap::DEFAULT_STRING_FORMAT);
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
