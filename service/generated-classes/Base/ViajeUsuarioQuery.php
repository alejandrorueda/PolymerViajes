<?php

namespace Base;

use \ViajeUsuario as ChildViajeUsuario;
use \ViajeUsuarioQuery as ChildViajeUsuarioQuery;
use \Exception;
use \PDO;
use Map\ViajeUsuarioTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'viaje_usuario' table.
 *
 * 
 *
 * @method     ChildViajeUsuarioQuery orderByIdviaje($order = Criteria::ASC) Order by the idviaje column
 * @method     ChildViajeUsuarioQuery orderByIdusuario($order = Criteria::ASC) Order by the idusuario column
 * @method     ChildViajeUsuarioQuery orderByAdministrador($order = Criteria::ASC) Order by the administrador column
 *
 * @method     ChildViajeUsuarioQuery groupByIdviaje() Group by the idviaje column
 * @method     ChildViajeUsuarioQuery groupByIdusuario() Group by the idusuario column
 * @method     ChildViajeUsuarioQuery groupByAdministrador() Group by the administrador column
 *
 * @method     ChildViajeUsuarioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildViajeUsuarioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildViajeUsuarioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildViajeUsuarioQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildViajeUsuarioQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildViajeUsuarioQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildViajeUsuarioQuery leftJoinViaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the Viaje relation
 * @method     ChildViajeUsuarioQuery rightJoinViaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Viaje relation
 * @method     ChildViajeUsuarioQuery innerJoinViaje($relationAlias = null) Adds a INNER JOIN clause to the query using the Viaje relation
 *
 * @method     ChildViajeUsuarioQuery joinWithViaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Viaje relation
 *
 * @method     ChildViajeUsuarioQuery leftJoinWithViaje() Adds a LEFT JOIN clause and with to the query using the Viaje relation
 * @method     ChildViajeUsuarioQuery rightJoinWithViaje() Adds a RIGHT JOIN clause and with to the query using the Viaje relation
 * @method     ChildViajeUsuarioQuery innerJoinWithViaje() Adds a INNER JOIN clause and with to the query using the Viaje relation
 *
 * @method     ChildViajeUsuarioQuery leftJoinUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Usuario relation
 * @method     ChildViajeUsuarioQuery rightJoinUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Usuario relation
 * @method     ChildViajeUsuarioQuery innerJoinUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the Usuario relation
 *
 * @method     ChildViajeUsuarioQuery joinWithUsuario($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Usuario relation
 *
 * @method     ChildViajeUsuarioQuery leftJoinWithUsuario() Adds a LEFT JOIN clause and with to the query using the Usuario relation
 * @method     ChildViajeUsuarioQuery rightJoinWithUsuario() Adds a RIGHT JOIN clause and with to the query using the Usuario relation
 * @method     ChildViajeUsuarioQuery innerJoinWithUsuario() Adds a INNER JOIN clause and with to the query using the Usuario relation
 *
 * @method     \ViajeQuery|\UsuarioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildViajeUsuario findOne(ConnectionInterface $con = null) Return the first ChildViajeUsuario matching the query
 * @method     ChildViajeUsuario findOneOrCreate(ConnectionInterface $con = null) Return the first ChildViajeUsuario matching the query, or a new ChildViajeUsuario object populated from the query conditions when no match is found
 *
 * @method     ChildViajeUsuario findOneByIdviaje(int $idviaje) Return the first ChildViajeUsuario filtered by the idviaje column
 * @method     ChildViajeUsuario findOneByIdusuario(string $idusuario) Return the first ChildViajeUsuario filtered by the idusuario column
 * @method     ChildViajeUsuario findOneByAdministrador(boolean $administrador) Return the first ChildViajeUsuario filtered by the administrador column *

 * @method     ChildViajeUsuario requirePk($key, ConnectionInterface $con = null) Return the ChildViajeUsuario by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViajeUsuario requireOne(ConnectionInterface $con = null) Return the first ChildViajeUsuario matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildViajeUsuario requireOneByIdviaje(int $idviaje) Return the first ChildViajeUsuario filtered by the idviaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViajeUsuario requireOneByIdusuario(string $idusuario) Return the first ChildViajeUsuario filtered by the idusuario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViajeUsuario requireOneByAdministrador(boolean $administrador) Return the first ChildViajeUsuario filtered by the administrador column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildViajeUsuario[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildViajeUsuario objects based on current ModelCriteria
 * @method     ChildViajeUsuario[]|ObjectCollection findByIdviaje(int $idviaje) Return ChildViajeUsuario objects filtered by the idviaje column
 * @method     ChildViajeUsuario[]|ObjectCollection findByIdusuario(string $idusuario) Return ChildViajeUsuario objects filtered by the idusuario column
 * @method     ChildViajeUsuario[]|ObjectCollection findByAdministrador(boolean $administrador) Return ChildViajeUsuario objects filtered by the administrador column
 * @method     ChildViajeUsuario[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ViajeUsuarioQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ViajeUsuarioQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\ViajeUsuario', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildViajeUsuarioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildViajeUsuarioQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildViajeUsuarioQuery) {
            return $criteria;
        }
        $query = new ChildViajeUsuarioQuery();
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
     * @param array[$idviaje, $idusuario] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildViajeUsuario|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ViajeUsuarioTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ViajeUsuarioTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildViajeUsuario A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idviaje, idusuario, administrador FROM viaje_usuario WHERE idviaje = :p0 AND idusuario = :p1';
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
            /** @var ChildViajeUsuario $obj */
            $obj = new ChildViajeUsuario();
            $obj->hydrate($row);
            ViajeUsuarioTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildViajeUsuario|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ViajeUsuarioTableMap::COL_IDVIAJE, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ViajeUsuarioTableMap::COL_IDUSUARIO, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ViajeUsuarioTableMap::COL_IDVIAJE, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ViajeUsuarioTableMap::COL_IDUSUARIO, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function filterByIdviaje($idviaje = null, $comparison = null)
    {
        if (is_array($idviaje)) {
            $useMinMax = false;
            if (isset($idviaje['min'])) {
                $this->addUsingAlias(ViajeUsuarioTableMap::COL_IDVIAJE, $idviaje['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idviaje['max'])) {
                $this->addUsingAlias(ViajeUsuarioTableMap::COL_IDVIAJE, $idviaje['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeUsuarioTableMap::COL_IDVIAJE, $idviaje, $comparison);
    }

    /**
     * Filter the query on the idusuario column
     *
     * Example usage:
     * <code>
     * $query->filterByIdusuario('fooValue');   // WHERE idusuario = 'fooValue'
     * $query->filterByIdusuario('%fooValue%'); // WHERE idusuario LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idusuario The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function filterByIdusuario($idusuario = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idusuario)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeUsuarioTableMap::COL_IDUSUARIO, $idusuario, $comparison);
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
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function filterByAdministrador($administrador = null, $comparison = null)
    {
        if (is_string($administrador)) {
            $administrador = in_array(strtolower($administrador), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ViajeUsuarioTableMap::COL_ADMINISTRADOR, $administrador, $comparison);
    }

    /**
     * Filter the query by a related \Viaje object
     *
     * @param \Viaje|ObjectCollection $viaje The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function filterByViaje($viaje, $comparison = null)
    {
        if ($viaje instanceof \Viaje) {
            return $this
                ->addUsingAlias(ViajeUsuarioTableMap::COL_IDVIAJE, $viaje->getIdviaje(), $comparison);
        } elseif ($viaje instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ViajeUsuarioTableMap::COL_IDVIAJE, $viaje->toKeyValue('PrimaryKey', 'Idviaje'), $comparison);
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
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
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
     * Filter the query by a related \Usuario object
     *
     * @param \Usuario|ObjectCollection $usuario The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = null)
    {
        if ($usuario instanceof \Usuario) {
            return $this
                ->addUsingAlias(ViajeUsuarioTableMap::COL_IDUSUARIO, $usuario->getIdusuario(), $comparison);
        } elseif ($usuario instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ViajeUsuarioTableMap::COL_IDUSUARIO, $usuario->toKeyValue('PrimaryKey', 'Idusuario'), $comparison);
        } else {
            throw new PropelException('filterByUsuario() only accepts arguments of type \Usuario or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Usuario relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function joinUsuario($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Usuario');

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
            $this->addJoinObject($join, 'Usuario');
        }

        return $this;
    }

    /**
     * Use the Usuario relation Usuario object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsuarioQuery A secondary query class using the current class as primary query
     */
    public function useUsuarioQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsuario($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Usuario', '\UsuarioQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildViajeUsuario $viajeUsuario Object to remove from the list of results
     *
     * @return $this|ChildViajeUsuarioQuery The current query, for fluid interface
     */
    public function prune($viajeUsuario = null)
    {
        if ($viajeUsuario) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ViajeUsuarioTableMap::COL_IDVIAJE), $viajeUsuario->getIdviaje(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ViajeUsuarioTableMap::COL_IDUSUARIO), $viajeUsuario->getIdusuario(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the viaje_usuario table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeUsuarioTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ViajeUsuarioTableMap::clearInstancePool();
            ViajeUsuarioTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeUsuarioTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ViajeUsuarioTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ViajeUsuarioTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ViajeUsuarioTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ViajeUsuarioQuery
