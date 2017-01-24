<?php

namespace Base;

use \Grupo as ChildGrupo;
use \GrupoQuery as ChildGrupoQuery;
use \GrupoViaje as ChildGrupoViaje;
use \GrupoViajeQuery as ChildGrupoViajeQuery;
use \Mensaje as ChildMensaje;
use \MensajeQuery as ChildMensajeQuery;
use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \Viaje as ChildViaje;
use \ViajeMensajes as ChildViajeMensajes;
use \ViajeMensajesQuery as ChildViajeMensajesQuery;
use \ViajeQuery as ChildViajeQuery;
use \ViajeUsuario as ChildViajeUsuario;
use \ViajeUsuarioQuery as ChildViajeUsuarioQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\GrupoViajeTableMap;
use Map\ViajeMensajesTableMap;
use Map\ViajeTableMap;
use Map\ViajeUsuarioTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Collection\ObjectCombinationCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'viaje' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class Viaje implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ViajeTableMap';


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
     * The value for the idviaje field.
     * 
     * @var        int
     */
    protected $idviaje;

    /**
     * The value for the nombre field.
     * 
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the informacion field.
     * 
     * @var        string
     */
    protected $informacion;

    /**
     * The value for the transporte field.
     * 
     * @var        string
     */
    protected $transporte;

    /**
     * The value for the hospedaje field.
     * 
     * @var        string
     */
    protected $hospedaje;

    /**
     * The value for the destino field.
     * 
     * @var        string
     */
    protected $destino;

    /**
     * The value for the fecha_inicio field.
     * 
     * @var        DateTime
     */
    protected $fecha_inicio;

    /**
     * The value for the fecha_final field.
     * 
     * @var        DateTime
     */
    protected $fecha_final;

    /**
     * The value for the precio field.
     * 
     * @var        double
     */
    protected $precio;

    /**
     * The value for the imagenes field.
     * 
     * @var        array
     */
    protected $imagenes;

    /**
     * The unserialized $imagenes value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $imagenes_unserialized;

    /**
     * The value for the etiquetas field.
     * 
     * @var        array
     */
    protected $etiquetas;

    /**
     * The unserialized $etiquetas value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $etiquetas_unserialized;

    /**
     * @var        ObjectCollection|ChildViajeMensajes[] Collection to store aggregation of ChildViajeMensajes objects.
     */
    protected $collViajeMensajess;
    protected $collViajeMensajessPartial;

    /**
     * @var        ObjectCollection|ChildViajeUsuario[] Collection to store aggregation of ChildViajeUsuario objects.
     */
    protected $collViajeUsuarios;
    protected $collViajeUsuariosPartial;

    /**
     * @var        ObjectCollection|ChildGrupoViaje[] Collection to store aggregation of ChildGrupoViaje objects.
     */
    protected $collGrupoViajes;
    protected $collGrupoViajesPartial;

    /**
     * @var        ObjectCollection|ChildMensaje[] Cross Collection to store aggregation of ChildMensaje objects.
     */
    protected $collMensajes;

    /**
     * @var bool
     */
    protected $collMensajesPartial;

    /**
     * @var        ObjectCollection|ChildUsuario[] Cross Collection to store aggregation of ChildUsuario objects.
     */
    protected $collUsuarios;

    /**
     * @var bool
     */
    protected $collUsuariosPartial;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildGrupo combinations.
     */
    protected $combinationCollGrupoFavoritos;

    /**
     * @var bool
     */
    protected $combinationCollGrupoFavoritosPartial;

    /**
     * @var        ObjectCollection|ChildGrupo[] Cross Collection to store aggregation of ChildGrupo objects.
     */
    protected $collGrupos;

    /**
     * @var bool
     */
    protected $collGruposPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMensaje[]
     */
    protected $mensajesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUsuario[]
     */
    protected $usuariosScheduledForDeletion = null;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildGrupo combinations.
     */
    protected $combinationCollGrupoFavoritosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildViajeMensajes[]
     */
    protected $viajeMensajessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildViajeUsuario[]
     */
    protected $viajeUsuariosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGrupoViaje[]
     */
    protected $grupoViajesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Viaje object.
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
     * Compares this with another <code>Viaje</code> instance.  If
     * <code>obj</code> is an instance of <code>Viaje</code>, delegates to
     * <code>equals(Viaje)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Viaje The current object, for fluid interface
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
     * Get the [idviaje] column value.
     * 
     * @return int
     */
    public function getIdviaje()
    {
        return $this->idviaje;
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
     * Get the [informacion] column value.
     * 
     * @return string
     */
    public function getInformacion()
    {
        return $this->informacion;
    }

    /**
     * Get the [transporte] column value.
     * 
     * @return string
     */
    public function getTransporte()
    {
        return $this->transporte;
    }

    /**
     * Get the [hospedaje] column value.
     * 
     * @return string
     */
    public function getHospedaje()
    {
        return $this->hospedaje;
    }

    /**
     * Get the [destino] column value.
     * 
     * @return string
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Get the [optionally formatted] temporal [fecha_inicio] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaInicio($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_inicio;
        } else {
            return $this->fecha_inicio instanceof \DateTimeInterface ? $this->fecha_inicio->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [fecha_final] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaFinal($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_final;
        } else {
            return $this->fecha_final instanceof \DateTimeInterface ? $this->fecha_final->format($format) : null;
        }
    }

    /**
     * Get the [precio] column value.
     * 
     * @return double
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Get the [imagenes] column value.
     * 
     * @return array
     */
    public function getImagenes()
    {
        if (null === $this->imagenes_unserialized) {
            $this->imagenes_unserialized = array();
        }
        if (!$this->imagenes_unserialized && null !== $this->imagenes) {
            $imagenes_unserialized = substr($this->imagenes, 2, -2);
            $this->imagenes_unserialized = $imagenes_unserialized ? explode(' | ', $imagenes_unserialized) : array();
        }

        return $this->imagenes_unserialized;
    }

    /**
     * Test the presence of a value in the [imagenes] array column value.
     * @param      mixed $value
     * 
     * @return boolean
     */
    public function hasImagene($value)
    {
        return in_array($value, $this->getImagenes());
    } // hasImagene()

    /**
     * Get the [etiquetas] column value.
     * 
     * @return array
     */
    public function getEtiquetas()
    {
        if (null === $this->etiquetas_unserialized) {
            $this->etiquetas_unserialized = array();
        }
        if (!$this->etiquetas_unserialized && null !== $this->etiquetas) {
            $etiquetas_unserialized = substr($this->etiquetas, 2, -2);
            $this->etiquetas_unserialized = $etiquetas_unserialized ? explode(' | ', $etiquetas_unserialized) : array();
        }

        return $this->etiquetas_unserialized;
    }

    /**
     * Test the presence of a value in the [etiquetas] array column value.
     * @param      mixed $value
     * 
     * @return boolean
     */
    public function hasEtiqueta($value)
    {
        return in_array($value, $this->getEtiquetas());
    } // hasEtiqueta()

    /**
     * Set the value of [idviaje] column.
     * 
     * @param int $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setIdviaje($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idviaje !== $v) {
            $this->idviaje = $v;
            $this->modifiedColumns[ViajeTableMap::COL_IDVIAJE] = true;
        }

        return $this;
    } // setIdviaje()

    /**
     * Set the value of [nombre] column.
     * 
     * @param string $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[ViajeTableMap::COL_NOMBRE] = true;
        }

        return $this;
    } // setNombre()

    /**
     * Set the value of [informacion] column.
     * 
     * @param string $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setInformacion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->informacion !== $v) {
            $this->informacion = $v;
            $this->modifiedColumns[ViajeTableMap::COL_INFORMACION] = true;
        }

        return $this;
    } // setInformacion()

    /**
     * Set the value of [transporte] column.
     * 
     * @param string $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setTransporte($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->transporte !== $v) {
            $this->transporte = $v;
            $this->modifiedColumns[ViajeTableMap::COL_TRANSPORTE] = true;
        }

        return $this;
    } // setTransporte()

    /**
     * Set the value of [hospedaje] column.
     * 
     * @param string $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setHospedaje($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hospedaje !== $v) {
            $this->hospedaje = $v;
            $this->modifiedColumns[ViajeTableMap::COL_HOSPEDAJE] = true;
        }

        return $this;
    } // setHospedaje()

    /**
     * Set the value of [destino] column.
     * 
     * @param string $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setDestino($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->destino !== $v) {
            $this->destino = $v;
            $this->modifiedColumns[ViajeTableMap::COL_DESTINO] = true;
        }

        return $this;
    } // setDestino()

    /**
     * Sets the value of [fecha_inicio] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setFechaInicio($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_inicio !== null || $dt !== null) {
            if ($this->fecha_inicio === null || $dt === null || $dt->format("Y-m-d") !== $this->fecha_inicio->format("Y-m-d")) {
                $this->fecha_inicio = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ViajeTableMap::COL_FECHA_INICIO] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaInicio()

    /**
     * Sets the value of [fecha_final] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setFechaFinal($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_final !== null || $dt !== null) {
            if ($this->fecha_final === null || $dt === null || $dt->format("Y-m-d") !== $this->fecha_final->format("Y-m-d")) {
                $this->fecha_final = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ViajeTableMap::COL_FECHA_FINAL] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaFinal()

    /**
     * Set the value of [precio] column.
     * 
     * @param double $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setPrecio($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->precio !== $v) {
            $this->precio = $v;
            $this->modifiedColumns[ViajeTableMap::COL_PRECIO] = true;
        }

        return $this;
    } // setPrecio()

    /**
     * Set the value of [imagenes] column.
     * 
     * @param array $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setImagenes($v)
    {
        if ($this->imagenes_unserialized !== $v) {
            $this->imagenes_unserialized = $v;
            $this->imagenes = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[ViajeTableMap::COL_IMAGENES] = true;
        }

        return $this;
    } // setImagenes()

    /**
     * Adds a value to the [imagenes] array column value.
     * @param  mixed $value
     * 
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function addImagene($value)
    {
        $currentArray = $this->getImagenes();
        $currentArray []= $value;
        $this->setImagenes($currentArray);

        return $this;
    } // addImagene()

    /**
     * Removes a value from the [imagenes] array column value.
     * @param  mixed $value
     * 
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function removeImagene($value)
    {
        $targetArray = array();
        foreach ($this->getImagenes() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setImagenes($targetArray);

        return $this;
    } // removeImagene()

    /**
     * Set the value of [etiquetas] column.
     * 
     * @param array $v new value
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function setEtiquetas($v)
    {
        if ($this->etiquetas_unserialized !== $v) {
            $this->etiquetas_unserialized = $v;
            $this->etiquetas = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[ViajeTableMap::COL_ETIQUETAS] = true;
        }

        return $this;
    } // setEtiquetas()

    /**
     * Adds a value to the [etiquetas] array column value.
     * @param  mixed $value
     * 
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function addEtiqueta($value)
    {
        $currentArray = $this->getEtiquetas();
        $currentArray []= $value;
        $this->setEtiquetas($currentArray);

        return $this;
    } // addEtiqueta()

    /**
     * Removes a value from the [etiquetas] array column value.
     * @param  mixed $value
     * 
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function removeEtiqueta($value)
    {
        $targetArray = array();
        foreach ($this->getEtiquetas() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setEtiquetas($targetArray);

        return $this;
    } // removeEtiqueta()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ViajeTableMap::translateFieldName('Idviaje', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idviaje = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ViajeTableMap::translateFieldName('Nombre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nombre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ViajeTableMap::translateFieldName('Informacion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->informacion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ViajeTableMap::translateFieldName('Transporte', TableMap::TYPE_PHPNAME, $indexType)];
            $this->transporte = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ViajeTableMap::translateFieldName('Hospedaje', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hospedaje = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ViajeTableMap::translateFieldName('Destino', TableMap::TYPE_PHPNAME, $indexType)];
            $this->destino = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ViajeTableMap::translateFieldName('FechaInicio', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->fecha_inicio = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ViajeTableMap::translateFieldName('FechaFinal', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->fecha_final = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ViajeTableMap::translateFieldName('Precio', TableMap::TYPE_PHPNAME, $indexType)];
            $this->precio = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ViajeTableMap::translateFieldName('Imagenes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imagenes = $col;
            $this->imagenes_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ViajeTableMap::translateFieldName('Etiquetas', TableMap::TYPE_PHPNAME, $indexType)];
            $this->etiquetas = $col;
            $this->etiquetas_unserialized = null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = ViajeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Viaje'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ViajeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildViajeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collViajeMensajess = null;

            $this->collViajeUsuarios = null;

            $this->collGrupoViajes = null;

            $this->collMensajes = null;
            $this->collUsuarios = null;
            $this->collGrupoFavoritos = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Viaje::setDeleted()
     * @see Viaje::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildViajeQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeTableMap::DATABASE_NAME);
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
                ViajeTableMap::addInstanceToPool($this);
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

            if ($this->mensajesScheduledForDeletion !== null) {
                if (!$this->mensajesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->mensajesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getIdviaje();
                        $entryPk[1] = $entry->getIdmensaje();
                        $pks[] = $entryPk;
                    }

                    \ViajeMensajesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->mensajesScheduledForDeletion = null;
                }

            }

            if ($this->collMensajes) {
                foreach ($this->collMensajes as $mensaje) {
                    if (!$mensaje->isDeleted() && ($mensaje->isNew() || $mensaje->isModified())) {
                        $mensaje->save($con);
                    }
                }
            }


            if ($this->usuariosScheduledForDeletion !== null) {
                if (!$this->usuariosScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->usuariosScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getIdviaje();
                        $entryPk[1] = $entry->getIdusuario();
                        $pks[] = $entryPk;
                    }

                    \ViajeUsuarioQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->usuariosScheduledForDeletion = null;
                }

            }

            if ($this->collUsuarios) {
                foreach ($this->collUsuarios as $usuario) {
                    if (!$usuario->isDeleted() && ($usuario->isNew() || $usuario->isModified())) {
                        $usuario->save($con);
                    }
                }
            }


            if ($this->combinationCollGrupoFavoritosScheduledForDeletion !== null) {
                if (!$this->combinationCollGrupoFavoritosScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->combinationCollGrupoFavoritosScheduledForDeletion as $combination) {
                        $entryPk = [];

                        $entryPk[1] = $this->getIdviaje();
                        $entryPk[0] = $combination[0]->getIdgrupo();
                        //$combination[1] = Favorito;
                        $entryPk[2] = $combination[1];

                        $pks[] = $entryPk;
                    }

                    \GrupoViajeQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollGrupoFavoritosScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollGrupoFavoritos) {
                foreach ($this->combinationCollGrupoFavoritos as $combination) {

                    //$combination[0] = Grupo (grupo_viaje_fk_4e8c68)
                    if (!$combination[0]->isDeleted() && ($combination[0]->isNew() || $combination[0]->isModified())) {
                        $combination[0]->save($con);
                    }
                
                    //$combination[1] = Favorito; Nothing to save.
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

            if ($this->grupoViajesScheduledForDeletion !== null) {
                if (!$this->grupoViajesScheduledForDeletion->isEmpty()) {
                    \GrupoViajeQuery::create()
                        ->filterByPrimaryKeys($this->grupoViajesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->grupoViajesScheduledForDeletion = null;
                }
            }

            if ($this->collGrupoViajes !== null) {
                foreach ($this->collGrupoViajes as $referrerFK) {
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

        $this->modifiedColumns[ViajeTableMap::COL_IDVIAJE] = true;
        if (null !== $this->idviaje) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ViajeTableMap::COL_IDVIAJE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ViajeTableMap::COL_IDVIAJE)) {
            $modifiedColumns[':p' . $index++]  = 'idviaje';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = 'nombre';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_INFORMACION)) {
            $modifiedColumns[':p' . $index++]  = 'informacion';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_TRANSPORTE)) {
            $modifiedColumns[':p' . $index++]  = 'transporte';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_HOSPEDAJE)) {
            $modifiedColumns[':p' . $index++]  = 'hospedaje';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_DESTINO)) {
            $modifiedColumns[':p' . $index++]  = 'destino';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_FECHA_INICIO)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_inicio';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_FECHA_FINAL)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_final';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_PRECIO)) {
            $modifiedColumns[':p' . $index++]  = 'precio';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_IMAGENES)) {
            $modifiedColumns[':p' . $index++]  = 'imagenes';
        }
        if ($this->isColumnModified(ViajeTableMap::COL_ETIQUETAS)) {
            $modifiedColumns[':p' . $index++]  = 'etiquetas';
        }

        $sql = sprintf(
            'INSERT INTO viaje (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idviaje':                        
                        $stmt->bindValue($identifier, $this->idviaje, PDO::PARAM_INT);
                        break;
                    case 'nombre':                        
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case 'informacion':                        
                        $stmt->bindValue($identifier, $this->informacion, PDO::PARAM_STR);
                        break;
                    case 'transporte':                        
                        $stmt->bindValue($identifier, $this->transporte, PDO::PARAM_STR);
                        break;
                    case 'hospedaje':                        
                        $stmt->bindValue($identifier, $this->hospedaje, PDO::PARAM_STR);
                        break;
                    case 'destino':                        
                        $stmt->bindValue($identifier, $this->destino, PDO::PARAM_STR);
                        break;
                    case 'fecha_inicio':                        
                        $stmt->bindValue($identifier, $this->fecha_inicio ? $this->fecha_inicio->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'fecha_final':                        
                        $stmt->bindValue($identifier, $this->fecha_final ? $this->fecha_final->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'precio':                        
                        $stmt->bindValue($identifier, $this->precio, PDO::PARAM_STR);
                        break;
                    case 'imagenes':                        
                        $stmt->bindValue($identifier, $this->imagenes, PDO::PARAM_STR);
                        break;
                    case 'etiquetas':                        
                        $stmt->bindValue($identifier, $this->etiquetas, PDO::PARAM_STR);
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
        $this->setIdviaje($pk);

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
        $pos = ViajeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdviaje();
                break;
            case 1:
                return $this->getNombre();
                break;
            case 2:
                return $this->getInformacion();
                break;
            case 3:
                return $this->getTransporte();
                break;
            case 4:
                return $this->getHospedaje();
                break;
            case 5:
                return $this->getDestino();
                break;
            case 6:
                return $this->getFechaInicio();
                break;
            case 7:
                return $this->getFechaFinal();
                break;
            case 8:
                return $this->getPrecio();
                break;
            case 9:
                return $this->getImagenes();
                break;
            case 10:
                return $this->getEtiquetas();
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

        if (isset($alreadyDumpedObjects['Viaje'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Viaje'][$this->hashCode()] = true;
        $keys = ViajeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdviaje(),
            $keys[1] => $this->getNombre(),
            $keys[2] => $this->getInformacion(),
            $keys[3] => $this->getTransporte(),
            $keys[4] => $this->getHospedaje(),
            $keys[5] => $this->getDestino(),
            $keys[6] => $this->getFechaInicio(),
            $keys[7] => $this->getFechaFinal(),
            $keys[8] => $this->getPrecio(),
            $keys[9] => $this->getImagenes(),
            $keys[10] => $this->getEtiquetas(),
        );
        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }
        
        if ($result[$keys[7]] instanceof \DateTime) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
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
            if (null !== $this->collGrupoViajes) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'grupoViajes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'grupo_viajes';
                        break;
                    default:
                        $key = 'GrupoViajes';
                }
        
                $result[$key] = $this->collGrupoViajes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Viaje
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ViajeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Viaje
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdviaje($value);
                break;
            case 1:
                $this->setNombre($value);
                break;
            case 2:
                $this->setInformacion($value);
                break;
            case 3:
                $this->setTransporte($value);
                break;
            case 4:
                $this->setHospedaje($value);
                break;
            case 5:
                $this->setDestino($value);
                break;
            case 6:
                $this->setFechaInicio($value);
                break;
            case 7:
                $this->setFechaFinal($value);
                break;
            case 8:
                $this->setPrecio($value);
                break;
            case 9:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setImagenes($value);
                break;
            case 10:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setEtiquetas($value);
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
        $keys = ViajeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdviaje($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNombre($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setInformacion($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTransporte($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setHospedaje($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDestino($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFechaInicio($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setFechaFinal($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPrecio($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setImagenes($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setEtiquetas($arr[$keys[10]]);
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
     * @return $this|\Viaje The current object, for fluid interface
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
        $criteria = new Criteria(ViajeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ViajeTableMap::COL_IDVIAJE)) {
            $criteria->add(ViajeTableMap::COL_IDVIAJE, $this->idviaje);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_NOMBRE)) {
            $criteria->add(ViajeTableMap::COL_NOMBRE, $this->nombre);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_INFORMACION)) {
            $criteria->add(ViajeTableMap::COL_INFORMACION, $this->informacion);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_TRANSPORTE)) {
            $criteria->add(ViajeTableMap::COL_TRANSPORTE, $this->transporte);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_HOSPEDAJE)) {
            $criteria->add(ViajeTableMap::COL_HOSPEDAJE, $this->hospedaje);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_DESTINO)) {
            $criteria->add(ViajeTableMap::COL_DESTINO, $this->destino);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_FECHA_INICIO)) {
            $criteria->add(ViajeTableMap::COL_FECHA_INICIO, $this->fecha_inicio);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_FECHA_FINAL)) {
            $criteria->add(ViajeTableMap::COL_FECHA_FINAL, $this->fecha_final);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_PRECIO)) {
            $criteria->add(ViajeTableMap::COL_PRECIO, $this->precio);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_IMAGENES)) {
            $criteria->add(ViajeTableMap::COL_IMAGENES, $this->imagenes);
        }
        if ($this->isColumnModified(ViajeTableMap::COL_ETIQUETAS)) {
            $criteria->add(ViajeTableMap::COL_ETIQUETAS, $this->etiquetas);
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
        $criteria = ChildViajeQuery::create();
        $criteria->add(ViajeTableMap::COL_IDVIAJE, $this->idviaje);

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
        $validPk = null !== $this->getIdviaje();

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
        return $this->getIdviaje();
    }

    /**
     * Generic method to set the primary key (idviaje column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdviaje($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdviaje();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Viaje (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNombre($this->getNombre());
        $copyObj->setInformacion($this->getInformacion());
        $copyObj->setTransporte($this->getTransporte());
        $copyObj->setHospedaje($this->getHospedaje());
        $copyObj->setDestino($this->getDestino());
        $copyObj->setFechaInicio($this->getFechaInicio());
        $copyObj->setFechaFinal($this->getFechaFinal());
        $copyObj->setPrecio($this->getPrecio());
        $copyObj->setImagenes($this->getImagenes());
        $copyObj->setEtiquetas($this->getEtiquetas());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getViajeMensajess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addViajeMensajes($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getViajeUsuarios() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addViajeUsuario($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGrupoViajes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGrupoViaje($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdviaje(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Viaje Clone of current object.
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
        if ('ViajeMensajes' == $relationName) {
            return $this->initViajeMensajess();
        }
        if ('ViajeUsuario' == $relationName) {
            return $this->initViajeUsuarios();
        }
        if ('GrupoViaje' == $relationName) {
            return $this->initGrupoViajes();
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
     * If this ChildViaje is new, it will return
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
                    ->filterByViaje($this)
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
     * @return $this|ChildViaje The current object (for fluent API support)
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
            $viajeMensajesRemoved->setViaje(null);
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
                ->filterByViaje($this)
                ->count($con);
        }

        return count($this->collViajeMensajess);
    }

    /**
     * Method called to associate a ChildViajeMensajes object to this object
     * through the ChildViajeMensajes foreign key attribute.
     *
     * @param  ChildViajeMensajes $l ChildViajeMensajes
     * @return $this|\Viaje The current object (for fluent API support)
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
        $viajeMensajes->setViaje($this);
    }

    /**
     * @param  ChildViajeMensajes $viajeMensajes The ChildViajeMensajes object to remove.
     * @return $this|ChildViaje The current object (for fluent API support)
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
            $viajeMensajes->setViaje(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Viaje is new, it will return
     * an empty collection; or if this Viaje has previously
     * been saved, it will retrieve related ViajeMensajess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Viaje.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildViajeMensajes[] List of ChildViajeMensajes objects
     */
    public function getViajeMensajessJoinMensaje(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildViajeMensajesQuery::create(null, $criteria);
        $query->joinWith('Mensaje', $joinBehavior);

        return $this->getViajeMensajess($query, $con);
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
     * If this ChildViaje is new, it will return
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
                    ->filterByViaje($this)
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
     * @return $this|ChildViaje The current object (for fluent API support)
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
            $viajeUsuarioRemoved->setViaje(null);
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
                ->filterByViaje($this)
                ->count($con);
        }

        return count($this->collViajeUsuarios);
    }

    /**
     * Method called to associate a ChildViajeUsuario object to this object
     * through the ChildViajeUsuario foreign key attribute.
     *
     * @param  ChildViajeUsuario $l ChildViajeUsuario
     * @return $this|\Viaje The current object (for fluent API support)
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
        $viajeUsuario->setViaje($this);
    }

    /**
     * @param  ChildViajeUsuario $viajeUsuario The ChildViajeUsuario object to remove.
     * @return $this|ChildViaje The current object (for fluent API support)
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
            $viajeUsuario->setViaje(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Viaje is new, it will return
     * an empty collection; or if this Viaje has previously
     * been saved, it will retrieve related ViajeUsuarios from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Viaje.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildViajeUsuario[] List of ChildViajeUsuario objects
     */
    public function getViajeUsuariosJoinUsuario(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildViajeUsuarioQuery::create(null, $criteria);
        $query->joinWith('Usuario', $joinBehavior);

        return $this->getViajeUsuarios($query, $con);
    }

    /**
     * Clears out the collGrupoViajes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGrupoViajes()
     */
    public function clearGrupoViajes()
    {
        $this->collGrupoViajes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGrupoViajes collection loaded partially.
     */
    public function resetPartialGrupoViajes($v = true)
    {
        $this->collGrupoViajesPartial = $v;
    }

    /**
     * Initializes the collGrupoViajes collection.
     *
     * By default this just sets the collGrupoViajes collection to an empty array (like clearcollGrupoViajes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGrupoViajes($overrideExisting = true)
    {
        if (null !== $this->collGrupoViajes && !$overrideExisting) {
            return;
        }

        $collectionClassName = GrupoViajeTableMap::getTableMap()->getCollectionClassName();

        $this->collGrupoViajes = new $collectionClassName;
        $this->collGrupoViajes->setModel('\GrupoViaje');
    }

    /**
     * Gets an array of ChildGrupoViaje objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildViaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGrupoViaje[] List of ChildGrupoViaje objects
     * @throws PropelException
     */
    public function getGrupoViajes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGrupoViajesPartial && !$this->isNew();
        if (null === $this->collGrupoViajes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGrupoViajes) {
                // return empty collection
                $this->initGrupoViajes();
            } else {
                $collGrupoViajes = ChildGrupoViajeQuery::create(null, $criteria)
                    ->filterByViaje($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGrupoViajesPartial && count($collGrupoViajes)) {
                        $this->initGrupoViajes(false);

                        foreach ($collGrupoViajes as $obj) {
                            if (false == $this->collGrupoViajes->contains($obj)) {
                                $this->collGrupoViajes->append($obj);
                            }
                        }

                        $this->collGrupoViajesPartial = true;
                    }

                    return $collGrupoViajes;
                }

                if ($partial && $this->collGrupoViajes) {
                    foreach ($this->collGrupoViajes as $obj) {
                        if ($obj->isNew()) {
                            $collGrupoViajes[] = $obj;
                        }
                    }
                }

                $this->collGrupoViajes = $collGrupoViajes;
                $this->collGrupoViajesPartial = false;
            }
        }

        return $this->collGrupoViajes;
    }

    /**
     * Sets a collection of ChildGrupoViaje objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $grupoViajes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildViaje The current object (for fluent API support)
     */
    public function setGrupoViajes(Collection $grupoViajes, ConnectionInterface $con = null)
    {
        /** @var ChildGrupoViaje[] $grupoViajesToDelete */
        $grupoViajesToDelete = $this->getGrupoViajes(new Criteria(), $con)->diff($grupoViajes);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->grupoViajesScheduledForDeletion = clone $grupoViajesToDelete;

        foreach ($grupoViajesToDelete as $grupoViajeRemoved) {
            $grupoViajeRemoved->setViaje(null);
        }

        $this->collGrupoViajes = null;
        foreach ($grupoViajes as $grupoViaje) {
            $this->addGrupoViaje($grupoViaje);
        }

        $this->collGrupoViajes = $grupoViajes;
        $this->collGrupoViajesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GrupoViaje objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GrupoViaje objects.
     * @throws PropelException
     */
    public function countGrupoViajes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGrupoViajesPartial && !$this->isNew();
        if (null === $this->collGrupoViajes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGrupoViajes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGrupoViajes());
            }

            $query = ChildGrupoViajeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByViaje($this)
                ->count($con);
        }

        return count($this->collGrupoViajes);
    }

    /**
     * Method called to associate a ChildGrupoViaje object to this object
     * through the ChildGrupoViaje foreign key attribute.
     *
     * @param  ChildGrupoViaje $l ChildGrupoViaje
     * @return $this|\Viaje The current object (for fluent API support)
     */
    public function addGrupoViaje(ChildGrupoViaje $l)
    {
        if ($this->collGrupoViajes === null) {
            $this->initGrupoViajes();
            $this->collGrupoViajesPartial = true;
        }

        if (!$this->collGrupoViajes->contains($l)) {
            $this->doAddGrupoViaje($l);

            if ($this->grupoViajesScheduledForDeletion and $this->grupoViajesScheduledForDeletion->contains($l)) {
                $this->grupoViajesScheduledForDeletion->remove($this->grupoViajesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGrupoViaje $grupoViaje The ChildGrupoViaje object to add.
     */
    protected function doAddGrupoViaje(ChildGrupoViaje $grupoViaje)
    {
        $this->collGrupoViajes[]= $grupoViaje;
        $grupoViaje->setViaje($this);
    }

    /**
     * @param  ChildGrupoViaje $grupoViaje The ChildGrupoViaje object to remove.
     * @return $this|ChildViaje The current object (for fluent API support)
     */
    public function removeGrupoViaje(ChildGrupoViaje $grupoViaje)
    {
        if ($this->getGrupoViajes()->contains($grupoViaje)) {
            $pos = $this->collGrupoViajes->search($grupoViaje);
            $this->collGrupoViajes->remove($pos);
            if (null === $this->grupoViajesScheduledForDeletion) {
                $this->grupoViajesScheduledForDeletion = clone $this->collGrupoViajes;
                $this->grupoViajesScheduledForDeletion->clear();
            }
            $this->grupoViajesScheduledForDeletion[]= clone $grupoViaje;
            $grupoViaje->setViaje(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Viaje is new, it will return
     * an empty collection; or if this Viaje has previously
     * been saved, it will retrieve related GrupoViajes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Viaje.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGrupoViaje[] List of ChildGrupoViaje objects
     */
    public function getGrupoViajesJoinGrupo(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGrupoViajeQuery::create(null, $criteria);
        $query->joinWith('Grupo', $joinBehavior);

        return $this->getGrupoViajes($query, $con);
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
     * Initializes the collMensajes crossRef collection.
     *
     * By default this just sets the collMensajes collection to an empty collection (like clearMensajes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initMensajes()
    {
        $collectionClassName = ViajeMensajesTableMap::getTableMap()->getCollectionClassName();

        $this->collMensajes = new $collectionClassName;
        $this->collMensajesPartial = true;
        $this->collMensajes->setModel('\Mensaje');
    }

    /**
     * Checks if the collMensajes collection is loaded.
     *
     * @return bool
     */
    public function isMensajesLoaded()
    {
        return null !== $this->collMensajes;
    }

    /**
     * Gets a collection of ChildMensaje objects related by a many-to-many relationship
     * to the current object by way of the viaje_mensajes cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildViaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildMensaje[] List of ChildMensaje objects
     */
    public function getMensajes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesPartial && !$this->isNew();
        if (null === $this->collMensajes || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collMensajes) {
                    $this->initMensajes();
                }
            } else {

                $query = ChildMensajeQuery::create(null, $criteria)
                    ->filterByViaje($this);
                $collMensajes = $query->find($con);
                if (null !== $criteria) {
                    return $collMensajes;
                }

                if ($partial && $this->collMensajes) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collMensajes as $obj) {
                        if (!$collMensajes->contains($obj)) {
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
     * Sets a collection of Mensaje objects related by a many-to-many relationship
     * to the current object by way of the viaje_mensajes cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $mensajes A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildViaje The current object (for fluent API support)
     */
    public function setMensajes(Collection $mensajes, ConnectionInterface $con = null)
    {
        $this->clearMensajes();
        $currentMensajes = $this->getMensajes();

        $mensajesScheduledForDeletion = $currentMensajes->diff($mensajes);

        foreach ($mensajesScheduledForDeletion as $toDelete) {
            $this->removeMensaje($toDelete);
        }

        foreach ($mensajes as $mensaje) {
            if (!$currentMensajes->contains($mensaje)) {
                $this->doAddMensaje($mensaje);
            }
        }

        $this->collMensajesPartial = false;
        $this->collMensajes = $mensajes;

        return $this;
    }

    /**
     * Gets the number of Mensaje objects related by a many-to-many relationship
     * to the current object by way of the viaje_mensajes cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Mensaje objects
     */
    public function countMensajes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMensajesPartial && !$this->isNew();
        if (null === $this->collMensajes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMensajes) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getMensajes());
                }

                $query = ChildMensajeQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByViaje($this)
                    ->count($con);
            }
        } else {
            return count($this->collMensajes);
        }
    }

    /**
     * Associate a ChildMensaje to this object
     * through the viaje_mensajes cross reference table.
     * 
     * @param ChildMensaje $mensaje
     * @return ChildViaje The current object (for fluent API support)
     */
    public function addMensaje(ChildMensaje $mensaje)
    {
        if ($this->collMensajes === null) {
            $this->initMensajes();
        }

        if (!$this->getMensajes()->contains($mensaje)) {
            // only add it if the **same** object is not already associated
            $this->collMensajes->push($mensaje);
            $this->doAddMensaje($mensaje);
        }

        return $this;
    }

    /**
     * 
     * @param ChildMensaje $mensaje
     */
    protected function doAddMensaje(ChildMensaje $mensaje)
    {
        $viajeMensajes = new ChildViajeMensajes();

        $viajeMensajes->setMensaje($mensaje);

        $viajeMensajes->setViaje($this);

        $this->addViajeMensajes($viajeMensajes);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$mensaje->isViajesLoaded()) {
            $mensaje->initViajes();
            $mensaje->getViajes()->push($this);
        } elseif (!$mensaje->getViajes()->contains($this)) {
            $mensaje->getViajes()->push($this);
        }

    }

    /**
     * Remove mensaje of this object
     * through the viaje_mensajes cross reference table.
     * 
     * @param ChildMensaje $mensaje
     * @return ChildViaje The current object (for fluent API support)
     */
    public function removeMensaje(ChildMensaje $mensaje)
    {
        if ($this->getMensajes()->contains($mensaje)) { $viajeMensajes = new ChildViajeMensajes();

            $viajeMensajes->setMensaje($mensaje);
            if ($mensaje->isViajesLoaded()) {
                //remove the back reference if available
                $mensaje->getViajes()->removeObject($this);
            }

            $viajeMensajes->setViaje($this);
            $this->removeViajeMensajes(clone $viajeMensajes);
            $viajeMensajes->clear();

            $this->collMensajes->remove($this->collMensajes->search($mensaje));
            
            if (null === $this->mensajesScheduledForDeletion) {
                $this->mensajesScheduledForDeletion = clone $this->collMensajes;
                $this->mensajesScheduledForDeletion->clear();
            }

            $this->mensajesScheduledForDeletion->push($mensaje);
        }


        return $this;
    }

    /**
     * Clears out the collUsuarios collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsuarios()
     */
    public function clearUsuarios()
    {
        $this->collUsuarios = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collUsuarios crossRef collection.
     *
     * By default this just sets the collUsuarios collection to an empty collection (like clearUsuarios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUsuarios()
    {
        $collectionClassName = ViajeUsuarioTableMap::getTableMap()->getCollectionClassName();

        $this->collUsuarios = new $collectionClassName;
        $this->collUsuariosPartial = true;
        $this->collUsuarios->setModel('\Usuario');
    }

    /**
     * Checks if the collUsuarios collection is loaded.
     *
     * @return bool
     */
    public function isUsuariosLoaded()
    {
        return null !== $this->collUsuarios;
    }

    /**
     * Gets a collection of ChildUsuario objects related by a many-to-many relationship
     * to the current object by way of the viaje_usuario cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildViaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUsuario[] List of ChildUsuario objects
     */
    public function getUsuarios(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuariosPartial && !$this->isNew();
        if (null === $this->collUsuarios || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collUsuarios) {
                    $this->initUsuarios();
                }
            } else {

                $query = ChildUsuarioQuery::create(null, $criteria)
                    ->filterByViaje($this);
                $collUsuarios = $query->find($con);
                if (null !== $criteria) {
                    return $collUsuarios;
                }

                if ($partial && $this->collUsuarios) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collUsuarios as $obj) {
                        if (!$collUsuarios->contains($obj)) {
                            $collUsuarios[] = $obj;
                        }
                    }
                }

                $this->collUsuarios = $collUsuarios;
                $this->collUsuariosPartial = false;
            }
        }

        return $this->collUsuarios;
    }

    /**
     * Sets a collection of Usuario objects related by a many-to-many relationship
     * to the current object by way of the viaje_usuario cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $usuarios A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildViaje The current object (for fluent API support)
     */
    public function setUsuarios(Collection $usuarios, ConnectionInterface $con = null)
    {
        $this->clearUsuarios();
        $currentUsuarios = $this->getUsuarios();

        $usuariosScheduledForDeletion = $currentUsuarios->diff($usuarios);

        foreach ($usuariosScheduledForDeletion as $toDelete) {
            $this->removeUsuario($toDelete);
        }

        foreach ($usuarios as $usuario) {
            if (!$currentUsuarios->contains($usuario)) {
                $this->doAddUsuario($usuario);
            }
        }

        $this->collUsuariosPartial = false;
        $this->collUsuarios = $usuarios;

        return $this;
    }

    /**
     * Gets the number of Usuario objects related by a many-to-many relationship
     * to the current object by way of the viaje_usuario cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Usuario objects
     */
    public function countUsuarios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsuariosPartial && !$this->isNew();
        if (null === $this->collUsuarios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsuarios) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getUsuarios());
                }

                $query = ChildUsuarioQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByViaje($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsuarios);
        }
    }

    /**
     * Associate a ChildUsuario to this object
     * through the viaje_usuario cross reference table.
     * 
     * @param ChildUsuario $usuario
     * @return ChildViaje The current object (for fluent API support)
     */
    public function addUsuario(ChildUsuario $usuario)
    {
        if ($this->collUsuarios === null) {
            $this->initUsuarios();
        }

        if (!$this->getUsuarios()->contains($usuario)) {
            // only add it if the **same** object is not already associated
            $this->collUsuarios->push($usuario);
            $this->doAddUsuario($usuario);
        }

        return $this;
    }

    /**
     * 
     * @param ChildUsuario $usuario
     */
    protected function doAddUsuario(ChildUsuario $usuario)
    {
        $viajeUsuario = new ChildViajeUsuario();

        $viajeUsuario->setUsuario($usuario);

        $viajeUsuario->setViaje($this);

        $this->addViajeUsuario($viajeUsuario);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$usuario->isViajesLoaded()) {
            $usuario->initViajes();
            $usuario->getViajes()->push($this);
        } elseif (!$usuario->getViajes()->contains($this)) {
            $usuario->getViajes()->push($this);
        }

    }

    /**
     * Remove usuario of this object
     * through the viaje_usuario cross reference table.
     * 
     * @param ChildUsuario $usuario
     * @return ChildViaje The current object (for fluent API support)
     */
    public function removeUsuario(ChildUsuario $usuario)
    {
        if ($this->getUsuarios()->contains($usuario)) { $viajeUsuario = new ChildViajeUsuario();

            $viajeUsuario->setUsuario($usuario);
            if ($usuario->isViajesLoaded()) {
                //remove the back reference if available
                $usuario->getViajes()->removeObject($this);
            }

            $viajeUsuario->setViaje($this);
            $this->removeViajeUsuario(clone $viajeUsuario);
            $viajeUsuario->clear();

            $this->collUsuarios->remove($this->collUsuarios->search($usuario));
            
            if (null === $this->usuariosScheduledForDeletion) {
                $this->usuariosScheduledForDeletion = clone $this->collUsuarios;
                $this->usuariosScheduledForDeletion->clear();
            }

            $this->usuariosScheduledForDeletion->push($usuario);
        }


        return $this;
    }

    /**
     * Clears out the collGrupoFavoritos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGrupoFavoritos()
     */
    public function clearGrupoFavoritos()
    {
        $this->collGrupoFavoritos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the combinationCollGrupoFavoritos crossRef collection.
     *
     * By default this just sets the combinationCollGrupoFavoritos collection to an empty collection (like clearGrupoFavoritos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initGrupoFavoritos()
    {
        $this->combinationCollGrupoFavoritos = new ObjectCombinationCollection;
        $this->combinationCollGrupoFavoritosPartial = true;
    }

    /**
     * Checks if the combinationCollGrupoFavoritos collection is loaded.
     *
     * @return bool
     */
    public function isGrupoFavoritosLoaded()
    {
        return null !== $this->combinationCollGrupoFavoritos;
    }

    /**
     * Returns a new query object pre configured with filters from current object and given arguments to query the database.
     * 
     * @param boolean $favorito
     * @param Criteria $criteria
     *
     * @return ChildGrupoQuery
     */
    public function createGruposQuery($favorito = null, Criteria $criteria = null)
    {
        $criteria = ChildGrupoQuery::create($criteria)
            ->filterByViaje($this);

        $grupoViajeQuery = $criteria->useGrupoViajeQuery();

        if (null !== $favorito) {
            $grupoViajeQuery->filterByFavorito($favorito);
        }
            
        $grupoViajeQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildGrupo objects related by a many-to-many relationship
     * to the current object by way of the grupo_viaje cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildViaje is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCombinationCollection Combination list of ChildGrupo objects
     */
    public function getGrupoFavoritos($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollGrupoFavoritosPartial && !$this->isNew();
        if (null === $this->combinationCollGrupoFavoritos || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->combinationCollGrupoFavoritos) {
                    $this->initGrupoFavoritos();
                }
            } else {

                $query = ChildGrupoViajeQuery::create(null, $criteria)
                    ->filterByViaje($this)
                    ->joinGrupo()
                ;

                $items = $query->find($con);
                $combinationCollGrupoFavoritos = new ObjectCombinationCollection();
                foreach ($items as $item) {
                    $combination = [];

                    $combination[] = $item->getGrupo();
                    $combination[] = $item->getFavorito();
                    $combinationCollGrupoFavoritos[] = $combination;
                }

                if (null !== $criteria) {
                    return $combinationCollGrupoFavoritos;
                }

                if ($partial && $this->combinationCollGrupoFavoritos) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->combinationCollGrupoFavoritos as $obj) {
                        if (!call_user_func_array([$combinationCollGrupoFavoritos, 'contains'], $obj)) {
                            $combinationCollGrupoFavoritos[] = $obj;
                        }
                    }
                }

                $this->combinationCollGrupoFavoritos = $combinationCollGrupoFavoritos;
                $this->combinationCollGrupoFavoritosPartial = false;
            }
        }

        return $this->combinationCollGrupoFavoritos;
    }

    /**
     * Returns a not cached ObjectCollection of ChildGrupo objects. This will hit always the databases.
     * If you have attached new ChildGrupo object to this object you need to call `save` first to get
     * the correct return value. Use getGrupoFavoritos() to get the current internal state.
     * 
     * @param boolean $favorito
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return ChildGrupo[]|ObjectCollection
     */
    public function getGrupos($favorito = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createGruposQuery($favorito, $criteria)->find($con);
    }

    /**
     * Sets a collection of ChildGrupo objects related by a many-to-many relationship
     * to the current object by way of the grupo_viaje cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $grupoFavoritos A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildViaje The current object (for fluent API support)
     */
    public function setGrupoFavoritos(Collection $grupoFavoritos, ConnectionInterface $con = null)
    {
        $this->clearGrupoFavoritos();
        $currentGrupoFavoritos = $this->getGrupoFavoritos();

        $combinationCollGrupoFavoritosScheduledForDeletion = $currentGrupoFavoritos->diff($grupoFavoritos);

        foreach ($combinationCollGrupoFavoritosScheduledForDeletion as $toDelete) {
            call_user_func_array([$this, 'removeGrupoFavorito'], $toDelete);
        }

        foreach ($grupoFavoritos as $grupoFavorito) {
            if (!call_user_func_array([$currentGrupoFavoritos, 'contains'], $grupoFavorito)) {
                call_user_func_array([$this, 'doAddGrupoFavorito'], $grupoFavorito);
            }
        }

        $this->combinationCollGrupoFavoritosPartial = false;
        $this->combinationCollGrupoFavoritos = $grupoFavoritos;

        return $this;
    }

    /**
     * Gets the number of ChildGrupo objects related by a many-to-many relationship
     * to the current object by way of the grupo_viaje cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ChildGrupo objects
     */
    public function countGrupoFavoritos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollGrupoFavoritosPartial && !$this->isNew();
        if (null === $this->combinationCollGrupoFavoritos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->combinationCollGrupoFavoritos) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getGrupoFavoritos());
                }

                $query = ChildGrupoViajeQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByViaje($this)
                    ->count($con);
            }
        } else {
            return count($this->combinationCollGrupoFavoritos);
        }
    }

    /**
     * Returns the not cached count of ChildGrupo objects. This will hit always the databases.
     * If you have attached new ChildGrupo object to this object you need to call `save` first to get
     * the correct return value. Use getGrupoFavoritos() to get the current internal state.
     * 
     * @param boolean $favorito
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return integer
     */
    public function countGrupos($favorito = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createGruposQuery($favorito, $criteria)->count($con);
    }

    /**
     * Associate a ChildGrupo to this object
     * through the grupo_viaje cross reference table.
     * 
     * @param ChildGrupo $grupo, 
     * @param boolean $favorito
     * @return ChildViaje The current object (for fluent API support)
     */
    public function addGrupo(ChildGrupo $grupo, $favorito)
    {
        if ($this->combinationCollGrupoFavoritos === null) {
            $this->initGrupoFavoritos();
        }

        if (!$this->getGrupoFavoritos()->contains($grupo, $favorito)) {
            // only add it if the **same** object is not already associated
            $this->combinationCollGrupoFavoritos->push($grupo, $favorito);
            $this->doAddGrupoFavorito($grupo, $favorito);
        }

        return $this;
    }

    /**
     * 
     * @param ChildGrupo $grupo, 
     * @param boolean $favorito
     */
    protected function doAddGrupoFavorito(ChildGrupo $grupo, $favorito)
    {
        $grupoViaje = new ChildGrupoViaje();

        $grupoViaje->setGrupo($grupo);
        $grupoViaje->setFavorito($favorito);


        $grupoViaje->setViaje($this);

        $this->addGrupoViaje($grupoViaje);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($grupo->isViajeFavoritosLoaded()) {
            $grupo->initViajeFavoritos();
            $grupo->getViajeFavoritos()->push($this, $favorito);
        } elseif (!$grupo->getViajeFavoritos()->contains($this, $favorito)) {
            $grupo->getViajeFavoritos()->push($this, $favorito);
        }

    }

    /**
     * Remove grupo, favorito of this object
     * through the grupo_viaje cross reference table.
     * 
     * @param ChildGrupo $grupo, 
     * @param boolean $favorito
     * @return ChildViaje The current object (for fluent API support)
     */
    public function removeGrupoFavorito(ChildGrupo $grupo, $favorito)
    {
        if ($this->getGrupoFavoritos()->contains($grupo, $favorito)) { $grupoViaje = new ChildGrupoViaje();

            $grupoViaje->setGrupo($grupo);
            if ($grupo->isViajeFavoritosLoaded()) {
                //remove the back reference if available
                $grupo->getViajeFavoritos()->removeObject($this, $favorito);
            }

            $grupoViaje->setFavorito($favorito);
            $grupoViaje->setViaje($this);
            $this->removeGrupoViaje(clone $grupoViaje);
            $grupoViaje->clear();

            $this->combinationCollGrupoFavoritos->remove($this->combinationCollGrupoFavoritos->search($grupo, $favorito));
            
            if (null === $this->combinationCollGrupoFavoritosScheduledForDeletion) {
                $this->combinationCollGrupoFavoritosScheduledForDeletion = clone $this->combinationCollGrupoFavoritos;
                $this->combinationCollGrupoFavoritosScheduledForDeletion->clear();
            }

            $this->combinationCollGrupoFavoritosScheduledForDeletion->push($grupo, $favorito);
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
        $this->idviaje = null;
        $this->nombre = null;
        $this->informacion = null;
        $this->transporte = null;
        $this->hospedaje = null;
        $this->destino = null;
        $this->fecha_inicio = null;
        $this->fecha_final = null;
        $this->precio = null;
        $this->imagenes = null;
        $this->imagenes_unserialized = null;
        $this->etiquetas = null;
        $this->etiquetas_unserialized = null;
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
            if ($this->collViajeUsuarios) {
                foreach ($this->collViajeUsuarios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGrupoViajes) {
                foreach ($this->collGrupoViajes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMensajes) {
                foreach ($this->collMensajes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsuarios) {
                foreach ($this->collUsuarios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollGrupoFavoritos) {
                foreach ($this->combinationCollGrupoFavoritos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collViajeMensajess = null;
        $this->collViajeUsuarios = null;
        $this->collGrupoViajes = null;
        $this->collMensajes = null;
        $this->collUsuarios = null;
        $this->combinationCollGrupoFavoritos = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ViajeTableMap::DEFAULT_STRING_FORMAT);
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
