<?php

namespace Base;

use \Grupo as ChildGrupo;
use \GrupoQuery as ChildGrupoQuery;
use \Invitacion as ChildInvitacion;
use \InvitacionQuery as ChildInvitacionQuery;
use \Mensaje as ChildMensaje;
use \MensajeQuery as ChildMensajeQuery;
use \MiembrosGrupo as ChildMiembrosGrupo;
use \MiembrosGrupoQuery as ChildMiembrosGrupoQuery;
use \Perfil as ChildPerfil;
use \PerfilQuery as ChildPerfilQuery;
use \Usuario as ChildUsuario;
use \UsuarioAmigo as ChildUsuarioAmigo;
use \UsuarioAmigoQuery as ChildUsuarioAmigoQuery;
use \UsuarioQuery as ChildUsuarioQuery;
use \Viaje as ChildViaje;
use \ViajeQuery as ChildViajeQuery;
use \ViajeUsuario as ChildViajeUsuario;
use \ViajeUsuarioQuery as ChildViajeUsuarioQuery;
use \Exception;
use \PDO;
use Map\InvitacionTableMap;
use Map\MensajeTableMap;
use Map\MiembrosGrupoTableMap;
use Map\UsuarioAmigoTableMap;
use Map\UsuarioTableMap;
use Map\ViajeUsuarioTableMap;
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
 * Base class that represents a row from the 'usuario' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class Usuario implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UsuarioTableMap';


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
     * The value for the idusuario field.
     * 
     * @var        string
     */
    protected $idusuario;

    /**
     * The value for the password field.
     * 
     * @var        string
     */
    protected $password;

    /**
     * The value for the nombre field.
     * 
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the apellidos field.
     * 
     * @var        string
     */
    protected $apellidos;

    /**
     * The value for the avatar field.
     * 
     * @var        string
     */
    protected $avatar;

    /**
     * The value for the email field.
     * 
     * @var        string
     */
    protected $email;

    /**
     * The value for the idperfil field.
     * 
     * @var        int
     */
    protected $idperfil;

    /**
     * @var        ChildPerfil
     */
    protected $aPerfil;

    /**
     * @var        ObjectCollection|ChildInvitacion[] Collection to store aggregation of ChildInvitacion objects.
     */
    protected $collInvitacions;
    protected $collInvitacionsPartial;

    /**
     * @var        ObjectCollection|ChildUsuarioAmigo[] Collection to store aggregation of ChildUsuarioAmigo objects.
     */
    protected $collUsuarioAmigosRelatedByIdusuario;
    protected $collUsuarioAmigosRelatedByIdusuarioPartial;

    /**
     * @var        ObjectCollection|ChildUsuarioAmigo[] Collection to store aggregation of ChildUsuarioAmigo objects.
     */
    protected $collUsuarioAmigosRelatedByIdamigo;
    protected $collUsuarioAmigosRelatedByIdamigoPartial;

    /**
     * @var        ObjectCollection|ChildMiembrosGrupo[] Collection to store aggregation of ChildMiembrosGrupo objects.
     */
    protected $collMiembrosGrupos;
    protected $collMiembrosGruposPartial;

    /**
     * @var        ObjectCollection|ChildViajeUsuario[] Collection to store aggregation of ChildViajeUsuario objects.
     */
    protected $collViajeUsuarios;
    protected $collViajeUsuariosPartial;

    /**
     * @var        ObjectCollection|ChildMensaje[] Collection to store aggregation of ChildMensaje objects.
     */
    protected $collMensajes;
    protected $collMensajesPartial;

    /**
     * @var        ObjectCollection|ChildUsuario[] Cross Collection to store aggregation of ChildUsuario objects.
     */
    protected $collUsuariosRelatedByIdamigo;

    /**
     * @var bool
     */
    protected $collUsuariosRelatedByIdamigoPartial;

    /**
     * @var        ObjectCollection|ChildUsuario[] Cross Collection to store aggregation of ChildUsuario objects.
     */
    protected $collUsuariosRelatedByIdusuario;

    /**
     * @var bool
     */
    protected $collUsuariosRelatedByIdusuarioPartial;

    /**
     * @var        ObjectCollection|ChildGrupo[] Cross Collection to store aggregation of ChildGrupo objects.
     */
    protected $collGrupos;

    /**
     * @var bool
     */
    protected $collGruposPartial;

    /**
     * @var        ObjectCollection|ChildViaje[] Cross Collection to store aggregation of ChildViaje objects.
     */
    protected $collViajes;

    /**
     * @var bool
     */
    protected $collViajesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUsuario[]
     */
    protected $usuariosRelatedByIdamigoScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUsuario[]
     */
    protected $usuariosRelatedByIdusuarioScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGrupo[]
     */
    protected $gruposScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildViaje[]
     */
    protected $viajesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInvitacion[]
     */
    protected $invitacionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUsuarioAmigo[]
     */
    protected $usuarioAmigosRelatedByIdusuarioScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUsuarioAmigo[]
     */
    protected $usuarioAmigosRelatedByIdamigoScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMiembrosGrupo[]
     */
    protected $miembrosGruposScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildViajeUsuario[]
     */
    protected $viajeUsuariosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMensaje[]
     */
    protected $mensajesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Usuario object.
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
     * Compares this with another <code>Usuario</code> instance.  If
     * <code>obj</code> is an instance of <code>Usuario</code>, delegates to
     * <code>equals(Usuario)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Usuario The current object, for fluid interface
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
     * Get the [idusuario] column value.
     * 
     * @return string
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Get the [password] column value.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [nombre] column value.
     * 
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the [apellidos] column value.
     * 
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Get the [avatar] column value.
     * 
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
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
     * Get the [idperfil] column value.
     * 
     * @return int
     */
    public function getIdperfil()
    {
        return $this->idperfil;
    }

    /**
     * Set the value of [idusuario] column.
     * 
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setIdusuario($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->idusuario !== $v) {
            $this->idusuario = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_IDUSUARIO] = true;
        }

        return $this;
    } // setIdusuario()

    /**
     * Set the value of [password] column.
     * 
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [nombre] column.
     * 
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_NOMBRE] = true;
        }

        return $this;
    } // setNombre()

    /**
     * Set the value of [apellidos] column.
     * 
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setApellidos($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->apellidos !== $v) {
            $this->apellidos = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_APELLIDOS] = true;
        }

        return $this;
    } // setApellidos()

    /**
     * Set the value of [avatar] column.
     * 
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setAvatar($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->avatar !== $v) {
            $this->avatar = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_AVATAR] = true;
        }

        return $this;
    } // setAvatar()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [idperfil] column.
     * 
     * @param int $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setIdperfil($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idperfil !== $v) {
            $this->idperfil = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_IDPERFIL] = true;
        }

        if ($this->aPerfil !== null && $this->aPerfil->getIdperfil() !== $v) {
            $this->aPerfil = null;
        }

        return $this;
    } // setIdperfil()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsuarioTableMap::translateFieldName('Idusuario', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idusuario = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsuarioTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsuarioTableMap::translateFieldName('Nombre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nombre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsuarioTableMap::translateFieldName('Apellidos', TableMap::TYPE_PHPNAME, $indexType)];
            $this->apellidos = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsuarioTableMap::translateFieldName('Avatar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->avatar = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UsuarioTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UsuarioTableMap::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idperfil = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UsuarioTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Usuario'), 0, $e);
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
        if ($this->aPerfil !== null && $this->idperfil !== $this->aPerfil->getIdperfil()) {
            $this->aPerfil = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(UsuarioTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsuarioQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPerfil = null;
            $this->collInvitacions = null;

            $this->collUsuarioAmigosRelatedByIdusuario = null;

            $this->collUsuarioAmigosRelatedByIdamigo = null;

            $this->collMiembrosGrupos = null;

            $this->collViajeUsuarios = null;

            $this->collMensajes = null;

            $this->collUsuariosRelatedByIdamigo = null;
            $this->collUsuariosRelatedByIdusuario = null;
            $this->collGrupos = null;
            $this->collViajes = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Usuario::setDeleted()
     * @see Usuario::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsuarioQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
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
                UsuarioTableMap::addInstanceToPool($this);
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

            if ($this->aPerfil !== null) {
                if ($this->aPerfil->isModified() || $this->aPerfil->isNew()) {
                    $affectedRows += $this->aPerfil->save($con);
                }
                $this->setPerfil($this->aPerfil);
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

            if ($this->usuariosRelatedByIdamigoScheduledForDeletion !== null) {
                if (!$this->usuariosRelatedByIdamigoScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->usuariosRelatedByIdamigoScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getIdusuario();
                        $entryPk[1] = $entry->getIdusuario();
                        $pks[] = $entryPk;
                    }

                    \UsuarioAmigoQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->usuariosRelatedByIdamigoScheduledForDeletion = null;
                }

            }

            if ($this->collUsuariosRelatedByIdamigo) {
                foreach ($this->collUsuariosRelatedByIdamigo as $usuarioRelatedByIdamigo) {
                    if (!$usuarioRelatedByIdamigo->isDeleted() && ($usuarioRelatedByIdamigo->isNew() || $usuarioRelatedByIdamigo->isModified())) {
                        $usuarioRelatedByIdamigo->save($con);
                    }
                }
            }


            if ($this->usuariosRelatedByIdusuarioScheduledForDeletion !== null) {
                if (!$this->usuariosRelatedByIdusuarioScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->usuariosRelatedByIdusuarioScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getIdusuario();
                        $entryPk[0] = $entry->getIdusuario();
                        $pks[] = $entryPk;
                    }

                    \UsuarioAmigoQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->usuariosRelatedByIdusuarioScheduledForDeletion = null;
                }

            }

            if ($this->collUsuariosRelatedByIdusuario) {
                foreach ($this->collUsuariosRelatedByIdusuario as $usuarioRelatedByIdusuario) {
                    if (!$usuarioRelatedByIdusuario->isDeleted() && ($usuarioRelatedByIdusuario->isNew() || $usuarioRelatedByIdusuario->isModified())) {
                        $usuarioRelatedByIdusuario->save($con);
                    }
                }
            }


            if ($this->gruposScheduledForDeletion !== null) {
                if (!$this->gruposScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->gruposScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getIdusuario();
                        $entryPk[0] = $entry->getIdgrupo();
                        $pks[] = $entryPk;
                    }

                    \MiembrosGrupoQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->gruposScheduledForDeletion = null;
                }

            }

            if ($this->collGrupos) {
                foreach ($this->collGrupos as $grupo) {
                    if (!$grupo->isDeleted() && ($grupo->isNew() || $grupo->isModified())) {
                        $grupo->save($con);
                    }
                }
            }


            if ($this->viajesScheduledForDeletion !== null) {
                if (!$this->viajesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->viajesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getIdusuario();
                        $entryPk[0] = $entry->getIdviaje();
                        $pks[] = $entryPk;
                    }

                    \ViajeUsuarioQuery::create()
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


            if ($this->invitacionsScheduledForDeletion !== null) {
                if (!$this->invitacionsScheduledForDeletion->isEmpty()) {
                    \InvitacionQuery::create()
                        ->filterByPrimaryKeys($this->invitacionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->invitacionsScheduledForDeletion = null;
                }
            }

            if ($this->collInvitacions !== null) {
                foreach ($this->collInvitacions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion !== null) {
                if (!$this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion->isEmpty()) {
                    \UsuarioAmigoQuery::create()
                        ->filterByPrimaryKeys($this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion = null;
                }
            }

            if ($this->collUsuarioAmigosRelatedByIdusuario !== null) {
                foreach ($this->collUsuarioAmigosRelatedByIdusuario as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->usuarioAmigosRelatedByIdamigoScheduledForDeletion !== null) {
                if (!$this->usuarioAmigosRelatedByIdamigoScheduledForDeletion->isEmpty()) {
                    \UsuarioAmigoQuery::create()
                        ->filterByPrimaryKeys($this->usuarioAmigosRelatedByIdamigoScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion = null;
                }
            }

            if ($this->collUsuarioAmigosRelatedByIdamigo !== null) {
                foreach ($this->collUsuarioAmigosRelatedByIdamigo as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->miembrosGruposScheduledForDeletion !== null) {
                if (!$this->miembrosGruposScheduledForDeletion->isEmpty()) {
                    \MiembrosGrupoQuery::create()
                        ->filterByPrimaryKeys($this->miembrosGruposScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->miembrosGruposScheduledForDeletion = null;
                }
            }

            if ($this->collMiembrosGrupos !== null) {
                foreach ($this->collMiembrosGrupos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->viajeUsuariosScheduledForDeletion !== null) {
                if (!$this->viajeUsuariosScheduledForDeletion->isEmpty()) {
                    \ViajeUsuarioQuery::create()
                        ->filterByPrimaryKeys($this->viajeUsuariosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->viajeUsuariosScheduledForDeletion = null;
                }
            }

            if ($this->collViajeUsuarios !== null) {
                foreach ($this->collViajeUsuarios as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mensajesScheduledForDeletion !== null) {
                if (!$this->mensajesScheduledForDeletion->isEmpty()) {
                    \MensajeQuery::create()
                        ->filterByPrimaryKeys($this->mensajesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mensajesScheduledForDeletion = null;
                }
            }

            if ($this->collMensajes !== null) {
                foreach ($this->collMensajes as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsuarioTableMap::COL_IDUSUARIO)) {
            $modifiedColumns[':p' . $index++]  = 'idusuario';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = 'nombre';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_APELLIDOS)) {
            $modifiedColumns[':p' . $index++]  = 'apellidos';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_AVATAR)) {
            $modifiedColumns[':p' . $index++]  = 'avatar';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_IDPERFIL)) {
            $modifiedColumns[':p' . $index++]  = 'idperfil';
        }

        $sql = sprintf(
            'INSERT INTO usuario (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idusuario':                        
                        $stmt->bindValue($identifier, $this->idusuario, PDO::PARAM_STR);
                        break;
                    case 'password':                        
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'nombre':                        
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case 'apellidos':                        
                        $stmt->bindValue($identifier, $this->apellidos, PDO::PARAM_STR);
                        break;
                    case 'avatar':                        
                        $stmt->bindValue($identifier, $this->avatar, PDO::PARAM_STR);
                        break;
                    case 'email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'idperfil':                        
                        $stmt->bindValue($identifier, $this->idperfil, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = UsuarioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdusuario();
                break;
            case 1:
                return $this->getPassword();
                break;
            case 2:
                return $this->getNombre();
                break;
            case 3:
                return $this->getApellidos();
                break;
            case 4:
                return $this->getAvatar();
                break;
            case 5:
                return $this->getEmail();
                break;
            case 6:
                return $this->getIdperfil();
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

        if (isset($alreadyDumpedObjects['Usuario'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Usuario'][$this->hashCode()] = true;
        $keys = UsuarioTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdusuario(),
            $keys[1] => $this->getPassword(),
            $keys[2] => $this->getNombre(),
            $keys[3] => $this->getApellidos(),
            $keys[4] => $this->getAvatar(),
            $keys[5] => $this->getEmail(),
            $keys[6] => $this->getIdperfil(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aPerfil) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'perfil';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'perfil';
                        break;
                    default:
                        $key = 'Perfil';
                }
        
                $result[$key] = $this->aPerfil->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collInvitacions) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'invitacions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'invitacions';
                        break;
                    default:
                        $key = 'Invitacions';
                }
        
                $result[$key] = $this->collInvitacions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUsuarioAmigosRelatedByIdusuario) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'usuarioAmigos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'usuario_amigos';
                        break;
                    default:
                        $key = 'UsuarioAmigos';
                }
        
                $result[$key] = $this->collUsuarioAmigosRelatedByIdusuario->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUsuarioAmigosRelatedByIdamigo) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'usuarioAmigos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'usuario_amigos';
                        break;
                    default:
                        $key = 'UsuarioAmigos';
                }
        
                $result[$key] = $this->collUsuarioAmigosRelatedByIdamigo->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMiembrosGrupos) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'miembrosGrupos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'miembros_grupos';
                        break;
                    default:
                        $key = 'MiembrosGrupos';
                }
        
                $result[$key] = $this->collMiembrosGrupos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collViajeUsuarios) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'viajeUsuarios';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'viaje_usuarios';
                        break;
                    default:
                        $key = 'ViajeUsuarios';
                }
        
                $result[$key] = $this->collViajeUsuarios->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMensajes) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mensajes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mensajes';
                        break;
                    default:
                        $key = 'Mensajes';
                }
        
                $result[$key] = $this->collMensajes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Usuario
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsuarioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Usuario
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdusuario($value);
                break;
            case 1:
                $this->setPassword($value);
                break;
            case 2:
                $this->setNombre($value);
                break;
            case 3:
                $this->setApellidos($value);
                break;
            case 4:
                $this->setAvatar($value);
                break;
            case 5:
                $this->setEmail($value);
                break;
            case 6:
                $this->setIdperfil($value);
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
        $keys = UsuarioTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdusuario($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPassword($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNombre($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setApellidos($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAvatar($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEmail($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setIdperfil($arr[$keys[6]]);
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
     * @return $this|\Usuario The current object, for fluid interface
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
        $criteria = new Criteria(UsuarioTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsuarioTableMap::COL_IDUSUARIO)) {
            $criteria->add(UsuarioTableMap::COL_IDUSUARIO, $this->idusuario);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_PASSWORD)) {
            $criteria->add(UsuarioTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_NOMBRE)) {
            $criteria->add(UsuarioTableMap::COL_NOMBRE, $this->nombre);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_APELLIDOS)) {
            $criteria->add(UsuarioTableMap::COL_APELLIDOS, $this->apellidos);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_AVATAR)) {
            $criteria->add(UsuarioTableMap::COL_AVATAR, $this->avatar);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_EMAIL)) {
            $criteria->add(UsuarioTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_IDPERFIL)) {
            $criteria->add(UsuarioTableMap::COL_IDPERFIL, $this->idperfil);
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
        $criteria = ChildUsuarioQuery::create();
        $criteria->add(UsuarioTableMap::COL_IDUSUARIO, $this->idusuario);

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
        $validPk = null !== $this->getIdusuario();

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
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getIdusuario();
    }

    /**
     * Generic method to set the primary key (idusuario column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdusuario($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdusuario();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Usuario (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdusuario($this->getIdusuario());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setNombre($this->getNombre());
        $copyObj->setApellidos($this->getApellidos());
        $copyObj->setAvatar($this->getAvatar());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setIdperfil($this->getIdperfil());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getInvitacions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInvitacion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUsuarioAmigosRelatedByIdusuario() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUsuarioAmigoRelatedByIdusuario($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUsuarioAmigosRelatedByIdamigo() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUsuarioAmigoRelatedByIdamigo($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMiembrosGrupos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMiembrosGrupo($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getViajeUsuarios() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addViajeUsuario($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMensajes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMensaje($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \Usuario Clone of current object.
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
     * Declares an association between this object and a ChildPerfil object.
     *
     * @param  ChildPerfil $v
     * @return $this|\Usuario The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerfil(ChildPerfil $v = null)
    {
        if ($v === null) {
            $this->setIdperfil(NULL);
        } else {
            $this->setIdperfil($v->getIdperfil());
        }

        $this->aPerfil = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerfil object, it will not be re-added.
        if ($v !== null) {
            $v->addUsuario($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerfil object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerfil The associated ChildPerfil object.
     * @throws PropelException
     */
    public function getPerfil(ConnectionInterface $con = null)
    {
        if ($this->aPerfil === null && ($this->idperfil !== null)) {
            $this->aPerfil = ChildPerfilQuery::create()->findPk($this->idperfil, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerfil->addUsuarios($this);
             */
        }

        return $this->aPerfil;
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
        if ('Invitacion' == $relationName) {
            return $this->initInvitacions();
        }
        if ('UsuarioAmigoRelatedByIdusuario' == $relationName) {
            return $this->initUsuarioAmigosRelatedByIdusuario();
        }
        if ('UsuarioAmigoRelatedByIdamigo' == $relationName) {
            return $this->initUsuarioAmigosRelatedByIdamigo();
        }
        if ('MiembrosGrupo' == $relationName) {
            return $this->initMiembrosGrupos();
        }
        if ('ViajeUsuario' == $relationName) {
            return $this->initViajeUsuarios();
        }
        if ('Mensaje' == $relationName) {
            return $this->initMensajes();
        }
    }

    /**
     * Clears out the collInvitacions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInvitacions()
     */
    public function clearInvitacions()
    {
        $this->collInvitacions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInvitacions collection loaded partially.
     */
    public function resetPartialInvitacions($v = true)
    {
        $this->collInvitacionsPartial = $v;
    }

    /**
     * Initializes the collInvitacions collection.
     *
     * By default this just sets the collInvitacions collection to an empty array (like clearcollInvitacions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInvitacions($overrideExisting = true)
    {
        if (null !== $this->collInvitacions && !$overrideExisting) {
            return;
        }

        $collectionClassName = InvitacionTableMap::getTableMap()->getCollectionClassName();

        $this->collInvitacions = new $collectionClassName;
        $this->collInvitacions->setModel('\Invitacion');
    }

    /**
     * Gets an array of ChildInvitacion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInvitacion[] List of ChildInvitacion objects
     * @throws PropelException
     */
    public function getInvitacions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInvitacionsPartial && !$this->isNew();
        if (null === $this->collInvitacions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInvitacions) {
                // return empty collection
                $this->initInvitacions();
            } else {
                $collInvitacions = ChildInvitacionQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInvitacionsPartial && count($collInvitacions)) {
                        $this->initInvitacions(false);

                        foreach ($collInvitacions as $obj) {
                            if (false == $this->collInvitacions->contains($obj)) {
                                $this->collInvitacions->append($obj);
                            }
                        }

                        $this->collInvitacionsPartial = true;
                    }

                    return $collInvitacions;
                }

                if ($partial && $this->collInvitacions) {
                    foreach ($this->collInvitacions as $obj) {
                        if ($obj->isNew()) {
                            $collInvitacions[] = $obj;
                        }
                    }
                }

                $this->collInvitacions = $collInvitacions;
                $this->collInvitacionsPartial = false;
            }
        }

        return $this->collInvitacions;
    }

    /**
     * Sets a collection of ChildInvitacion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $invitacions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setInvitacions(Collection $invitacions, ConnectionInterface $con = null)
    {
        /** @var ChildInvitacion[] $invitacionsToDelete */
        $invitacionsToDelete = $this->getInvitacions(new Criteria(), $con)->diff($invitacions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->invitacionsScheduledForDeletion = clone $invitacionsToDelete;

        foreach ($invitacionsToDelete as $invitacionRemoved) {
            $invitacionRemoved->setUsuario(null);
        }

        $this->collInvitacions = null;
        foreach ($invitacions as $invitacion) {
            $this->addInvitacion($invitacion);
        }

        $this->collInvitacions = $invitacions;
        $this->collInvitacionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Invitacion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Invitacion objects.
     * @throws PropelException
     */
    public function countInvitacions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInvitacionsPartial && !$this->isNew();
        if (null === $this->collInvitacions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInvitacions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInvitacions());
            }

            $query = ChildInvitacionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collInvitacions);
    }

    /**
     * Method called to associate a ChildInvitacion object to this object
     * through the ChildInvitacion foreign key attribute.
     *
     * @param  ChildInvitacion $l ChildInvitacion
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addInvitacion(ChildInvitacion $l)
    {
        if ($this->collInvitacions === null) {
            $this->initInvitacions();
            $this->collInvitacionsPartial = true;
        }

        if (!$this->collInvitacions->contains($l)) {
            $this->doAddInvitacion($l);

            if ($this->invitacionsScheduledForDeletion and $this->invitacionsScheduledForDeletion->contains($l)) {
                $this->invitacionsScheduledForDeletion->remove($this->invitacionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInvitacion $invitacion The ChildInvitacion object to add.
     */
    protected function doAddInvitacion(ChildInvitacion $invitacion)
    {
        $this->collInvitacions[]= $invitacion;
        $invitacion->setUsuario($this);
    }

    /**
     * @param  ChildInvitacion $invitacion The ChildInvitacion object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeInvitacion(ChildInvitacion $invitacion)
    {
        if ($this->getInvitacions()->contains($invitacion)) {
            $pos = $this->collInvitacions->search($invitacion);
            $this->collInvitacions->remove($pos);
            if (null === $this->invitacionsScheduledForDeletion) {
                $this->invitacionsScheduledForDeletion = clone $this->collInvitacions;
                $this->invitacionsScheduledForDeletion->clear();
            }
            $this->invitacionsScheduledForDeletion[]= clone $invitacion;
            $invitacion->setUsuario(null);
        }

        return $this;
    }

    /**
     * Clears out the collUsuarioAmigosRelatedByIdusuario collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsuarioAmigosRelatedByIdusuario()
     */
    public function clearUsuarioAmigosRelatedByIdusuario()
    {
        $this->collUsuarioAmigosRelatedByIdusuario = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUsuarioAmigosRelatedByIdusuario collection loaded partially.
     */
    public function resetPartialUsuarioAmigosRelatedByIdusuario($v = true)
    {
        $this->collUsuarioAmigosRelatedByIdusuarioPartial = $v;
    }

    /**
     * Initializes the collUsuarioAmigosRelatedByIdusuario collection.
     *
     * By default this just sets the collUsuarioAmigosRelatedByIdusuario collection to an empty array (like clearcollUsuarioAmigosRelatedByIdusuario());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUsuarioAmigosRelatedByIdusuario($overrideExisting = true)
    {
        if (null !== $this->collUsuarioAmigosRelatedByIdusuario && !$overrideExisting) {
            return;
        }

        $collectionClassName = UsuarioAmigoTableMap::getTableMap()->getCollectionClassName();

        $this->collUsuarioAmigosRelatedByIdusuario = new $collectionClassName;
        $this->collUsuarioAmigosRelatedByIdusuario->setModel('\UsuarioAmigo');
    }

    /**
     * Gets an array of ChildUsuarioAmigo objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUsuarioAmigo[] List of ChildUsuarioAmigo objects
     * @throws PropelException
     */
    public function getUsuarioAmigosRelatedByIdusuario(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuarioAmigosRelatedByIdusuarioPartial && !$this->isNew();
        if (null === $this->collUsuarioAmigosRelatedByIdusuario || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUsuarioAmigosRelatedByIdusuario) {
                // return empty collection
                $this->initUsuarioAmigosRelatedByIdusuario();
            } else {
                $collUsuarioAmigosRelatedByIdusuario = ChildUsuarioAmigoQuery::create(null, $criteria)
                    ->filterByUsuarioRelatedByIdusuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUsuarioAmigosRelatedByIdusuarioPartial && count($collUsuarioAmigosRelatedByIdusuario)) {
                        $this->initUsuarioAmigosRelatedByIdusuario(false);

                        foreach ($collUsuarioAmigosRelatedByIdusuario as $obj) {
                            if (false == $this->collUsuarioAmigosRelatedByIdusuario->contains($obj)) {
                                $this->collUsuarioAmigosRelatedByIdusuario->append($obj);
                            }
                        }

                        $this->collUsuarioAmigosRelatedByIdusuarioPartial = true;
                    }

                    return $collUsuarioAmigosRelatedByIdusuario;
                }

                if ($partial && $this->collUsuarioAmigosRelatedByIdusuario) {
                    foreach ($this->collUsuarioAmigosRelatedByIdusuario as $obj) {
                        if ($obj->isNew()) {
                            $collUsuarioAmigosRelatedByIdusuario[] = $obj;
                        }
                    }
                }

                $this->collUsuarioAmigosRelatedByIdusuario = $collUsuarioAmigosRelatedByIdusuario;
                $this->collUsuarioAmigosRelatedByIdusuarioPartial = false;
            }
        }

        return $this->collUsuarioAmigosRelatedByIdusuario;
    }

    /**
     * Sets a collection of ChildUsuarioAmigo objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $usuarioAmigosRelatedByIdusuario A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setUsuarioAmigosRelatedByIdusuario(Collection $usuarioAmigosRelatedByIdusuario, ConnectionInterface $con = null)
    {
        /** @var ChildUsuarioAmigo[] $usuarioAmigosRelatedByIdusuarioToDelete */
        $usuarioAmigosRelatedByIdusuarioToDelete = $this->getUsuarioAmigosRelatedByIdusuario(new Criteria(), $con)->diff($usuarioAmigosRelatedByIdusuario);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion = clone $usuarioAmigosRelatedByIdusuarioToDelete;

        foreach ($usuarioAmigosRelatedByIdusuarioToDelete as $usuarioAmigoRelatedByIdusuarioRemoved) {
            $usuarioAmigoRelatedByIdusuarioRemoved->setUsuarioRelatedByIdusuario(null);
        }

        $this->collUsuarioAmigosRelatedByIdusuario = null;
        foreach ($usuarioAmigosRelatedByIdusuario as $usuarioAmigoRelatedByIdusuario) {
            $this->addUsuarioAmigoRelatedByIdusuario($usuarioAmigoRelatedByIdusuario);
        }

        $this->collUsuarioAmigosRelatedByIdusuario = $usuarioAmigosRelatedByIdusuario;
        $this->collUsuarioAmigosRelatedByIdusuarioPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UsuarioAmigo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UsuarioAmigo objects.
     * @throws PropelException
     */
    public function countUsuarioAmigosRelatedByIdusuario(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuarioAmigosRelatedByIdusuarioPartial && !$this->isNew();
        if (null === $this->collUsuarioAmigosRelatedByIdusuario || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsuarioAmigosRelatedByIdusuario) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUsuarioAmigosRelatedByIdusuario());
            }

            $query = ChildUsuarioAmigoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuarioRelatedByIdusuario($this)
                ->count($con);
        }

        return count($this->collUsuarioAmigosRelatedByIdusuario);
    }

    /**
     * Method called to associate a ChildUsuarioAmigo object to this object
     * through the ChildUsuarioAmigo foreign key attribute.
     *
     * @param  ChildUsuarioAmigo $l ChildUsuarioAmigo
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addUsuarioAmigoRelatedByIdusuario(ChildUsuarioAmigo $l)
    {
        if ($this->collUsuarioAmigosRelatedByIdusuario === null) {
            $this->initUsuarioAmigosRelatedByIdusuario();
            $this->collUsuarioAmigosRelatedByIdusuarioPartial = true;
        }

        if (!$this->collUsuarioAmigosRelatedByIdusuario->contains($l)) {
            $this->doAddUsuarioAmigoRelatedByIdusuario($l);

            if ($this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion and $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion->contains($l)) {
                $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion->remove($this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUsuarioAmigo $usuarioAmigoRelatedByIdusuario The ChildUsuarioAmigo object to add.
     */
    protected function doAddUsuarioAmigoRelatedByIdusuario(ChildUsuarioAmigo $usuarioAmigoRelatedByIdusuario)
    {
        $this->collUsuarioAmigosRelatedByIdusuario[]= $usuarioAmigoRelatedByIdusuario;
        $usuarioAmigoRelatedByIdusuario->setUsuarioRelatedByIdusuario($this);
    }

    /**
     * @param  ChildUsuarioAmigo $usuarioAmigoRelatedByIdusuario The ChildUsuarioAmigo object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeUsuarioAmigoRelatedByIdusuario(ChildUsuarioAmigo $usuarioAmigoRelatedByIdusuario)
    {
        if ($this->getUsuarioAmigosRelatedByIdusuario()->contains($usuarioAmigoRelatedByIdusuario)) {
            $pos = $this->collUsuarioAmigosRelatedByIdusuario->search($usuarioAmigoRelatedByIdusuario);
            $this->collUsuarioAmigosRelatedByIdusuario->remove($pos);
            if (null === $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion) {
                $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion = clone $this->collUsuarioAmigosRelatedByIdusuario;
                $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion->clear();
            }
            $this->usuarioAmigosRelatedByIdusuarioScheduledForDeletion[]= clone $usuarioAmigoRelatedByIdusuario;
            $usuarioAmigoRelatedByIdusuario->setUsuarioRelatedByIdusuario(null);
        }

        return $this;
    }

    /**
     * Clears out the collUsuarioAmigosRelatedByIdamigo collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsuarioAmigosRelatedByIdamigo()
     */
    public function clearUsuarioAmigosRelatedByIdamigo()
    {
        $this->collUsuarioAmigosRelatedByIdamigo = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUsuarioAmigosRelatedByIdamigo collection loaded partially.
     */
    public function resetPartialUsuarioAmigosRelatedByIdamigo($v = true)
    {
        $this->collUsuarioAmigosRelatedByIdamigoPartial = $v;
    }

    /**
     * Initializes the collUsuarioAmigosRelatedByIdamigo collection.
     *
     * By default this just sets the collUsuarioAmigosRelatedByIdamigo collection to an empty array (like clearcollUsuarioAmigosRelatedByIdamigo());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUsuarioAmigosRelatedByIdamigo($overrideExisting = true)
    {
        if (null !== $this->collUsuarioAmigosRelatedByIdamigo && !$overrideExisting) {
            return;
        }

        $collectionClassName = UsuarioAmigoTableMap::getTableMap()->getCollectionClassName();

        $this->collUsuarioAmigosRelatedByIdamigo = new $collectionClassName;
        $this->collUsuarioAmigosRelatedByIdamigo->setModel('\UsuarioAmigo');
    }

    /**
     * Gets an array of ChildUsuarioAmigo objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUsuarioAmigo[] List of ChildUsuarioAmigo objects
     * @throws PropelException
     */
    public function getUsuarioAmigosRelatedByIdamigo(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuarioAmigosRelatedByIdamigoPartial && !$this->isNew();
        if (null === $this->collUsuarioAmigosRelatedByIdamigo || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUsuarioAmigosRelatedByIdamigo) {
                // return empty collection
                $this->initUsuarioAmigosRelatedByIdamigo();
            } else {
                $collUsuarioAmigosRelatedByIdamigo = ChildUsuarioAmigoQuery::create(null, $criteria)
                    ->filterByUsuarioRelatedByIdamigo($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUsuarioAmigosRelatedByIdamigoPartial && count($collUsuarioAmigosRelatedByIdamigo)) {
                        $this->initUsuarioAmigosRelatedByIdamigo(false);

                        foreach ($collUsuarioAmigosRelatedByIdamigo as $obj) {
                            if (false == $this->collUsuarioAmigosRelatedByIdamigo->contains($obj)) {
                                $this->collUsuarioAmigosRelatedByIdamigo->append($obj);
                            }
                        }

                        $this->collUsuarioAmigosRelatedByIdamigoPartial = true;
                    }

                    return $collUsuarioAmigosRelatedByIdamigo;
                }

                if ($partial && $this->collUsuarioAmigosRelatedByIdamigo) {
                    foreach ($this->collUsuarioAmigosRelatedByIdamigo as $obj) {
                        if ($obj->isNew()) {
                            $collUsuarioAmigosRelatedByIdamigo[] = $obj;
                        }
                    }
                }

                $this->collUsuarioAmigosRelatedByIdamigo = $collUsuarioAmigosRelatedByIdamigo;
                $this->collUsuarioAmigosRelatedByIdamigoPartial = false;
            }
        }

        return $this->collUsuarioAmigosRelatedByIdamigo;
    }

    /**
     * Sets a collection of ChildUsuarioAmigo objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $usuarioAmigosRelatedByIdamigo A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setUsuarioAmigosRelatedByIdamigo(Collection $usuarioAmigosRelatedByIdamigo, ConnectionInterface $con = null)
    {
        /** @var ChildUsuarioAmigo[] $usuarioAmigosRelatedByIdamigoToDelete */
        $usuarioAmigosRelatedByIdamigoToDelete = $this->getUsuarioAmigosRelatedByIdamigo(new Criteria(), $con)->diff($usuarioAmigosRelatedByIdamigo);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion = clone $usuarioAmigosRelatedByIdamigoToDelete;

        foreach ($usuarioAmigosRelatedByIdamigoToDelete as $usuarioAmigoRelatedByIdamigoRemoved) {
            $usuarioAmigoRelatedByIdamigoRemoved->setUsuarioRelatedByIdamigo(null);
        }

        $this->collUsuarioAmigosRelatedByIdamigo = null;
        foreach ($usuarioAmigosRelatedByIdamigo as $usuarioAmigoRelatedByIdamigo) {
            $this->addUsuarioAmigoRelatedByIdamigo($usuarioAmigoRelatedByIdamigo);
        }

        $this->collUsuarioAmigosRelatedByIdamigo = $usuarioAmigosRelatedByIdamigo;
        $this->collUsuarioAmigosRelatedByIdamigoPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UsuarioAmigo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UsuarioAmigo objects.
     * @throws PropelException
     */
    public function countUsuarioAmigosRelatedByIdamigo(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuarioAmigosRelatedByIdamigoPartial && !$this->isNew();
        if (null === $this->collUsuarioAmigosRelatedByIdamigo || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsuarioAmigosRelatedByIdamigo) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUsuarioAmigosRelatedByIdamigo());
            }

            $query = ChildUsuarioAmigoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuarioRelatedByIdamigo($this)
                ->count($con);
        }

        return count($this->collUsuarioAmigosRelatedByIdamigo);
    }

    /**
     * Method called to associate a ChildUsuarioAmigo object to this object
     * through the ChildUsuarioAmigo foreign key attribute.
     *
     * @param  ChildUsuarioAmigo $l ChildUsuarioAmigo
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addUsuarioAmigoRelatedByIdamigo(ChildUsuarioAmigo $l)
    {
        if ($this->collUsuarioAmigosRelatedByIdamigo === null) {
            $this->initUsuarioAmigosRelatedByIdamigo();
            $this->collUsuarioAmigosRelatedByIdamigoPartial = true;
        }

        if (!$this->collUsuarioAmigosRelatedByIdamigo->contains($l)) {
            $this->doAddUsuarioAmigoRelatedByIdamigo($l);

            if ($this->usuarioAmigosRelatedByIdamigoScheduledForDeletion and $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion->contains($l)) {
                $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion->remove($this->usuarioAmigosRelatedByIdamigoScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUsuarioAmigo $usuarioAmigoRelatedByIdamigo The ChildUsuarioAmigo object to add.
     */
    protected function doAddUsuarioAmigoRelatedByIdamigo(ChildUsuarioAmigo $usuarioAmigoRelatedByIdamigo)
    {
        $this->collUsuarioAmigosRelatedByIdamigo[]= $usuarioAmigoRelatedByIdamigo;
        $usuarioAmigoRelatedByIdamigo->setUsuarioRelatedByIdamigo($this);
    }

    /**
     * @param  ChildUsuarioAmigo $usuarioAmigoRelatedByIdamigo The ChildUsuarioAmigo object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeUsuarioAmigoRelatedByIdamigo(ChildUsuarioAmigo $usuarioAmigoRelatedByIdamigo)
    {
        if ($this->getUsuarioAmigosRelatedByIdamigo()->contains($usuarioAmigoRelatedByIdamigo)) {
            $pos = $this->collUsuarioAmigosRelatedByIdamigo->search($usuarioAmigoRelatedByIdamigo);
            $this->collUsuarioAmigosRelatedByIdamigo->remove($pos);
            if (null === $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion) {
                $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion = clone $this->collUsuarioAmigosRelatedByIdamigo;
                $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion->clear();
            }
            $this->usuarioAmigosRelatedByIdamigoScheduledForDeletion[]= clone $usuarioAmigoRelatedByIdamigo;
            $usuarioAmigoRelatedByIdamigo->setUsuarioRelatedByIdamigo(null);
        }

        return $this;
    }

    /**
     * Clears out the collMiembrosGrupos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMiembrosGrupos()
     */
    public function clearMiembrosGrupos()
    {
        $this->collMiembrosGrupos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMiembrosGrupos collection loaded partially.
     */
    public function resetPartialMiembrosGrupos($v = true)
    {
        $this->collMiembrosGruposPartial = $v;
    }

    /**
     * Initializes the collMiembrosGrupos collection.
     *
     * By default this just sets the collMiembrosGrupos collection to an empty array (like clearcollMiembrosGrupos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMiembrosGrupos($overrideExisting = true)
    {
        if (null !== $this->collMiembrosGrupos && !$overrideExisting) {
            return;
        }

        $collectionClassName = MiembrosGrupoTableMap::getTableMap()->getCollectionClassName();

        $this->collMiembrosGrupos = new $collectionClassName;
        $this->collMiembrosGrupos->setModel('\MiembrosGrupo');
    }

    /**
     * Gets an array of ChildMiembrosGrupo objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMiembrosGrupo[] List of ChildMiembrosGrupo objects
     * @throws PropelException
     */
    public function getMiembrosGrupos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMiembrosGruposPartial && !$this->isNew();
        if (null === $this->collMiembrosGrupos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMiembrosGrupos) {
                // return empty collection
                $this->initMiembrosGrupos();
            } else {
                $collMiembrosGrupos = ChildMiembrosGrupoQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMiembrosGruposPartial && count($collMiembrosGrupos)) {
                        $this->initMiembrosGrupos(false);

                        foreach ($collMiembrosGrupos as $obj) {
                            if (false == $this->collMiembrosGrupos->contains($obj)) {
                                $this->collMiembrosGrupos->append($obj);
                            }
                        }

                        $this->collMiembrosGruposPartial = true;
                    }

                    return $collMiembrosGrupos;
                }

                if ($partial && $this->collMiembrosGrupos) {
                    foreach ($this->collMiembrosGrupos as $obj) {
                        if ($obj->isNew()) {
                            $collMiembrosGrupos[] = $obj;
                        }
                    }
                }

                $this->collMiembrosGrupos = $collMiembrosGrupos;
                $this->collMiembrosGruposPartial = false;
            }
        }

        return $this->collMiembrosGrupos;
    }

    /**
     * Sets a collection of ChildMiembrosGrupo objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $miembrosGrupos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setMiembrosGrupos(Collection $miembrosGrupos, ConnectionInterface $con = null)
    {
        /** @var ChildMiembrosGrupo[] $miembrosGruposToDelete */
        $miembrosGruposToDelete = $this->getMiembrosGrupos(new Criteria(), $con)->diff($miembrosGrupos);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->miembrosGruposScheduledForDeletion = clone $miembrosGruposToDelete;

        foreach ($miembrosGruposToDelete as $miembrosGrupoRemoved) {
            $miembrosGrupoRemoved->setUsuario(null);
        }

        $this->collMiembrosGrupos = null;
        foreach ($miembrosGrupos as $miembrosGrupo) {
            $this->addMiembrosGrupo($miembrosGrupo);
        }

        $this->collMiembrosGrupos = $miembrosGrupos;
        $this->collMiembrosGruposPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MiembrosGrupo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MiembrosGrupo objects.
     * @throws PropelException
     */
    public function countMiembrosGrupos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMiembrosGruposPartial && !$this->isNew();
        if (null === $this->collMiembrosGrupos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMiembrosGrupos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMiembrosGrupos());
            }

            $query = ChildMiembrosGrupoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collMiembrosGrupos);
    }

    /**
     * Method called to associate a ChildMiembrosGrupo object to this object
     * through the ChildMiembrosGrupo foreign key attribute.
     *
     * @param  ChildMiembrosGrupo $l ChildMiembrosGrupo
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addMiembrosGrupo(ChildMiembrosGrupo $l)
    {
        if ($this->collMiembrosGrupos === null) {
            $this->initMiembrosGrupos();
            $this->collMiembrosGruposPartial = true;
        }

        if (!$this->collMiembrosGrupos->contains($l)) {
            $this->doAddMiembrosGrupo($l);

            if ($this->miembrosGruposScheduledForDeletion and $this->miembrosGruposScheduledForDeletion->contains($l)) {
                $this->miembrosGruposScheduledForDeletion->remove($this->miembrosGruposScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMiembrosGrupo $miembrosGrupo The ChildMiembrosGrupo object to add.
     */
    protected function doAddMiembrosGrupo(ChildMiembrosGrupo $miembrosGrupo)
    {
        $this->collMiembrosGrupos[]= $miembrosGrupo;
        $miembrosGrupo->setUsuario($this);
    }

    /**
     * @param  ChildMiembrosGrupo $miembrosGrupo The ChildMiembrosGrupo object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeMiembrosGrupo(ChildMiembrosGrupo $miembrosGrupo)
    {
        if ($this->getMiembrosGrupos()->contains($miembrosGrupo)) {
            $pos = $this->collMiembrosGrupos->search($miembrosGrupo);
            $this->collMiembrosGrupos->remove($pos);
            if (null === $this->miembrosGruposScheduledForDeletion) {
                $this->miembrosGruposScheduledForDeletion = clone $this->collMiembrosGrupos;
                $this->miembrosGruposScheduledForDeletion->clear();
            }
            $this->miembrosGruposScheduledForDeletion[]= clone $miembrosGrupo;
            $miembrosGrupo->setUsuario(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Usuario is new, it will return
     * an empty collection; or if this Usuario has previously
     * been saved, it will retrieve related MiembrosGrupos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Usuario.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMiembrosGrupo[] List of ChildMiembrosGrupo objects
     */
    public function getMiembrosGruposJoinGrupo(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMiembrosGrupoQuery::create(null, $criteria);
        $query->joinWith('Grupo', $joinBehavior);

        return $this->getMiembrosGrupos($query, $con);
    }

    /**
     * Clears out the collViajeUsuarios collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addViajeUsuarios()
     */
    public function clearViajeUsuarios()
    {
        $this->collViajeUsuarios = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collViajeUsuarios collection loaded partially.
     */
    public function resetPartialViajeUsuarios($v = true)
    {
        $this->collViajeUsuariosPartial = $v;
    }

    /**
     * Initializes the collViajeUsuarios collection.
     *
     * By default this just sets the collViajeUsuarios collection to an empty array (like clearcollViajeUsuarios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initViajeUsuarios($overrideExisting = true)
    {
        if (null !== $this->collViajeUsuarios && !$overrideExisting) {
            return;
        }

        $collectionClassName = ViajeUsuarioTableMap::getTableMap()->getCollectionClassName();

        $this->collViajeUsuarios = new $collectionClassName;
        $this->collViajeUsuarios->setModel('\ViajeUsuario');
    }

    /**
     * Gets an array of ChildViajeUsuario objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildViajeUsuario[] List of ChildViajeUsuario objects
     * @throws PropelException
     */
    public function getViajeUsuarios(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collViajeUsuariosPartial && !$this->isNew();
        if (null === $this->collViajeUsuarios || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collViajeUsuarios) {
                // return empty collection
                $this->initViajeUsuarios();
            } else {
                $collViajeUsuarios = ChildViajeUsuarioQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collViajeUsuariosPartial && count($collViajeUsuarios)) {
                        $this->initViajeUsuarios(false);

                        foreach ($collViajeUsuarios as $obj) {
                            if (false == $this->collViajeUsuarios->contains($obj)) {
                                $this->collViajeUsuarios->append($obj);
                            }
                        }

                        $this->collViajeUsuariosPartial = true;
                    }

                    return $collViajeUsuarios;
                }

                if ($partial && $this->collViajeUsuarios) {
                    foreach ($this->collViajeUsuarios as $obj) {
                        if ($obj->isNew()) {
                            $collViajeUsuarios[] = $obj;
                        }
                    }
                }

                $this->collViajeUsuarios = $collViajeUsuarios;
                $this->collViajeUsuariosPartial = false;
            }
        }

        return $this->collViajeUsuarios;
    }

    /**
     * Sets a collection of ChildViajeUsuario objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $viajeUsuarios A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setViajeUsuarios(Collection $viajeUsuarios, ConnectionInterface $con = null)
    {
        /** @var ChildViajeUsuario[] $viajeUsuariosToDelete */
        $viajeUsuariosToDelete = $this->getViajeUsuarios(new Criteria(), $con)->diff($viajeUsuarios);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->viajeUsuariosScheduledForDeletion = clone $viajeUsuariosToDelete;

        foreach ($viajeUsuariosToDelete as $viajeUsuarioRemoved) {
            $viajeUsuarioRemoved->setUsuario(null);
        }

        $this->collViajeUsuarios = null;
        foreach ($viajeUsuarios as $viajeUsuario) {
            $this->addViajeUsuario($viajeUsuario);
        }

        $this->collViajeUsuarios = $viajeUsuarios;
        $this->collViajeUsuariosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ViajeUsuario objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ViajeUsuario objects.
     * @throws PropelException
     */
    public function countViajeUsuarios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collViajeUsuariosPartial && !$this->isNew();
        if (null === $this->collViajeUsuarios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collViajeUsuarios) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getViajeUsuarios());
            }

            $query = ChildViajeUsuarioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collViajeUsuarios);
    }

    /**
     * Method called to associate a ChildViajeUsuario object to this object
     * through the ChildViajeUsuario foreign key attribute.
     *
     * @param  ChildViajeUsuario $l ChildViajeUsuario
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addViajeUsuario(ChildViajeUsuario $l)
    {
        if ($this->collViajeUsuarios === null) {
            $this->initViajeUsuarios();
            $this->collViajeUsuariosPartial = true;
        }

        if (!$this->collViajeUsuarios->contains($l)) {
            $this->doAddViajeUsuario($l);

            if ($this->viajeUsuariosScheduledForDeletion and $this->viajeUsuariosScheduledForDeletion->contains($l)) {
                $this->viajeUsuariosScheduledForDeletion->remove($this->viajeUsuariosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildViajeUsuario $viajeUsuario The ChildViajeUsuario object to add.
     */
    protected function doAddViajeUsuario(ChildViajeUsuario $viajeUsuario)
    {
        $this->collViajeUsuarios[]= $viajeUsuario;
        $viajeUsuario->setUsuario($this);
    }

    /**
     * @param  ChildViajeUsuario $viajeUsuario The ChildViajeUsuario object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeViajeUsuario(ChildViajeUsuario $viajeUsuario)
    {
        if ($this->getViajeUsuarios()->contains($viajeUsuario)) {
            $pos = $this->collViajeUsuarios->search($viajeUsuario);
            $this->collViajeUsuarios->remove($pos);
            if (null === $this->viajeUsuariosScheduledForDeletion) {
                $this->viajeUsuariosScheduledForDeletion = clone $this->collViajeUsuarios;
                $this->viajeUsuariosScheduledForDeletion->clear();
            }
            $this->viajeUsuariosScheduledForDeletion[]= clone $viajeUsuario;
            $viajeUsuario->setUsuario(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Usuario is new, it will return
     * an empty collection; or if this Usuario has previously
     * been saved, it will retrieve related ViajeUsuarios from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Usuario.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildViajeUsuario[] List of ChildViajeUsuario objects
     */
    public function getViajeUsuariosJoinViaje(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildViajeUsuarioQuery::create(null, $criteria);
        $query->joinWith('Viaje', $joinBehavior);

        return $this->getViajeUsuarios($query, $con);
    }

    /**
     * Clears out the collMensajes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMensajes()
     */
    public function clearMensajes()
    {
        $this->collMensajes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMensajes collection loaded partially.
     */
    public function resetPartialMensajes($v = true)
    {
        $this->collMensajesPartial = $v;
    }

    /**
     * Initializes the collMensajes collection.
     *
     * By default this just sets the collMensajes collection to an empty array (like clearcollMensajes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMensajes($overrideExisting = true)
    {
        if (null !== $this->collMensajes && !$overrideExisting) {
            return;
        }

        $collectionClassName = MensajeTableMap::getTableMap()->getCollectionClassName();

        $this->collMensajes = new $collectionClassName;
        $this->collMensajes->setModel('\Mensaje');
    }

    /**
     * Gets an array of ChildMensaje objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMensaje[] List of ChildMensaje objects
     * @throws PropelException
     */
    public function getMensajes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesPartial && !$this->isNew();
        if (null === $this->collMensajes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMensajes) {
                // return empty collection
                $this->initMensajes();
            } else {
                $collMensajes = ChildMensajeQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMensajesPartial && count($collMensajes)) {
                        $this->initMensajes(false);

                        foreach ($collMensajes as $obj) {
                            if (false == $this->collMensajes->contains($obj)) {
                                $this->collMensajes->append($obj);
                            }
                        }

                        $this->collMensajesPartial = true;
                    }

                    return $collMensajes;
                }

                if ($partial && $this->collMensajes) {
                    foreach ($this->collMensajes as $obj) {
                        if ($obj->isNew()) {
                            $collMensajes[] = $obj;
                        }
                    }
                }

                $this->collMensajes = $collMensajes;
                $this->collMensajesPartial = false;
            }
        }

        return $this->collMensajes;
    }

    /**
     * Sets a collection of ChildMensaje objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mensajes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setMensajes(Collection $mensajes, ConnectionInterface $con = null)
    {
        /** @var ChildMensaje[] $mensajesToDelete */
        $mensajesToDelete = $this->getMensajes(new Criteria(), $con)->diff($mensajes);

        
        $this->mensajesScheduledForDeletion = $mensajesToDelete;

        foreach ($mensajesToDelete as $mensajeRemoved) {
            $mensajeRemoved->setUsuario(null);
        }

        $this->collMensajes = null;
        foreach ($mensajes as $mensaje) {
            $this->addMensaje($mensaje);
        }

        $this->collMensajes = $mensajes;
        $this->collMensajesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Mensaje objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Mensaje objects.
     * @throws PropelException
     */
    public function countMensajes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesPartial && !$this->isNew();
        if (null === $this->collMensajes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMensajes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMensajes());
            }

            $query = ChildMensajeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collMensajes);
    }

    /**
     * Method called to associate a ChildMensaje object to this object
     * through the ChildMensaje foreign key attribute.
     *
     * @param  ChildMensaje $l ChildMensaje
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addMensaje(ChildMensaje $l)
    {
        if ($this->collMensajes === null) {
            $this->initMensajes();
            $this->collMensajesPartial = true;
        }

        if (!$this->collMensajes->contains($l)) {
            $this->doAddMensaje($l);

            if ($this->mensajesScheduledForDeletion and $this->mensajesScheduledForDeletion->contains($l)) {
                $this->mensajesScheduledForDeletion->remove($this->mensajesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMensaje $mensaje The ChildMensaje object to add.
     */
    protected function doAddMensaje(ChildMensaje $mensaje)
    {
        $this->collMensajes[]= $mensaje;
        $mensaje->setUsuario($this);
    }

    /**
     * @param  ChildMensaje $mensaje The ChildMensaje object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeMensaje(ChildMensaje $mensaje)
    {
        if ($this->getMensajes()->contains($mensaje)) {
            $pos = $this->collMensajes->search($mensaje);
            $this->collMensajes->remove($pos);
            if (null === $this->mensajesScheduledForDeletion) {
                $this->mensajesScheduledForDeletion = clone $this->collMensajes;
                $this->mensajesScheduledForDeletion->clear();
            }
            $this->mensajesScheduledForDeletion[]= clone $mensaje;
            $mensaje->setUsuario(null);
        }

        return $this;
    }

    /**
     * Clears out the collUsuariosRelatedByIdamigo collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsuariosRelatedByIdamigo()
     */
    public function clearUsuariosRelatedByIdamigo()
    {
        $this->collUsuariosRelatedByIdamigo = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collUsuariosRelatedByIdamigo crossRef collection.
     *
     * By default this just sets the collUsuariosRelatedByIdamigo collection to an empty collection (like clearUsuariosRelatedByIdamigo());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUsuariosRelatedByIdamigo()
    {
        $collectionClassName = UsuarioAmigoTableMap::getTableMap()->getCollectionClassName();

        $this->collUsuariosRelatedByIdamigo = new $collectionClassName;
        $this->collUsuariosRelatedByIdamigoPartial = true;
        $this->collUsuariosRelatedByIdamigo->setModel('\Usuario');
    }

    /**
     * Checks if the collUsuariosRelatedByIdamigo collection is loaded.
     *
     * @return bool
     */
    public function isUsuariosRelatedByIdamigoLoaded()
    {
        return null !== $this->collUsuariosRelatedByIdamigo;
    }

    /**
     * Gets a collection of ChildUsuario objects related by a many-to-many relationship
     * to the current object by way of the usuario_amigo cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUsuario[] List of ChildUsuario objects
     */
    public function getUsuariosRelatedByIdamigo(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuariosRelatedByIdamigoPartial && !$this->isNew();
        if (null === $this->collUsuariosRelatedByIdamigo || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collUsuariosRelatedByIdamigo) {
                    $this->initUsuariosRelatedByIdamigo();
                }
            } else {

                $query = ChildUsuarioQuery::create(null, $criteria)
                    ->filterByUsuarioRelatedByIdusuario($this);
                $collUsuariosRelatedByIdamigo = $query->find($con);
                if (null !== $criteria) {
                    return $collUsuariosRelatedByIdamigo;
                }

                if ($partial && $this->collUsuariosRelatedByIdamigo) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collUsuariosRelatedByIdamigo as $obj) {
                        if (!$collUsuariosRelatedByIdamigo->contains($obj)) {
                            $collUsuariosRelatedByIdamigo[] = $obj;
                        }
                    }
                }

                $this->collUsuariosRelatedByIdamigo = $collUsuariosRelatedByIdamigo;
                $this->collUsuariosRelatedByIdamigoPartial = false;
            }
        }

        return $this->collUsuariosRelatedByIdamigo;
    }

    /**
     * Sets a collection of Usuario objects related by a many-to-many relationship
     * to the current object by way of the usuario_amigo cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $usuariosRelatedByIdamigo A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setUsuariosRelatedByIdamigo(Collection $usuariosRelatedByIdamigo, ConnectionInterface $con = null)
    {
        $this->clearUsuariosRelatedByIdamigo();
        $currentUsuariosRelatedByIdamigo = $this->getUsuariosRelatedByIdamigo();

        $usuariosRelatedByIdamigoScheduledForDeletion = $currentUsuariosRelatedByIdamigo->diff($usuariosRelatedByIdamigo);

        foreach ($usuariosRelatedByIdamigoScheduledForDeletion as $toDelete) {
            $this->removeUsuarioRelatedByIdamigo($toDelete);
        }

        foreach ($usuariosRelatedByIdamigo as $usuarioRelatedByIdamigo) {
            if (!$currentUsuariosRelatedByIdamigo->contains($usuarioRelatedByIdamigo)) {
                $this->doAddUsuarioRelatedByIdamigo($usuarioRelatedByIdamigo);
            }
        }

        $this->collUsuariosRelatedByIdamigoPartial = false;
        $this->collUsuariosRelatedByIdamigo = $usuariosRelatedByIdamigo;

        return $this;
    }

    /**
     * Gets the number of Usuario objects related by a many-to-many relationship
     * to the current object by way of the usuario_amigo cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Usuario objects
     */
    public function countUsuariosRelatedByIdamigo(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuariosRelatedByIdamigoPartial && !$this->isNew();
        if (null === $this->collUsuariosRelatedByIdamigo || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsuariosRelatedByIdamigo) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getUsuariosRelatedByIdamigo());
                }

                $query = ChildUsuarioQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUsuarioRelatedByIdusuario($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsuariosRelatedByIdamigo);
        }
    }

    /**
     * Associate a ChildUsuario to this object
     * through the usuario_amigo cross reference table.
     * 
     * @param ChildUsuario $usuarioRelatedByIdamigo
     * @return ChildUsuario The current object (for fluent API support)
     */
    public function addUsuarioRelatedByIdamigo(ChildUsuario $usuarioRelatedByIdamigo)
    {
        if ($this->collUsuariosRelatedByIdamigo === null) {
            $this->initUsuariosRelatedByIdamigo();
        }

        if (!$this->getUsuariosRelatedByIdamigo()->contains($usuarioRelatedByIdamigo)) {
            // only add it if the **same** object is not already associated
            $this->collUsuariosRelatedByIdamigo->push($usuarioRelatedByIdamigo);
            $this->doAddUsuarioRelatedByIdamigo($usuarioRelatedByIdamigo);
        }

        return $this;
    }

    /**
     * 
     * @param ChildUsuario $usuarioRelatedByIdamigo
     */
    protected function doAddUsuarioRelatedByIdamigo(ChildUsuario $usuarioRelatedByIdamigo)
    {
        $usuarioAmigo = new ChildUsuarioAmigo();

        $usuarioAmigo->setUsuarioRelatedByIdamigo($usuarioRelatedByIdamigo);

        $usuarioAmigo->setUsuarioRelatedByIdusuario($this);

        $this->addUsuarioAmigoRelatedByIdusuario($usuarioAmigo);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$usuarioRelatedByIdamigo->isUsuariosRelatedByIdusuarioLoaded()) {
            $usuarioRelatedByIdamigo->initUsuariosRelatedByIdusuario();
            $usuarioRelatedByIdamigo->getUsuariosRelatedByIdusuario()->push($this);
        } elseif (!$usuarioRelatedByIdamigo->getUsuariosRelatedByIdusuario()->contains($this)) {
            $usuarioRelatedByIdamigo->getUsuariosRelatedByIdusuario()->push($this);
        }

    }

    /**
     * Remove usuarioRelatedByIdamigo of this object
     * through the usuario_amigo cross reference table.
     * 
     * @param ChildUsuario $usuarioRelatedByIdamigo
     * @return ChildUsuario The current object (for fluent API support)
     */
    public function removeUsuarioRelatedByIdamigo(ChildUsuario $usuarioRelatedByIdamigo)
    {
        if ($this->getUsuariosRelatedByIdamigo()->contains($usuarioRelatedByIdamigo)) { $usuarioAmigo = new ChildUsuarioAmigo();

            $usuarioAmigo->setUsuarioRelatedByIdamigo($usuarioRelatedByIdamigo);
            if ($usuarioRelatedByIdamigo->isUsuarioRelatedByIdusuariosLoaded()) {
                //remove the back reference if available
                $usuarioRelatedByIdamigo->getUsuarioRelatedByIdusuarios()->removeObject($this);
            }

            $usuarioAmigo->setUsuarioRelatedByIdusuario($this);
            $this->removeUsuarioAmigoRelatedByIdusuario(clone $usuarioAmigo);
            $usuarioAmigo->clear();

            $this->collUsuariosRelatedByIdamigo->remove($this->collUsuariosRelatedByIdamigo->search($usuarioRelatedByIdamigo));
            
            if (null === $this->usuariosRelatedByIdamigoScheduledForDeletion) {
                $this->usuariosRelatedByIdamigoScheduledForDeletion = clone $this->collUsuariosRelatedByIdamigo;
                $this->usuariosRelatedByIdamigoScheduledForDeletion->clear();
            }

            $this->usuariosRelatedByIdamigoScheduledForDeletion->push($usuarioRelatedByIdamigo);
        }


        return $this;
    }

    /**
     * Clears out the collUsuariosRelatedByIdusuario collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsuariosRelatedByIdusuario()
     */
    public function clearUsuariosRelatedByIdusuario()
    {
        $this->collUsuariosRelatedByIdusuario = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collUsuariosRelatedByIdusuario crossRef collection.
     *
     * By default this just sets the collUsuariosRelatedByIdusuario collection to an empty collection (like clearUsuariosRelatedByIdusuario());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUsuariosRelatedByIdusuario()
    {
        $collectionClassName = UsuarioAmigoTableMap::getTableMap()->getCollectionClassName();

        $this->collUsuariosRelatedByIdusuario = new $collectionClassName;
        $this->collUsuariosRelatedByIdusuarioPartial = true;
        $this->collUsuariosRelatedByIdusuario->setModel('\Usuario');
    }

    /**
     * Checks if the collUsuariosRelatedByIdusuario collection is loaded.
     *
     * @return bool
     */
    public function isUsuariosRelatedByIdusuarioLoaded()
    {
        return null !== $this->collUsuariosRelatedByIdusuario;
    }

    /**
     * Gets a collection of ChildUsuario objects related by a many-to-many relationship
     * to the current object by way of the usuario_amigo cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUsuario[] List of ChildUsuario objects
     */
    public function getUsuariosRelatedByIdusuario(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuariosRelatedByIdusuarioPartial && !$this->isNew();
        if (null === $this->collUsuariosRelatedByIdusuario || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collUsuariosRelatedByIdusuario) {
                    $this->initUsuariosRelatedByIdusuario();
                }
            } else {

                $query = ChildUsuarioQuery::create(null, $criteria)
                    ->filterByUsuarioRelatedByIdamigo($this);
                $collUsuariosRelatedByIdusuario = $query->find($con);
                if (null !== $criteria) {
                    return $collUsuariosRelatedByIdusuario;
                }

                if ($partial && $this->collUsuariosRelatedByIdusuario) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collUsuariosRelatedByIdusuario as $obj) {
                        if (!$collUsuariosRelatedByIdusuario->contains($obj)) {
                            $collUsuariosRelatedByIdusuario[] = $obj;
                        }
                    }
                }

                $this->collUsuariosRelatedByIdusuario = $collUsuariosRelatedByIdusuario;
                $this->collUsuariosRelatedByIdusuarioPartial = false;
            }
        }

        return $this->collUsuariosRelatedByIdusuario;
    }

    /**
     * Sets a collection of Usuario objects related by a many-to-many relationship
     * to the current object by way of the usuario_amigo cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $usuariosRelatedByIdusuario A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setUsuariosRelatedByIdusuario(Collection $usuariosRelatedByIdusuario, ConnectionInterface $con = null)
    {
        $this->clearUsuariosRelatedByIdusuario();
        $currentUsuariosRelatedByIdusuario = $this->getUsuariosRelatedByIdusuario();

        $usuariosRelatedByIdusuarioScheduledForDeletion = $currentUsuariosRelatedByIdusuario->diff($usuariosRelatedByIdusuario);

        foreach ($usuariosRelatedByIdusuarioScheduledForDeletion as $toDelete) {
            $this->removeUsuarioRelatedByIdusuario($toDelete);
        }

        foreach ($usuariosRelatedByIdusuario as $usuarioRelatedByIdusuario) {
            if (!$currentUsuariosRelatedByIdusuario->contains($usuarioRelatedByIdusuario)) {
                $this->doAddUsuarioRelatedByIdusuario($usuarioRelatedByIdusuario);
            }
        }

        $this->collUsuariosRelatedByIdusuarioPartial = false;
        $this->collUsuariosRelatedByIdusuario = $usuariosRelatedByIdusuario;

        return $this;
    }

    /**
     * Gets the number of Usuario objects related by a many-to-many relationship
     * to the current object by way of the usuario_amigo cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Usuario objects
     */
    public function countUsuariosRelatedByIdusuario(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuariosRelatedByIdusuarioPartial && !$this->isNew();
        if (null === $this->collUsuariosRelatedByIdusuario || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsuariosRelatedByIdusuario) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getUsuariosRelatedByIdusuario());
                }

                $query = ChildUsuarioQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUsuarioRelatedByIdamigo($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsuariosRelatedByIdusuario);
        }
    }

    /**
     * Associate a ChildUsuario to this object
     * through the usuario_amigo cross reference table.
     * 
     * @param ChildUsuario $usuarioRelatedByIdusuario
     * @return ChildUsuario The current object (for fluent API support)
     */
    public function addUsuarioRelatedByIdusuario(ChildUsuario $usuarioRelatedByIdusuario)
    {
        if ($this->collUsuariosRelatedByIdusuario === null) {
            $this->initUsuariosRelatedByIdusuario();
        }

        if (!$this->getUsuariosRelatedByIdusuario()->contains($usuarioRelatedByIdusuario)) {
            // only add it if the **same** object is not already associated
            $this->collUsuariosRelatedByIdusuario->push($usuarioRelatedByIdusuario);
            $this->doAddUsuarioRelatedByIdusuario($usuarioRelatedByIdusuario);
        }

        return $this;
    }

    /**
     * 
     * @param ChildUsuario $usuarioRelatedByIdusuario
     */
    protected function doAddUsuarioRelatedByIdusuario(ChildUsuario $usuarioRelatedByIdusuario)
    {
        $usuarioAmigo = new ChildUsuarioAmigo();

        $usuarioAmigo->setUsuarioRelatedByIdusuario($usuarioRelatedByIdusuario);

        $usuarioAmigo->setUsuarioRelatedByIdamigo($this);

        $this->addUsuarioAmigoRelatedByIdamigo($usuarioAmigo);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$usuarioRelatedByIdusuario->isUsuariosRelatedByIdamigoLoaded()) {
            $usuarioRelatedByIdusuario->initUsuariosRelatedByIdamigo();
            $usuarioRelatedByIdusuario->getUsuariosRelatedByIdamigo()->push($this);
        } elseif (!$usuarioRelatedByIdusuario->getUsuariosRelatedByIdamigo()->contains($this)) {
            $usuarioRelatedByIdusuario->getUsuariosRelatedByIdamigo()->push($this);
        }

    }

    /**
     * Remove usuarioRelatedByIdusuario of this object
     * through the usuario_amigo cross reference table.
     * 
     * @param ChildUsuario $usuarioRelatedByIdusuario
     * @return ChildUsuario The current object (for fluent API support)
     */
    public function removeUsuarioRelatedByIdusuario(ChildUsuario $usuarioRelatedByIdusuario)
    {
        if ($this->getUsuariosRelatedByIdusuario()->contains($usuarioRelatedByIdusuario)) { $usuarioAmigo = new ChildUsuarioAmigo();

            $usuarioAmigo->setUsuarioRelatedByIdusuario($usuarioRelatedByIdusuario);
            if ($usuarioRelatedByIdusuario->isUsuarioRelatedByIdamigosLoaded()) {
                //remove the back reference if available
                $usuarioRelatedByIdusuario->getUsuarioRelatedByIdamigos()->removeObject($this);
            }

            $usuarioAmigo->setUsuarioRelatedByIdamigo($this);
            $this->removeUsuarioAmigoRelatedByIdamigo(clone $usuarioAmigo);
            $usuarioAmigo->clear();

            $this->collUsuariosRelatedByIdusuario->remove($this->collUsuariosRelatedByIdusuario->search($usuarioRelatedByIdusuario));
            
            if (null === $this->usuariosRelatedByIdusuarioScheduledForDeletion) {
                $this->usuariosRelatedByIdusuarioScheduledForDeletion = clone $this->collUsuariosRelatedByIdusuario;
                $this->usuariosRelatedByIdusuarioScheduledForDeletion->clear();
            }

            $this->usuariosRelatedByIdusuarioScheduledForDeletion->push($usuarioRelatedByIdusuario);
        }


        return $this;
    }

    /**
     * Clears out the collGrupos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGrupos()
     */
    public function clearGrupos()
    {
        $this->collGrupos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collGrupos crossRef collection.
     *
     * By default this just sets the collGrupos collection to an empty collection (like clearGrupos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initGrupos()
    {
        $collectionClassName = MiembrosGrupoTableMap::getTableMap()->getCollectionClassName();

        $this->collGrupos = new $collectionClassName;
        $this->collGruposPartial = true;
        $this->collGrupos->setModel('\Grupo');
    }

    /**
     * Checks if the collGrupos collection is loaded.
     *
     * @return bool
     */
    public function isGruposLoaded()
    {
        return null !== $this->collGrupos;
    }

    /**
     * Gets a collection of ChildGrupo objects related by a many-to-many relationship
     * to the current object by way of the miembros_grupo cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildGrupo[] List of ChildGrupo objects
     */
    public function getGrupos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGruposPartial && !$this->isNew();
        if (null === $this->collGrupos || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collGrupos) {
                    $this->initGrupos();
                }
            } else {

                $query = ChildGrupoQuery::create(null, $criteria)
                    ->filterByUsuario($this);
                $collGrupos = $query->find($con);
                if (null !== $criteria) {
                    return $collGrupos;
                }

                if ($partial && $this->collGrupos) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collGrupos as $obj) {
                        if (!$collGrupos->contains($obj)) {
                            $collGrupos[] = $obj;
                        }
                    }
                }

                $this->collGrupos = $collGrupos;
                $this->collGruposPartial = false;
            }
        }

        return $this->collGrupos;
    }

    /**
     * Sets a collection of Grupo objects related by a many-to-many relationship
     * to the current object by way of the miembros_grupo cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $grupos A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setGrupos(Collection $grupos, ConnectionInterface $con = null)
    {
        $this->clearGrupos();
        $currentGrupos = $this->getGrupos();

        $gruposScheduledForDeletion = $currentGrupos->diff($grupos);

        foreach ($gruposScheduledForDeletion as $toDelete) {
            $this->removeGrupo($toDelete);
        }

        foreach ($grupos as $grupo) {
            if (!$currentGrupos->contains($grupo)) {
                $this->doAddGrupo($grupo);
            }
        }

        $this->collGruposPartial = false;
        $this->collGrupos = $grupos;

        return $this;
    }

    /**
     * Gets the number of Grupo objects related by a many-to-many relationship
     * to the current object by way of the miembros_grupo cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Grupo objects
     */
    public function countGrupos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGruposPartial && !$this->isNew();
        if (null === $this->collGrupos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGrupos) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getGrupos());
                }

                $query = ChildGrupoQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUsuario($this)
                    ->count($con);
            }
        } else {
            return count($this->collGrupos);
        }
    }

    /**
     * Associate a ChildGrupo to this object
     * through the miembros_grupo cross reference table.
     * 
     * @param ChildGrupo $grupo
     * @return ChildUsuario The current object (for fluent API support)
     */
    public function addGrupo(ChildGrupo $grupo)
    {
        if ($this->collGrupos === null) {
            $this->initGrupos();
        }

        if (!$this->getGrupos()->contains($grupo)) {
            // only add it if the **same** object is not already associated
            $this->collGrupos->push($grupo);
            $this->doAddGrupo($grupo);
        }

        return $this;
    }

    /**
     * 
     * @param ChildGrupo $grupo
     */
    protected function doAddGrupo(ChildGrupo $grupo)
    {
        $miembrosGrupo = new ChildMiembrosGrupo();

        $miembrosGrupo->setGrupo($grupo);

        $miembrosGrupo->setUsuario($this);

        $this->addMiembrosGrupo($miembrosGrupo);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$grupo->isUsuariosLoaded()) {
            $grupo->initUsuarios();
            $grupo->getUsuarios()->push($this);
        } elseif (!$grupo->getUsuarios()->contains($this)) {
            $grupo->getUsuarios()->push($this);
        }

    }

    /**
     * Remove grupo of this object
     * through the miembros_grupo cross reference table.
     * 
     * @param ChildGrupo $grupo
     * @return ChildUsuario The current object (for fluent API support)
     */
    public function removeGrupo(ChildGrupo $grupo)
    {
        if ($this->getGrupos()->contains($grupo)) { $miembrosGrupo = new ChildMiembrosGrupo();

            $miembrosGrupo->setGrupo($grupo);
            if ($grupo->isUsuariosLoaded()) {
                //remove the back reference if available
                $grupo->getUsuarios()->removeObject($this);
            }

            $miembrosGrupo->setUsuario($this);
            $this->removeMiembrosGrupo(clone $miembrosGrupo);
            $miembrosGrupo->clear();

            $this->collGrupos->remove($this->collGrupos->search($grupo));
            
            if (null === $this->gruposScheduledForDeletion) {
                $this->gruposScheduledForDeletion = clone $this->collGrupos;
                $this->gruposScheduledForDeletion->clear();
            }

            $this->gruposScheduledForDeletion->push($grupo);
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
        $collectionClassName = ViajeUsuarioTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the viaje_usuario cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
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
                    ->filterByUsuario($this);
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
     * to the current object by way of the viaje_usuario cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $viajes A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
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
     * to the current object by way of the viaje_usuario cross-reference table.
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
                    ->filterByUsuario($this)
                    ->count($con);
            }
        } else {
            return count($this->collViajes);
        }
    }

    /**
     * Associate a ChildViaje to this object
     * through the viaje_usuario cross reference table.
     * 
     * @param ChildViaje $viaje
     * @return ChildUsuario The current object (for fluent API support)
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
        $viajeUsuario = new ChildViajeUsuario();

        $viajeUsuario->setViaje($viaje);

        $viajeUsuario->setUsuario($this);

        $this->addViajeUsuario($viajeUsuario);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$viaje->isUsuariosLoaded()) {
            $viaje->initUsuarios();
            $viaje->getUsuarios()->push($this);
        } elseif (!$viaje->getUsuarios()->contains($this)) {
            $viaje->getUsuarios()->push($this);
        }

    }

    /**
     * Remove viaje of this object
     * through the viaje_usuario cross reference table.
     * 
     * @param ChildViaje $viaje
     * @return ChildUsuario The current object (for fluent API support)
     */
    public function removeViaje(ChildViaje $viaje)
    {
        if ($this->getViajes()->contains($viaje)) { $viajeUsuario = new ChildViajeUsuario();

            $viajeUsuario->setViaje($viaje);
            if ($viaje->isUsuariosLoaded()) {
                //remove the back reference if available
                $viaje->getUsuarios()->removeObject($this);
            }

            $viajeUsuario->setUsuario($this);
            $this->removeViajeUsuario(clone $viajeUsuario);
            $viajeUsuario->clear();

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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPerfil) {
            $this->aPerfil->removeUsuario($this);
        }
        $this->idusuario = null;
        $this->password = null;
        $this->nombre = null;
        $this->apellidos = null;
        $this->avatar = null;
        $this->email = null;
        $this->idperfil = null;
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
            if ($this->collInvitacions) {
                foreach ($this->collInvitacions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsuarioAmigosRelatedByIdusuario) {
                foreach ($this->collUsuarioAmigosRelatedByIdusuario as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsuarioAmigosRelatedByIdamigo) {
                foreach ($this->collUsuarioAmigosRelatedByIdamigo as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMiembrosGrupos) {
                foreach ($this->collMiembrosGrupos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collViajeUsuarios) {
                foreach ($this->collViajeUsuarios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMensajes) {
                foreach ($this->collMensajes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsuariosRelatedByIdamigo) {
                foreach ($this->collUsuariosRelatedByIdamigo as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsuariosRelatedByIdusuario) {
                foreach ($this->collUsuariosRelatedByIdusuario as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGrupos) {
                foreach ($this->collGrupos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collViajes) {
                foreach ($this->collViajes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collInvitacions = null;
        $this->collUsuarioAmigosRelatedByIdusuario = null;
        $this->collUsuarioAmigosRelatedByIdamigo = null;
        $this->collMiembrosGrupos = null;
        $this->collViajeUsuarios = null;
        $this->collMensajes = null;
        $this->collUsuariosRelatedByIdamigo = null;
        $this->collUsuariosRelatedByIdusuario = null;
        $this->collGrupos = null;
        $this->collViajes = null;
        $this->aPerfil = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsuarioTableMap::DEFAULT_STRING_FORMAT);
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
