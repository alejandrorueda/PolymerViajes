<?php

namespace Base;

use \ViajeMensajes as ChildViajeMensajes;
use \ViajeMensajesQuery as ChildViajeMensajesQuery;
use \Exception;
use \PDO;
use Map\ViajeMensajesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'viaje_mensajes' table.
 *
 * 
 *
 * @method     ChildViajeMensajesQuery orderByIdviaje($order = Criteria::ASC) Order by the idviaje column
 * @method     ChildViajeMensajesQuery orderByIdmensaje($order = Criteria::ASC) Order by the idmensaje column
 *
 * @method     ChildViajeMensajesQuery groupByIdviaje() Group by the idviaje column
 * @method     ChildViajeMensajesQuery groupByIdmensaje() Group by the idmensaje column
 *
 * @method     ChildViajeMensajesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildViajeMensajesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildViajeMensajesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildViajeMensajesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildViajeMensajesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildViajeMensajesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildViajeMensajesQuery leftJoinViaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the Viaje relation
 * @method     ChildViajeMensajesQuery rightJoinViaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Viaje relation
 * @method     ChildViajeMensajesQuery innerJoinViaje($relationAlias = null) Adds a INNER JOIN clause to the query using the Viaje relation
 *
 * @method     ChildViajeMensajesQuery joinWithViaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Viaje relation
 *
 * @method     ChildViajeMensajesQuery leftJoinWithViaje() Adds a LEFT JOIN clause and with to the query using the Viaje relation
 * @method     ChildViajeMensajesQuery rightJoinWithViaje() Adds a RIGHT JOIN clause and with to the query using the Viaje relation
 * @method     ChildViajeMensajesQuery innerJoinWithViaje() Adds a INNER JOIN clause and with to the query using the Viaje relation
 *
 * @method     ChildViajeMensajesQuery leftJoinMensaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mensaje relation
 * @method     ChildViajeMensajesQuery rightJoinMensaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mensaje relation
 * @method     ChildViajeMensajesQuery innerJoinMensaje($relationAlias = null) Adds a INNER JOIN clause to the query using the Mensaje relation
 *
 * @method     ChildViajeMensajesQuery joinWithMensaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Mensaje relation
 *
 * @method     ChildViajeMensajesQuery leftJoinWithMensaje() Adds a LEFT JOIN clause and with to the query using the Mensaje relation
 * @method     ChildViajeMensajesQuery rightJoinWithMensaje() Adds a RIGHT JOIN clause and with to the query using the Mensaje relation
 * @method     ChildViajeMensajesQuery innerJoinWithMensaje() Adds a INNER JOIN clause and with to the query using the Mensaje relation
 *
 * @method     \ViajeQuery|\MensajeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildViajeMensajes findOne(ConnectionInterface $con = null) Return the first ChildViajeMensajes matching the query
 * @method     ChildViajeMensajes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildViajeMensajes matching the query, or a new ChildViajeMensajes object populated from the query conditions when no match is found
 *
 * @method     ChildViajeMensajes findOneByIdviaje(int $idviaje) Return the first ChildViajeMensajes filtered by the idviaje column
 * @method     ChildViajeMensajes findOneByIdmensaje(int $idmensaje) Return the first ChildViajeMensajes filtered by the idmensaje column *

 * @method     ChildViajeMensajes requirePk($key, ConnectionInterface $con = null) Return the ChildViajeMensajes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViajeMensajes requireOne(ConnectionInterface $con = null) Return the first ChildViajeMensajes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildViajeMensajes requireOneByIdviaje(int $idviaje) Return the first ChildViajeMensajes filtered by the idviaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViajeMensajes requireOneByIdmensaje(int $idmensaje) Return the first ChildViajeMensajes filtered by the idmensaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildViajeMensajes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildViajeMensajes objects based on current ModelCriteria
 * @method     ChildViajeMensajes[]|ObjectCollection findByIdviaje(int $idviaje) Return ChildViajeMensajes objects filtered by the idviaje column
 * @method     ChildViajeMensajes[]|ObjectCollection findByIdmensaje(int $idmensaje) Return ChildViajeMensajes objects filtered by the idmensaje column
 * @method     ChildViajeMensajes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ViajeMensajesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ViajeMensajesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\ViajeMensajes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildViajeMensajesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildViajeMensajesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildViajeMensajesQuery) {
            return $criteria;
        }
        $query = new ChildViajeMensajesQuery();
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
     * @param array[$idviaje, $idmensaje] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildViajeMensajes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ViajeMensajesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ViajeMensajesTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildViajeMensajes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idviaje, idmensaje FROM viaje_mensajes WHERE idviaje = :p0 AND idmensaje = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildViajeMensajes $obj */
            $obj = new ChildViajeMensajes();
            $obj->hydrate($row);
            ViajeMensajesTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildViajeMensajes|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ViajeMensajesTableMap::COL_IDVIAJE, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ViajeMensajesTableMap::COL_IDMENSAJE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ViajeMensajesTableMap::COL_IDVIAJE, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ViajeMensajesTableMap::COL_IDMENSAJE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function filterByIdviaje($idviaje = null, $comparison = null)
    {
        if (is_array($idviaje)) {
            $useMinMax = false;
            if (isset($idviaje['min'])) {
                $this->addUsingAlias(ViajeMensajesTableMap::COL_IDVIAJE, $idviaje['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idviaje['max'])) {
                $this->addUsingAlias(ViajeMensajesTableMap::COL_IDVIAJE, $idviaje['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeMensajesTableMap::COL_IDVIAJE, $idviaje, $comparison);
    }

    /**
     * Filter the query on the idmensaje column
     *
     * Example usage:
     * <code>
     * $query->filterByIdmensaje(1234); // WHERE idmensaje = 1234
     * $query->filterByIdmensaje(array(12, 34)); // WHERE idmensaje IN (12, 34)
     * $query->filterByIdmensaje(array('min' => 12)); // WHERE idmensaje > 12
     * </code>
     *
     * @see       filterByMensaje()
     *
     * @param     mixed $idmensaje The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function filterByIdmensaje($idmensaje = null, $comparison = null)
    {
        if (is_array($idmensaje)) {
            $useMinMax = false;
            if (isset($idmensaje['min'])) {
                $this->addUsingAlias(ViajeMensajesTableMap::COL_IDMENSAJE, $idmensaje['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idmensaje['max'])) {
                $this->addUsingAlias(ViajeMensajesTableMap::COL_IDMENSAJE, $idmensaje['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeMensajesTableMap::COL_IDMENSAJE, $idmensaje, $comparison);
    }

    /**
     * Filter the query by a related \Viaje object
     *
     * @param \Viaje|ObjectCollection $viaje The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function filterByViaje($viaje, $comparison = null)
    {
        if ($viaje instanceof \Viaje) {
            return $this
                ->addUsingAlias(ViajeMensajesTableMap::COL_IDVIAJE, $viaje->getIdviaje(), $comparison);
        } elseif ($viaje instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ViajeMensajesTableMap::COL_IDVIAJE, $viaje->toKeyValue('PrimaryKey', 'Idviaje'), $comparison);
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
     * @return $this|ChildViajeMensajesQuery The current query, for fluid interface
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
     * Filter the query by a related \Mensaje object
     *
     * @param \Mensaje|ObjectCollection $mensaje The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function filterByMensaje($mensaje, $comparison = null)
    {
        if ($mensaje instanceof \Mensaje) {
            return $this
                ->addUsingAlias(ViajeMensajesTableMap::COL_IDMENSAJE, $mensaje->getIdmensaje(), $comparison);
        } elseif ($mensaje instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ViajeMensajesTableMap::COL_IDMENSAJE, $mensaje->toKeyValue('PrimaryKey', 'Idmensaje'), $comparison);
        } else {
            throw new PropelException('filterByMensaje() only accepts arguments of type \Mensaje or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Mensaje relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function joinMensaje($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Mensaje');

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
            $this->addJoinObject($join, 'Mensaje');
        }

        return $this;
    }

    /**
     * Use the Mensaje relation Mensaje object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MensajeQuery A secondary query class using the current class as primary query
     */
    public function useMensajeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMensaje($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mensaje', '\MensajeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildViajeMensajes $viajeMensajes Object to remove from the list of results
     *
     * @return $this|ChildViajeMensajesQuery The current query, for fluid interface
     */
    public function prune($viajeMensajes = null)
    {
        if ($viajeMensajes) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ViajeMensajesTableMap::COL_IDVIAJE), $viajeMensajes->getIdviaje(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ViajeMensajesTableMap::COL_IDMENSAJE), $viajeMensajes->getIdmensaje(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the viaje_mensajes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeMensajesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ViajeMensajesTableMap::clearInstancePool();
            ViajeMensajesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeMensajesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ViajeMensajesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ViajeMensajesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ViajeMensajesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ViajeMensajesQuery
