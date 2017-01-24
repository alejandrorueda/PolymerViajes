<?php

namespace Map;

use \Perfil;
use \PerfilQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'perfil' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PerfilTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PerfilTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'viajes';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'perfil';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Perfil';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Perfil';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the idperfil field
     */
    const COL_IDPERFIL = 'perfil.idperfil';

    /**
     * the column name for the descripcion field
     */
    const COL_DESCRIPCION = 'perfil.descripcion';

    /**
     * the column name for the tipo_favorito field
     */
    const COL_TIPO_FAVORITO = 'perfil.tipo_favorito';

    /**
     * the column name for the gustos field
     */
    const COL_GUSTOS = 'perfil.gustos';

    /**
     * the column name for the nacimiento field
     */
    const COL_NACIMIENTO = 'perfil.nacimiento';

    /**
     * the column name for the destinos field
     */
    const COL_DESTINOS = 'perfil.destinos';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the tipo_favorito field */
    const COL_TIPO_FAVORITO_AVENTURA = 'aventura';
    const COL_TIPO_FAVORITO_ROMANTICO = 'romantico';
    const COL_TIPO_FAVORITO_TRANQUILO = 'tranquilo';
    const COL_TIPO_FAVORITO_DEPORTIVO = 'deportivo';

    /** The enumerated values for the gustos field */
    const COL_GUSTOS_TECNOLOGIA = 'tecnologia';
    const COL_GUSTOS_NATURALEZA = 'naturaleza';
    const COL_GUSTOS_URBANO = 'urbano';
    const COL_GUSTOS_CULTURAL = 'cultural';

    /** The enumerated values for the destinos field */
    const COL_DESTINOS_EUROPA = 'europa';
    const COL_DESTINOS_NACIONAL = 'nacional';
    const COL_DESTINOS_CUALQUIER_DESTINO = 'cualquier destino';
    const COL_DESTINOS_AMERICA = 'america';
    const COL_DESTINOS_ASIA = 'asia';
    const COL_DESTINOS_OCEANIA = 'oceania';
    const COL_DESTINOS_AFRICA = 'africa';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Idperfil', 'Descripcion', 'TipoFavorito', 'Gustos', 'Nacimiento', 'Destinos', ),
        self::TYPE_CAMELNAME     => array('idperfil', 'descripcion', 'tipoFavorito', 'gustos', 'nacimiento', 'destinos', ),
        self::TYPE_COLNAME       => array(PerfilTableMap::COL_IDPERFIL, PerfilTableMap::COL_DESCRIPCION, PerfilTableMap::COL_TIPO_FAVORITO, PerfilTableMap::COL_GUSTOS, PerfilTableMap::COL_NACIMIENTO, PerfilTableMap::COL_DESTINOS, ),
        self::TYPE_FIELDNAME     => array('idperfil', 'descripcion', 'tipo_favorito', 'gustos', 'nacimiento', 'destinos', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Idperfil' => 0, 'Descripcion' => 1, 'TipoFavorito' => 2, 'Gustos' => 3, 'Nacimiento' => 4, 'Destinos' => 5, ),
        self::TYPE_CAMELNAME     => array('idperfil' => 0, 'descripcion' => 1, 'tipoFavorito' => 2, 'gustos' => 3, 'nacimiento' => 4, 'destinos' => 5, ),
        self::TYPE_COLNAME       => array(PerfilTableMap::COL_IDPERFIL => 0, PerfilTableMap::COL_DESCRIPCION => 1, PerfilTableMap::COL_TIPO_FAVORITO => 2, PerfilTableMap::COL_GUSTOS => 3, PerfilTableMap::COL_NACIMIENTO => 4, PerfilTableMap::COL_DESTINOS => 5, ),
        self::TYPE_FIELDNAME     => array('idperfil' => 0, 'descripcion' => 1, 'tipo_favorito' => 2, 'gustos' => 3, 'nacimiento' => 4, 'destinos' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                PerfilTableMap::COL_TIPO_FAVORITO => array(
                            self::COL_TIPO_FAVORITO_AVENTURA,
            self::COL_TIPO_FAVORITO_ROMANTICO,
            self::COL_TIPO_FAVORITO_TRANQUILO,
            self::COL_TIPO_FAVORITO_DEPORTIVO,
        ),
                PerfilTableMap::COL_GUSTOS => array(
                            self::COL_GUSTOS_TECNOLOGIA,
            self::COL_GUSTOS_NATURALEZA,
            self::COL_GUSTOS_URBANO,
            self::COL_GUSTOS_CULTURAL,
        ),
                PerfilTableMap::COL_DESTINOS => array(
                            self::COL_DESTINOS_EUROPA,
            self::COL_DESTINOS_NACIONAL,
            self::COL_DESTINOS_CUALQUIER_DESTINO,
            self::COL_DESTINOS_AMERICA,
            self::COL_DESTINOS_ASIA,
            self::COL_DESTINOS_OCEANIA,
            self::COL_DESTINOS_AFRICA,
        ),
    );

    /**
     * Gets the list of values for all ENUM and SET columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM or SET column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('perfil');
        $this->setPhpName('Perfil');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Perfil');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('idperfil', 'Idperfil', 'INTEGER', true, null, null);
        $this->addColumn('descripcion', 'Descripcion', 'VARCHAR', false, 255, null);
        $this->addColumn('tipo_favorito', 'TipoFavorito', 'SET', false, null, null);
        $this->getColumn('tipo_favorito')->setValueSet(array (
  0 => 'aventura',
  1 => 'romantico',
  2 => 'tranquilo',
  3 => 'deportivo',
));
        $this->addColumn('gustos', 'Gustos', 'SET', false, null, null);
        $this->getColumn('gustos')->setValueSet(array (
  0 => 'tecnologia',
  1 => 'naturaleza',
  2 => 'urbano',
  3 => 'cultural',
));
        $this->addColumn('nacimiento', 'Nacimiento', 'DATE', false, null, null);
        $this->addColumn('destinos', 'Destinos', 'SET', false, null, null);
        $this->getColumn('destinos')->setValueSet(array (
  0 => 'europa',
  1 => 'nacional',
  2 => 'cualquier destino',
  3 => 'america',
  4 => 'asia',
  5 => 'oceania',
  6 => 'africa',
));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Usuario', '\\Usuario', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':idperfil',
    1 => ':idperfil',
  ),
), null, null, 'Usuarios', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Idperfil', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PerfilTableMap::CLASS_DEFAULT : PerfilTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Perfil object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PerfilTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PerfilTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PerfilTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PerfilTableMap::OM_CLASS;
            /** @var Perfil $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PerfilTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PerfilTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PerfilTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Perfil $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PerfilTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PerfilTableMap::COL_IDPERFIL);
            $criteria->addSelectColumn(PerfilTableMap::COL_DESCRIPCION);
            $criteria->addSelectColumn(PerfilTableMap::COL_TIPO_FAVORITO);
            $criteria->addSelectColumn(PerfilTableMap::COL_GUSTOS);
            $criteria->addSelectColumn(PerfilTableMap::COL_NACIMIENTO);
            $criteria->addSelectColumn(PerfilTableMap::COL_DESTINOS);
        } else {
            $criteria->addSelectColumn($alias . '.idperfil');
            $criteria->addSelectColumn($alias . '.descripcion');
            $criteria->addSelectColumn($alias . '.tipo_favorito');
            $criteria->addSelectColumn($alias . '.gustos');
            $criteria->addSelectColumn($alias . '.nacimiento');
            $criteria->addSelectColumn($alias . '.destinos');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PerfilTableMap::DATABASE_NAME)->getTable(PerfilTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PerfilTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PerfilTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PerfilTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Perfil or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Perfil object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerfilTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Perfil) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PerfilTableMap::DATABASE_NAME);
            $criteria->add(PerfilTableMap::COL_IDPERFIL, (array) $values, Criteria::IN);
        }

        $query = PerfilQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PerfilTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PerfilTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the perfil table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PerfilQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Perfil or Criteria object.
     *
     * @param mixed               $criteria Criteria or Perfil object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerfilTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Perfil object
        }

        if ($criteria->containsKey(PerfilTableMap::COL_IDPERFIL) && $criteria->keyContainsValue(PerfilTableMap::COL_IDPERFIL) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PerfilTableMap::COL_IDPERFIL.')');
        }


        // Set the correct dbName
        $query = PerfilQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PerfilTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PerfilTableMap::buildTableMap();
