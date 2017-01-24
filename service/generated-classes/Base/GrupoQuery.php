<?php

namespace Base;

use \Grupo as ChildGrupo;
use \GrupoQuery as ChildGrupoQuery;
use \Exception;
use \PDO;
use Map\GrupoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'grupo' table.
 *
 * 
 *
 * @method     ChildGrupoQuery orderByIdgrupo($order = Criteria::ASC) Order by the idgrupo column
 * @method     ChildGrupoQuery orderByInformacion($order = Criteria::ASC) Order by the informacion column
 * @method     ChildGrupoQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildGrupoQuery orderByAdministrador($order = Criteria::ASC) Order by the administrador column
 *
 * @method     ChildGrupoQuery groupByIdgrupo() Group by the idgrupo column
 * @method     ChildGrupoQuery groupByInformacion() Group by the informacion column
 * @method     ChildGrupoQuery groupByNombre() Group by the nombre column
 * @method     ChildGrupoQuery groupByAdministrador() Group by the administrador column
 *
 * @method     ChildGrupoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGrupoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGrupoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGrupoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGrupoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGrupoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGrupoQuery leftJoinMiembrosGrupo($relationAlias = null) Adds a LEFT JOIN clause to the query using the MiembrosGrupo relation
 * @method     ChildGrupoQuery rightJoinMiembrosGrupo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MiembrosGrupo relation
 * @method     ChildGrupoQuery innerJoinMiembrosGrupo($relationAlias = null) Adds a INNER JOIN clause to the query using the MiembrosGrupo relation
 *
 * @method     ChildGrupoQuery joinWithMiembrosGrupo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MiembrosGrupo relation
 *
 * @method     ChildGrupoQuery leftJoinWithMiembrosGrupo() Adds a LEFT JOIN clause and with to the query using the MiembrosGrupo relation
 * @method     ChildGrupoQuery rightJoinWithMiembrosGrupo() Adds a RIGHT JOIN clause and with to the query using the MiembrosGrupo relation
 * @method     ChildGrupoQuery innerJoinWithMiembrosGrupo() Adds a INNER JOIN clause and with to the query using the MiembrosGrupo relation
 *
 * @method     ChildGrupoQuery leftJoinGrupoViaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the GrupoViaje relation
 * @method     ChildGrupoQuery rightJoinGrupoViaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GrupoViaje relation
 * @method     ChildGrupoQuery innerJoinGrupoViaje($relationAlias = null) Adds a INNER JOIN clause to the query using the GrupoViaje relation
 *
 * @method     ChildGrupoQuery joinWithGrupoViaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GrupoViaje relation
 *
 * @method     ChildGrupoQuery leftJoinWithGrupoViaje() Adds a LEFT JOIN clause and with to the query using the GrupoViaje relation
 * @method     ChildGrupoQuery rightJoinWithGrupoViaje() Adds a RIGHT JOIN clause and with to the query using the GrupoViaje relation
 * @method     ChildGrupoQuery innerJoinWithGrupoViaje() Adds a INNER JOIN clause and with to the query using the GrupoViaje relation
 *
 * @method     \MiembrosGrupoQuery|\GrupoViajeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGrupo findOne(ConnectionInterface $con = null) Return the first ChildGrupo matching the query
 * @method     ChildGrupo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGrupo matching the query, or a new ChildGrupo object populated from the query conditions when no match is found
 *
 * @method     ChildGrupo findOneByIdgrupo(int $idgrupo) Return the first ChildGrupo filtered by the idgrupo column
 * @method     ChildGrupo findOneByInformacion(string $informacion) Return the first ChildGrupo filtered by the informacion column
 * @method     ChildGrupo findOneByNombre(string $nombre) Return the first ChildGrupo filtered by the nombre column
 * @method     ChildGrupo findOneByAdministrador(boolean $administrador) Return the first ChildGrupo filtered by the administrador column *

 * @method     ChildGrupo requirePk($key, ConnectionInterface $con = null) Return the ChildGrupo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGrupo requireOne(ConnectionInterface $con = null) Return the first ChildGrupo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGrupo requireOneByIdgrupo(int $idgrupo) Return the first ChildGrupo filtered by the idgrupo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGrupo requireOneByInformacion(string $informacion) Return the first ChildGrupo filtered by the informacion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGrupo requireOneByNombre(string $nombre) Return the first ChildGrupo filtered by the nombre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGrupo requireOneByAdministrador(boolean $administrador) Return the first ChildGrupo filtered by the administrador column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGrupo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGrupo objects based on current ModelCriteria
 * @method     ChildGrupo[]|ObjectCollection findByIdgrupo(int $idgrupo) Return ChildGrupo objects filtered by the idgrupo column
 * @method     ChildGrupo[]|ObjectCollection findByInformacion(string $informacion) Return ChildGrupo objects filtered by the informacion column
 * @method     ChildGrupo[]|ObjectCollection findByNombre(string $nombre) Return ChildGrupo objects filtered by the nombre column
 * @method     ChildGrupo[]|ObjectCollection findByAdministrador(boolean $administrador) Return ChildGrupo objects filtered by the administrador column
 * @method     ChildGrupo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GrupoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GrupoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\Grupo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGrupoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGrupoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGrupoQuery) {
            return $criteria;
        }
        $query = new ChildGrupoQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$idgrupo, $nombre] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGrupo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GrupoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GrupoTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildGrupo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idgrupo, informacion, nombre, administrador FROM grupo WHERE idgrupo = :p0 AND nombre = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildGrupo $obj */
            $obj = new ChildGrupo();
            $obj->hydrate($row);
            GrupoTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildGrupo|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(GrupoTableMap::COL_IDGRUPO, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(GrupoTableMap::COL_NOMBRE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(GrupoTableMap::COL_IDGRUPO, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(GrupoTableMap::COL_NOMBRE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the idgrupo column
     *
     * Example usage:
     * <code>
     * $query->filterByIdgrupo(1234); // WHERE idgrupo = 1234
     * $query->filterByIdgrupo(array(12, 34)); // WHERE idgrupo IN (12, 34)
     * $query->filterByIdgrupo(array('min' => 12)); // WHERE idgrupo > 12
     * </code>
     *
     * @param     mixed $idgrupo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByIdgrupo($idgrupo = null, $comparison = null)
    {
        if (is_array($idgrupo)) {
            $useMinMax = false;
            if (isset($idgrupo['min'])) {
                $this->addUsingAlias(GrupoTableMap::COL_IDGRUPO, $idgrupo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idgrupo['max'])) {
                $this->addUsingAlias(GrupoTableMap::COL_IDGRUPO, $idgrupo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrupoTableMap::COL_IDGRUPO, $idgrupo, $comparison);
    }

    /**
     * Filter the query on the informacion column
     *
     * Example usage:
     * <code>
     * $query->filterByInformacion('fooValue');   // WHERE informacion = 'fooValue'
     * $query->filterByInformacion('%fooValue%'); // WHERE informacion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $informacion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByInformacion($informacion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($informacion)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrupoTableMap::COL_INFORMACION, $informacion, $comparison);
    }

    /**
     * Filter the query on the nombre column
     *
     * Example usage:
     * <code>
     * $query->filterByNombre('fooValue');   // WHERE nombre = 'fooValue'
     * $query->filterByNombre('%fooValue%'); // WHERE nombre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByNombre($nombre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombre)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrupoTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the administrador column
     *
     * Example usage:
     * <code>
     * $query->filterByAdministrador(true); // WHERE administrador = true
     * $query->filterByAdministrador('yes'); // WHERE administrador = true
     * </code>
     *
     * @param     boolean|string $administrador The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByAdministrador($administrador = null, $comparison = null)
    {
        if (is_string($administrador)) {
            $administrador = in_array(strtolower($administrador), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GrupoTableMap::COL_ADMINISTRADOR, $administrador, $comparison);
    }

    /**
     * Filter the query by a related \MiembrosGrupo object
     *
     * @param \MiembrosGrupo|ObjectCollection $miembrosGrupo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByMiembrosGrupo($miembrosGrupo, $comparison = null)
    {
        if ($miembrosGrupo instanceof \MiembrosGrupo) {
            return $this
                ->addUsingAlias(GrupoTableMap::COL_IDGRUPO, $miembrosGrupo->getIdgrupo(), $comparison);
        } elseif ($miembrosGrupo instanceof ObjectCollection) {
            return $this
                ->useMiembrosGrupoQuery()
                ->filterByPrimaryKeys($miembrosGrupo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMiembrosGrupo() only accepts arguments of type \MiembrosGrupo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MiembrosGrupo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function joinMiembrosGrupo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MiembrosGrupo');

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
            $this->addJoinObject($join, 'MiembrosGrupo');
        }

        return $this;
    }

    /**
     * Use the MiembrosGrupo relation MiembrosGrupo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MiembrosGrupoQuery A secondary query class using the current class as primary query
     */
    public function useMiembrosGrupoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMiembrosGrupo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MiembrosGrupo', '\MiembrosGrupoQuery');
    }

    /**
     * Filter the query by a related \GrupoViaje object
     *
     * @param \GrupoViaje|ObjectCollection $grupoViaje the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByGrupoViaje($grupoViaje, $comparison = null)
    {
        if ($grupoViaje instanceof \GrupoViaje) {
            return $this
                ->addUsingAlias(GrupoTableMap::COL_IDGRUPO, $grupoViaje->getIdgrupo(), $comparison);
        } elseif ($grupoViaje instanceof ObjectCollection) {
            return $this
                ->useGrupoViajeQuery()
                ->filterByPrimaryKeys($grupoViaje->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGrupoViaje() only accepts arguments of type \GrupoViaje or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GrupoViaje relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function joinGrupoViaje($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GrupoViaje');

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
            $this->addJoinObject($join, 'GrupoViaje');
        }

        return $this;
    }

    /**
     * Use the GrupoViaje relation GrupoViaje object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GrupoViajeQuery A secondary query class using the current class as primary query
     */
    public function useGrupoViajeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGrupoViaje($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GrupoViaje', '\GrupoViajeQuery');
    }

    /**
     * Filter the query by a related Usuario object
     * using the miembros_grupo table as cross reference
     *
     * @param Usuario $usuario the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useMiembrosGrupoQuery()
            ->filterByUsuario($usuario, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Viaje object
     * using the grupo_viaje table as cross reference
     *
     * @param Viaje $viaje the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGrupoQuery The current query, for fluid interface
     */
    public function filterByViaje($viaje, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useGrupoViajeQuery()
            ->filterByViaje($viaje, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGrupo $grupo Object to remove from the list of results
     *
     * @return $this|ChildGrupoQuery The current query, for fluid interface
     */
    public function prune($grupo = null)
    {
        if ($grupo) {
            $this->addCond('pruneCond0', $this->getAliasedColName(GrupoTableMap::COL_IDGRUPO), $grupo->getIdgrupo(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(GrupoTableMap::COL_NOMBRE), $grupo->getNombre(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the grupo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GrupoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GrupoTableMap::clearInstancePool();
            GrupoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GrupoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GrupoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            GrupoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            GrupoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GrupoQuery
