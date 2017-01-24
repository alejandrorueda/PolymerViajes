<?php

namespace Base;

use \GrupoViaje as ChildGrupoViaje;
use \GrupoViajeQuery as ChildGrupoViajeQuery;
use \Exception;
use \PDO;
use Map\GrupoViajeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'grupo_viaje' table.
 *
 * 
 *
 * @method     ChildGrupoViajeQuery orderByIdgrupo($order = Criteria::ASC) Order by the idgrupo column
 * @method     ChildGrupoViajeQuery orderByIdviaje($order = Criteria::ASC) Order by the idviaje column
 * @method     ChildGrupoViajeQuery orderByFavorito($order = Criteria::ASC) Order by the favorito column
 *
 * @method     ChildGrupoViajeQuery groupByIdgrupo() Group by the idgrupo column
 * @method     ChildGrupoViajeQuery groupByIdviaje() Group by the idviaje column
 * @method     ChildGrupoViajeQuery groupByFavorito() Group by the favorito column
 *
 * @method     ChildGrupoViajeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGrupoViajeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGrupoViajeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGrupoViajeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGrupoViajeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGrupoViajeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGrupoViajeQuery leftJoinGrupo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Grupo relation
 * @method     ChildGrupoViajeQuery rightJoinGrupo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Grupo relation
 * @method     ChildGrupoViajeQuery innerJoinGrupo($relationAlias = null) Adds a INNER JOIN clause to the query using the Grupo relation
 *
 * @method     ChildGrupoViajeQuery joinWithGrupo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Grupo relation
 *
 * @method     ChildGrupoViajeQuery leftJoinWithGrupo() Adds a LEFT JOIN clause and with to the query using the Grupo relation
 * @method     ChildGrupoViajeQuery rightJoinWithGrupo() Adds a RIGHT JOIN clause and with to the query using the Grupo relation
 * @method     ChildGrupoViajeQuery innerJoinWithGrupo() Adds a INNER JOIN clause and with to the query using the Grupo relation
 *
 * @method     ChildGrupoViajeQuery leftJoinViaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the Viaje relation
 * @method     ChildGrupoViajeQuery rightJoinViaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Viaje relation
 * @method     ChildGrupoViajeQuery innerJoinViaje($relationAlias = null) Adds a INNER JOIN clause to the query using the Viaje relation
 *
 * @method     ChildGrupoViajeQuery joinWithViaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Viaje relation
 *
 * @method     ChildGrupoViajeQuery leftJoinWithViaje() Adds a LEFT JOIN clause and with to the query using the Viaje relation
 * @method     ChildGrupoViajeQuery rightJoinWithViaje() Adds a RIGHT JOIN clause and with to the query using the Viaje relation
 * @method     ChildGrupoViajeQuery innerJoinWithViaje() Adds a INNER JOIN clause and with to the query using the Viaje relation
 *
 * @method     \GrupoQuery|\ViajeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGrupoViaje findOne(ConnectionInterface $con = null) Return the first ChildGrupoViaje matching the query
 * @method     ChildGrupoViaje findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGrupoViaje matching the query, or a new ChildGrupoViaje object populated from the query conditions when no match is found
 *
 * @method     ChildGrupoViaje findOneByIdgrupo(int $idgrupo) Return the first ChildGrupoViaje filtered by the idgrupo column
 * @method     ChildGrupoViaje findOneByIdviaje(int $idviaje) Return the first ChildGrupoViaje filtered by the idviaje column
 * @method     ChildGrupoViaje findOneByFavorito(boolean $favorito) Return the first ChildGrupoViaje filtered by the favorito column *

 * @method     ChildGrupoViaje requirePk($key, ConnectionInterface $con = null) Return the ChildGrupoViaje by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGrupoViaje requireOne(ConnectionInterface $con = null) Return the first ChildGrupoViaje matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGrupoViaje requireOneByIdgrupo(int $idgrupo) Return the first ChildGrupoViaje filtered by the idgrupo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGrupoViaje requireOneByIdviaje(int $idviaje) Return the first ChildGrupoViaje filtered by the idviaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGrupoViaje requireOneByFavorito(boolean $favorito) Return the first ChildGrupoViaje filtered by the favorito column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGrupoViaje[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGrupoViaje objects based on current ModelCriteria
 * @method     ChildGrupoViaje[]|ObjectCollection findByIdgrupo(int $idgrupo) Return ChildGrupoViaje objects filtered by the idgrupo column
 * @method     ChildGrupoViaje[]|ObjectCollection findByIdviaje(int $idviaje) Return ChildGrupoViaje objects filtered by the idviaje column
 * @method     ChildGrupoViaje[]|ObjectCollection findByFavorito(boolean $favorito) Return ChildGrupoViaje objects filtered by the favorito column
 * @method     ChildGrupoViaje[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GrupoViajeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GrupoViajeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\GrupoViaje', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGrupoViajeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGrupoViajeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGrupoViajeQuery) {
            return $criteria;
        }
        $query = new ChildGrupoViajeQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$idgrupo, $idviaje, $favorito] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGrupoViaje|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GrupoViajeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GrupoViajeTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildGrupoViaje A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idgrupo, idviaje, favorito FROM grupo_viaje WHERE idgrupo = :p0 AND idviaje = :p1 AND favorito = :p2';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', (int) $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildGrupoViaje $obj */
            $obj = new ChildGrupoViaje();
            $obj->hydrate($row);
            GrupoViajeTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildGrupoViaje|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(GrupoViajeTableMap::COL_IDGRUPO, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(GrupoViajeTableMap::COL_IDVIAJE, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(GrupoViajeTableMap::COL_FAVORITO, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(GrupoViajeTableMap::COL_IDGRUPO, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(GrupoViajeTableMap::COL_IDVIAJE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(GrupoViajeTableMap::COL_FAVORITO, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
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
     * @see       filterByGrupo()
     *
     * @param     mixed $idgrupo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function filterByIdgrupo($idgrupo = null, $comparison = null)
    {
        if (is_array($idgrupo)) {
            $useMinMax = false;
            if (isset($idgrupo['min'])) {
                $this->addUsingAlias(GrupoViajeTableMap::COL_IDGRUPO, $idgrupo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idgrupo['max'])) {
                $this->addUsingAlias(GrupoViajeTableMap::COL_IDGRUPO, $idgrupo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrupoViajeTableMap::COL_IDGRUPO, $idgrupo, $comparison);
    }

    /**
     * Filter the query on the idviaje column
     *
     * Example usage:
     * <code>
     * $query->filterByIdviaje(1234); // WHERE idviaje = 1234
     * $query->filterByIdviaje(array(12, 34)); // WHERE idviaje IN (12, 34)
     * $query->filterByIdviaje(array('min' => 12)); // WHERE idviaje > 12
     * </code>
     *
     * @see       filterByViaje()
     *
     * @param     mixed $idviaje The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function filterByIdviaje($idviaje = null, $comparison = null)
    {
        if (is_array($idviaje)) {
            $useMinMax = false;
            if (isset($idviaje['min'])) {
                $this->addUsingAlias(GrupoViajeTableMap::COL_IDVIAJE, $idviaje['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idviaje['max'])) {
                $this->addUsingAlias(GrupoViajeTableMap::COL_IDVIAJE, $idviaje['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GrupoViajeTableMap::COL_IDVIAJE, $idviaje, $comparison);
    }

    /**
     * Filter the query on the favorito column
     *
     * Example usage:
     * <code>
     * $query->filterByFavorito(true); // WHERE favorito = true
     * $query->filterByFavorito('yes'); // WHERE favorito = true
     * </code>
     *
     * @param     boolean|string $favorito The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function filterByFavorito($favorito = null, $comparison = null)
    {
        if (is_string($favorito)) {
            $favorito = in_array(strtolower($favorito), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GrupoViajeTableMap::COL_FAVORITO, $favorito, $comparison);
    }

    /**
     * Filter the query by a related \Grupo object
     *
     * @param \Grupo|ObjectCollection $grupo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function filterByGrupo($grupo, $comparison = null)
    {
        if ($grupo instanceof \Grupo) {
            return $this
                ->addUsingAlias(GrupoViajeTableMap::COL_IDGRUPO, $grupo->getIdgrupo(), $comparison);
        } elseif ($grupo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GrupoViajeTableMap::COL_IDGRUPO, $grupo->toKeyValue('Idgrupo', 'Idgrupo'), $comparison);
        } else {
            throw new PropelException('filterByGrupo() only accepts arguments of type \Grupo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Grupo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function joinGrupo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Grupo');

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
            $this->addJoinObject($join, 'Grupo');
        }

        return $this;
    }

    /**
     * Use the Grupo relation Grupo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GrupoQuery A secondary query class using the current class as primary query
     */
    public function useGrupoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGrupo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Grupo', '\GrupoQuery');
    }

    /**
     * Filter the query by a related \Viaje object
     *
     * @param \Viaje|ObjectCollection $viaje The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function filterByViaje($viaje, $comparison = null)
    {
        if ($viaje instanceof \Viaje) {
            return $this
                ->addUsingAlias(GrupoViajeTableMap::COL_IDVIAJE, $viaje->getIdviaje(), $comparison);
        } elseif ($viaje instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GrupoViajeTableMap::COL_IDVIAJE, $viaje->toKeyValue('PrimaryKey', 'Idviaje'), $comparison);
        } else {
            throw new PropelException('filterByViaje() only accepts arguments of type \Viaje or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Viaje relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function joinViaje($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Viaje');

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
            $this->addJoinObject($join, 'Viaje');
        }

        return $this;
    }

    /**
     * Use the Viaje relation Viaje object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ViajeQuery A secondary query class using the current class as primary query
     */
    public function useViajeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinViaje($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Viaje', '\ViajeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGrupoViaje $grupoViaje Object to remove from the list of results
     *
     * @return $this|ChildGrupoViajeQuery The current query, for fluid interface
     */
    public function prune($grupoViaje = null)
    {
        if ($grupoViaje) {
            $this->addCond('pruneCond0', $this->getAliasedColName(GrupoViajeTableMap::COL_IDGRUPO), $grupoViaje->getIdgrupo(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(GrupoViajeTableMap::COL_IDVIAJE), $grupoViaje->getIdviaje(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(GrupoViajeTableMap::COL_FAVORITO), $grupoViaje->getFavorito(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the grupo_viaje table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GrupoViajeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GrupoViajeTableMap::clearInstancePool();
            GrupoViajeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GrupoViajeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GrupoViajeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            GrupoViajeTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            GrupoViajeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GrupoViajeQuery
