<?php

namespace Base;

use \MiembrosGrupo as ChildMiembrosGrupo;
use \MiembrosGrupoQuery as ChildMiembrosGrupoQuery;
use \Exception;
use \PDO;
use Map\MiembrosGrupoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'miembros_grupo' table.
 *
 * 
 *
 * @method     ChildMiembrosGrupoQuery orderByIdgrupo($order = Criteria::ASC) Order by the idgrupo column
 * @method     ChildMiembrosGrupoQuery orderByIdusuario($order = Criteria::ASC) Order by the idusuario column
 *
 * @method     ChildMiembrosGrupoQuery groupByIdgrupo() Group by the idgrupo column
 * @method     ChildMiembrosGrupoQuery groupByIdusuario() Group by the idusuario column
 *
 * @method     ChildMiembrosGrupoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMiembrosGrupoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMiembrosGrupoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMiembrosGrupoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMiembrosGrupoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMiembrosGrupoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMiembrosGrupoQuery leftJoinGrupo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Grupo relation
 * @method     ChildMiembrosGrupoQuery rightJoinGrupo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Grupo relation
 * @method     ChildMiembrosGrupoQuery innerJoinGrupo($relationAlias = null) Adds a INNER JOIN clause to the query using the Grupo relation
 *
 * @method     ChildMiembrosGrupoQuery joinWithGrupo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Grupo relation
 *
 * @method     ChildMiembrosGrupoQuery leftJoinWithGrupo() Adds a LEFT JOIN clause and with to the query using the Grupo relation
 * @method     ChildMiembrosGrupoQuery rightJoinWithGrupo() Adds a RIGHT JOIN clause and with to the query using the Grupo relation
 * @method     ChildMiembrosGrupoQuery innerJoinWithGrupo() Adds a INNER JOIN clause and with to the query using the Grupo relation
 *
 * @method     ChildMiembrosGrupoQuery leftJoinUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Usuario relation
 * @method     ChildMiembrosGrupoQuery rightJoinUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Usuario relation
 * @method     ChildMiembrosGrupoQuery innerJoinUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the Usuario relation
 *
 * @method     ChildMiembrosGrupoQuery joinWithUsuario($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Usuario relation
 *
 * @method     ChildMiembrosGrupoQuery leftJoinWithUsuario() Adds a LEFT JOIN clause and with to the query using the Usuario relation
 * @method     ChildMiembrosGrupoQuery rightJoinWithUsuario() Adds a RIGHT JOIN clause and with to the query using the Usuario relation
 * @method     ChildMiembrosGrupoQuery innerJoinWithUsuario() Adds a INNER JOIN clause and with to the query using the Usuario relation
 *
 * @method     \GrupoQuery|\UsuarioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMiembrosGrupo findOne(ConnectionInterface $con = null) Return the first ChildMiembrosGrupo matching the query
 * @method     ChildMiembrosGrupo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMiembrosGrupo matching the query, or a new ChildMiembrosGrupo object populated from the query conditions when no match is found
 *
 * @method     ChildMiembrosGrupo findOneByIdgrupo(int $idgrupo) Return the first ChildMiembrosGrupo filtered by the idgrupo column
 * @method     ChildMiembrosGrupo findOneByIdusuario(string $idusuario) Return the first ChildMiembrosGrupo filtered by the idusuario column *

 * @method     ChildMiembrosGrupo requirePk($key, ConnectionInterface $con = null) Return the ChildMiembrosGrupo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMiembrosGrupo requireOne(ConnectionInterface $con = null) Return the first ChildMiembrosGrupo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMiembrosGrupo requireOneByIdgrupo(int $idgrupo) Return the first ChildMiembrosGrupo filtered by the idgrupo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMiembrosGrupo requireOneByIdusuario(string $idusuario) Return the first ChildMiembrosGrupo filtered by the idusuario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMiembrosGrupo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMiembrosGrupo objects based on current ModelCriteria
 * @method     ChildMiembrosGrupo[]|ObjectCollection findByIdgrupo(int $idgrupo) Return ChildMiembrosGrupo objects filtered by the idgrupo column
 * @method     ChildMiembrosGrupo[]|ObjectCollection findByIdusuario(string $idusuario) Return ChildMiembrosGrupo objects filtered by the idusuario column
 * @method     ChildMiembrosGrupo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MiembrosGrupoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MiembrosGrupoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\MiembrosGrupo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMiembrosGrupoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMiembrosGrupoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMiembrosGrupoQuery) {
            return $criteria;
        }
        $query = new ChildMiembrosGrupoQuery();
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
     * @param array[$idgrupo, $idusuario] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMiembrosGrupo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MiembrosGrupoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MiembrosGrupoTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildMiembrosGrupo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idgrupo, idusuario FROM miembros_grupo WHERE idgrupo = :p0 AND idusuario = :p1';
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
            /** @var ChildMiembrosGrupo $obj */
            $obj = new ChildMiembrosGrupo();
            $obj->hydrate($row);
            MiembrosGrupoTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildMiembrosGrupo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMiembrosGrupoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MiembrosGrupoTableMap::COL_IDGRUPO, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MiembrosGrupoTableMap::COL_IDUSUARIO, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMiembrosGrupoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MiembrosGrupoTableMap::COL_IDGRUPO, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MiembrosGrupoTableMap::COL_IDUSUARIO, $key[1], Criteria::EQUAL);
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
     * @see       filterByGrupo()
     *
     * @param     mixed $idgrupo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiembrosGrupoQuery The current query, for fluid interface
     */
    public function filterByIdgrupo($idgrupo = null, $comparison = null)
    {
        if (is_array($idgrupo)) {
            $useMinMax = false;
            if (isset($idgrupo['min'])) {
                $this->addUsingAlias(MiembrosGrupoTableMap::COL_IDGRUPO, $idgrupo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idgrupo['max'])) {
                $this->addUsingAlias(MiembrosGrupoTableMap::COL_IDGRUPO, $idgrupo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiembrosGrupoTableMap::COL_IDGRUPO, $idgrupo, $comparison);
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
     * @return $this|ChildMiembrosGrupoQuery The current query, for fluid interface
     */
    public function filterByIdusuario($idusuario = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idusuario)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiembrosGrupoTableMap::COL_IDUSUARIO, $idusuario, $comparison);
    }

    /**
     * Filter the query by a related \Grupo object
     *
     * @param \Grupo|ObjectCollection $grupo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMiembrosGrupoQuery The current query, for fluid interface
     */
    public function filterByGrupo($grupo, $comparison = null)
    {
        if ($grupo instanceof \Grupo) {
            return $this
                ->addUsingAlias(MiembrosGrupoTableMap::COL_IDGRUPO, $grupo->getIdgrupo(), $comparison);
        } elseif ($grupo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MiembrosGrupoTableMap::COL_IDGRUPO, $grupo->toKeyValue('Idgrupo', 'Idgrupo'), $comparison);
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
     * @return $this|ChildMiembrosGrupoQuery The current query, for fluid interface
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
     * Filter the query by a related \Usuario object
     *
     * @param \Usuario|ObjectCollection $usuario The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMiembrosGrupoQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = null)
    {
        if ($usuario instanceof \Usuario) {
            return $this
                ->addUsingAlias(MiembrosGrupoTableMap::COL_IDUSUARIO, $usuario->getIdusuario(), $comparison);
        } elseif ($usuario instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MiembrosGrupoTableMap::COL_IDUSUARIO, $usuario->toKeyValue('PrimaryKey', 'Idusuario'), $comparison);
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
     * @return $this|ChildMiembrosGrupoQuery The current query, for fluid interface
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
     * @param   ChildMiembrosGrupo $miembrosGrupo Object to remove from the list of results
     *
     * @return $this|ChildMiembrosGrupoQuery The current query, for fluid interface
     */
    public function prune($miembrosGrupo = null)
    {
        if ($miembrosGrupo) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MiembrosGrupoTableMap::COL_IDGRUPO), $miembrosGrupo->getIdgrupo(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MiembrosGrupoTableMap::COL_IDUSUARIO), $miembrosGrupo->getIdusuario(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the miembros_grupo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MiembrosGrupoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MiembrosGrupoTableMap::clearInstancePool();
            MiembrosGrupoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MiembrosGrupoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MiembrosGrupoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            MiembrosGrupoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MiembrosGrupoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MiembrosGrupoQuery
