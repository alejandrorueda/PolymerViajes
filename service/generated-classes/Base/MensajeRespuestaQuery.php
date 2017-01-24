<?php

namespace Base;

use \MensajeRespuesta as ChildMensajeRespuesta;
use \MensajeRespuestaQuery as ChildMensajeRespuestaQuery;
use \Exception;
use \PDO;
use Map\MensajeRespuestaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'mensaje_respuesta' table.
 *
 * 
 *
 * @method     ChildMensajeRespuestaQuery orderByIdmensaje($order = Criteria::ASC) Order by the idmensaje column
 * @method     ChildMensajeRespuestaQuery orderByIdrespuesta($order = Criteria::ASC) Order by the idrespuesta column
 *
 * @method     ChildMensajeRespuestaQuery groupByIdmensaje() Group by the idmensaje column
 * @method     ChildMensajeRespuestaQuery groupByIdrespuesta() Group by the idrespuesta column
 *
 * @method     ChildMensajeRespuestaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMensajeRespuestaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMensajeRespuestaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMensajeRespuestaQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMensajeRespuestaQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMensajeRespuestaQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMensajeRespuestaQuery leftJoinMensajeRelatedByIdmensaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the MensajeRelatedByIdmensaje relation
 * @method     ChildMensajeRespuestaQuery rightJoinMensajeRelatedByIdmensaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MensajeRelatedByIdmensaje relation
 * @method     ChildMensajeRespuestaQuery innerJoinMensajeRelatedByIdmensaje($relationAlias = null) Adds a INNER JOIN clause to the query using the MensajeRelatedByIdmensaje relation
 *
 * @method     ChildMensajeRespuestaQuery joinWithMensajeRelatedByIdmensaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MensajeRelatedByIdmensaje relation
 *
 * @method     ChildMensajeRespuestaQuery leftJoinWithMensajeRelatedByIdmensaje() Adds a LEFT JOIN clause and with to the query using the MensajeRelatedByIdmensaje relation
 * @method     ChildMensajeRespuestaQuery rightJoinWithMensajeRelatedByIdmensaje() Adds a RIGHT JOIN clause and with to the query using the MensajeRelatedByIdmensaje relation
 * @method     ChildMensajeRespuestaQuery innerJoinWithMensajeRelatedByIdmensaje() Adds a INNER JOIN clause and with to the query using the MensajeRelatedByIdmensaje relation
 *
 * @method     ChildMensajeRespuestaQuery leftJoinMensajeRelatedByIdrespuesta($relationAlias = null) Adds a LEFT JOIN clause to the query using the MensajeRelatedByIdrespuesta relation
 * @method     ChildMensajeRespuestaQuery rightJoinMensajeRelatedByIdrespuesta($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MensajeRelatedByIdrespuesta relation
 * @method     ChildMensajeRespuestaQuery innerJoinMensajeRelatedByIdrespuesta($relationAlias = null) Adds a INNER JOIN clause to the query using the MensajeRelatedByIdrespuesta relation
 *
 * @method     ChildMensajeRespuestaQuery joinWithMensajeRelatedByIdrespuesta($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MensajeRelatedByIdrespuesta relation
 *
 * @method     ChildMensajeRespuestaQuery leftJoinWithMensajeRelatedByIdrespuesta() Adds a LEFT JOIN clause and with to the query using the MensajeRelatedByIdrespuesta relation
 * @method     ChildMensajeRespuestaQuery rightJoinWithMensajeRelatedByIdrespuesta() Adds a RIGHT JOIN clause and with to the query using the MensajeRelatedByIdrespuesta relation
 * @method     ChildMensajeRespuestaQuery innerJoinWithMensajeRelatedByIdrespuesta() Adds a INNER JOIN clause and with to the query using the MensajeRelatedByIdrespuesta relation
 *
 * @method     \MensajeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMensajeRespuesta findOne(ConnectionInterface $con = null) Return the first ChildMensajeRespuesta matching the query
 * @method     ChildMensajeRespuesta findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMensajeRespuesta matching the query, or a new ChildMensajeRespuesta object populated from the query conditions when no match is found
 *
 * @method     ChildMensajeRespuesta findOneByIdmensaje(int $idmensaje) Return the first ChildMensajeRespuesta filtered by the idmensaje column
 * @method     ChildMensajeRespuesta findOneByIdrespuesta(int $idrespuesta) Return the first ChildMensajeRespuesta filtered by the idrespuesta column *

 * @method     ChildMensajeRespuesta requirePk($key, ConnectionInterface $con = null) Return the ChildMensajeRespuesta by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMensajeRespuesta requireOne(ConnectionInterface $con = null) Return the first ChildMensajeRespuesta matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMensajeRespuesta requireOneByIdmensaje(int $idmensaje) Return the first ChildMensajeRespuesta filtered by the idmensaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMensajeRespuesta requireOneByIdrespuesta(int $idrespuesta) Return the first ChildMensajeRespuesta filtered by the idrespuesta column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMensajeRespuesta[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMensajeRespuesta objects based on current ModelCriteria
 * @method     ChildMensajeRespuesta[]|ObjectCollection findByIdmensaje(int $idmensaje) Return ChildMensajeRespuesta objects filtered by the idmensaje column
 * @method     ChildMensajeRespuesta[]|ObjectCollection findByIdrespuesta(int $idrespuesta) Return ChildMensajeRespuesta objects filtered by the idrespuesta column
 * @method     ChildMensajeRespuesta[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MensajeRespuestaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MensajeRespuestaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\MensajeRespuesta', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMensajeRespuestaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMensajeRespuestaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMensajeRespuestaQuery) {
            return $criteria;
        }
        $query = new ChildMensajeRespuestaQuery();
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
     * @param array[$idmensaje, $idrespuesta] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMensajeRespuesta|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MensajeRespuestaTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MensajeRespuestaTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildMensajeRespuesta A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idmensaje, idrespuesta FROM mensaje_respuesta WHERE idmensaje = :p0 AND idrespuesta = :p1';
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
            /** @var ChildMensajeRespuesta $obj */
            $obj = new ChildMensajeRespuesta();
            $obj->hydrate($row);
            MensajeRespuestaTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildMensajeRespuesta|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDMENSAJE, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDRESPUESTA, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MensajeRespuestaTableMap::COL_IDMENSAJE, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MensajeRespuestaTableMap::COL_IDRESPUESTA, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByMensajeRelatedByIdmensaje()
     *
     * @param     mixed $idmensaje The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function filterByIdmensaje($idmensaje = null, $comparison = null)
    {
        if (is_array($idmensaje)) {
            $useMinMax = false;
            if (isset($idmensaje['min'])) {
                $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDMENSAJE, $idmensaje['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idmensaje['max'])) {
                $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDMENSAJE, $idmensaje['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDMENSAJE, $idmensaje, $comparison);
    }

    /**
     * Filter the query on the idrespuesta column
     *
     * Example usage:
     * <code>
     * $query->filterByIdrespuesta(1234); // WHERE idrespuesta = 1234
     * $query->filterByIdrespuesta(array(12, 34)); // WHERE idrespuesta IN (12, 34)
     * $query->filterByIdrespuesta(array('min' => 12)); // WHERE idrespuesta > 12
     * </code>
     *
     * @see       filterByMensajeRelatedByIdrespuesta()
     *
     * @param     mixed $idrespuesta The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function filterByIdrespuesta($idrespuesta = null, $comparison = null)
    {
        if (is_array($idrespuesta)) {
            $useMinMax = false;
            if (isset($idrespuesta['min'])) {
                $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDRESPUESTA, $idrespuesta['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idrespuesta['max'])) {
                $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDRESPUESTA, $idrespuesta['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MensajeRespuestaTableMap::COL_IDRESPUESTA, $idrespuesta, $comparison);
    }

    /**
     * Filter the query by a related \Mensaje object
     *
     * @param \Mensaje|ObjectCollection $mensaje The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function filterByMensajeRelatedByIdmensaje($mensaje, $comparison = null)
    {
        if ($mensaje instanceof \Mensaje) {
            return $this
                ->addUsingAlias(MensajeRespuestaTableMap::COL_IDMENSAJE, $mensaje->getIdmensaje(), $comparison);
        } elseif ($mensaje instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MensajeRespuestaTableMap::COL_IDMENSAJE, $mensaje->toKeyValue('PrimaryKey', 'Idmensaje'), $comparison);
        } else {
            throw new PropelException('filterByMensajeRelatedByIdmensaje() only accepts arguments of type \Mensaje or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MensajeRelatedByIdmensaje relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function joinMensajeRelatedByIdmensaje($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MensajeRelatedByIdmensaje');

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
            $this->addJoinObject($join, 'MensajeRelatedByIdmensaje');
        }

        return $this;
    }

    /**
     * Use the MensajeRelatedByIdmensaje relation Mensaje object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MensajeQuery A secondary query class using the current class as primary query
     */
    public function useMensajeRelatedByIdmensajeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMensajeRelatedByIdmensaje($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MensajeRelatedByIdmensaje', '\MensajeQuery');
    }

    /**
     * Filter the query by a related \Mensaje object
     *
     * @param \Mensaje|ObjectCollection $mensaje The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function filterByMensajeRelatedByIdrespuesta($mensaje, $comparison = null)
    {
        if ($mensaje instanceof \Mensaje) {
            return $this
                ->addUsingAlias(MensajeRespuestaTableMap::COL_IDRESPUESTA, $mensaje->getIdmensaje(), $comparison);
        } elseif ($mensaje instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MensajeRespuestaTableMap::COL_IDRESPUESTA, $mensaje->toKeyValue('PrimaryKey', 'Idmensaje'), $comparison);
        } else {
            throw new PropelException('filterByMensajeRelatedByIdrespuesta() only accepts arguments of type \Mensaje or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MensajeRelatedByIdrespuesta relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function joinMensajeRelatedByIdrespuesta($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MensajeRelatedByIdrespuesta');

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
            $this->addJoinObject($join, 'MensajeRelatedByIdrespuesta');
        }

        return $this;
    }

    /**
     * Use the MensajeRelatedByIdrespuesta relation Mensaje object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MensajeQuery A secondary query class using the current class as primary query
     */
    public function useMensajeRelatedByIdrespuestaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMensajeRelatedByIdrespuesta($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MensajeRelatedByIdrespuesta', '\MensajeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMensajeRespuesta $mensajeRespuesta Object to remove from the list of results
     *
     * @return $this|ChildMensajeRespuestaQuery The current query, for fluid interface
     */
    public function prune($mensajeRespuesta = null)
    {
        if ($mensajeRespuesta) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MensajeRespuestaTableMap::COL_IDMENSAJE), $mensajeRespuesta->getIdmensaje(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MensajeRespuestaTableMap::COL_IDRESPUESTA), $mensajeRespuesta->getIdrespuesta(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mensaje_respuesta table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MensajeRespuestaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MensajeRespuestaTableMap::clearInstancePool();
            MensajeRespuestaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MensajeRespuestaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MensajeRespuestaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            MensajeRespuestaTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MensajeRespuestaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MensajeRespuestaQuery
