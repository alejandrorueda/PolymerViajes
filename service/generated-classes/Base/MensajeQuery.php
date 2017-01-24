<?php

namespace Base;

use \Mensaje as ChildMensaje;
use \MensajeQuery as ChildMensajeQuery;
use \Exception;
use \PDO;
use Map\MensajeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'mensaje' table.
 *
 * 
 *
 * @method     ChildMensajeQuery orderByIdmensaje($order = Criteria::ASC) Order by the idmensaje column
 * @method     ChildMensajeQuery orderByDescripcion($order = Criteria::ASC) Order by the descripcion column
 * @method     ChildMensajeQuery orderByAsunto($order = Criteria::ASC) Order by the asunto column
 * @method     ChildMensajeQuery orderByIdusuario($order = Criteria::ASC) Order by the idusuario column
 *
 * @method     ChildMensajeQuery groupByIdmensaje() Group by the idmensaje column
 * @method     ChildMensajeQuery groupByDescripcion() Group by the descripcion column
 * @method     ChildMensajeQuery groupByAsunto() Group by the asunto column
 * @method     ChildMensajeQuery groupByIdusuario() Group by the idusuario column
 *
 * @method     ChildMensajeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMensajeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMensajeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMensajeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMensajeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMensajeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMensajeQuery leftJoinUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Usuario relation
 * @method     ChildMensajeQuery rightJoinUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Usuario relation
 * @method     ChildMensajeQuery innerJoinUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the Usuario relation
 *
 * @method     ChildMensajeQuery joinWithUsuario($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Usuario relation
 *
 * @method     ChildMensajeQuery leftJoinWithUsuario() Adds a LEFT JOIN clause and with to the query using the Usuario relation
 * @method     ChildMensajeQuery rightJoinWithUsuario() Adds a RIGHT JOIN clause and with to the query using the Usuario relation
 * @method     ChildMensajeQuery innerJoinWithUsuario() Adds a INNER JOIN clause and with to the query using the Usuario relation
 *
 * @method     ChildMensajeQuery leftJoinViajeMensajes($relationAlias = null) Adds a LEFT JOIN clause to the query using the ViajeMensajes relation
 * @method     ChildMensajeQuery rightJoinViajeMensajes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ViajeMensajes relation
 * @method     ChildMensajeQuery innerJoinViajeMensajes($relationAlias = null) Adds a INNER JOIN clause to the query using the ViajeMensajes relation
 *
 * @method     ChildMensajeQuery joinWithViajeMensajes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ViajeMensajes relation
 *
 * @method     ChildMensajeQuery leftJoinWithViajeMensajes() Adds a LEFT JOIN clause and with to the query using the ViajeMensajes relation
 * @method     ChildMensajeQuery rightJoinWithViajeMensajes() Adds a RIGHT JOIN clause and with to the query using the ViajeMensajes relation
 * @method     ChildMensajeQuery innerJoinWithViajeMensajes() Adds a INNER JOIN clause and with to the query using the ViajeMensajes relation
 *
 * @method     ChildMensajeQuery leftJoinMensajeRespuestaRelatedByIdmensaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the MensajeRespuestaRelatedByIdmensaje relation
 * @method     ChildMensajeQuery rightJoinMensajeRespuestaRelatedByIdmensaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MensajeRespuestaRelatedByIdmensaje relation
 * @method     ChildMensajeQuery innerJoinMensajeRespuestaRelatedByIdmensaje($relationAlias = null) Adds a INNER JOIN clause to the query using the MensajeRespuestaRelatedByIdmensaje relation
 *
 * @method     ChildMensajeQuery joinWithMensajeRespuestaRelatedByIdmensaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MensajeRespuestaRelatedByIdmensaje relation
 *
 * @method     ChildMensajeQuery leftJoinWithMensajeRespuestaRelatedByIdmensaje() Adds a LEFT JOIN clause and with to the query using the MensajeRespuestaRelatedByIdmensaje relation
 * @method     ChildMensajeQuery rightJoinWithMensajeRespuestaRelatedByIdmensaje() Adds a RIGHT JOIN clause and with to the query using the MensajeRespuestaRelatedByIdmensaje relation
 * @method     ChildMensajeQuery innerJoinWithMensajeRespuestaRelatedByIdmensaje() Adds a INNER JOIN clause and with to the query using the MensajeRespuestaRelatedByIdmensaje relation
 *
 * @method     ChildMensajeQuery leftJoinMensajeRespuestaRelatedByIdrespuesta($relationAlias = null) Adds a LEFT JOIN clause to the query using the MensajeRespuestaRelatedByIdrespuesta relation
 * @method     ChildMensajeQuery rightJoinMensajeRespuestaRelatedByIdrespuesta($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MensajeRespuestaRelatedByIdrespuesta relation
 * @method     ChildMensajeQuery innerJoinMensajeRespuestaRelatedByIdrespuesta($relationAlias = null) Adds a INNER JOIN clause to the query using the MensajeRespuestaRelatedByIdrespuesta relation
 *
 * @method     ChildMensajeQuery joinWithMensajeRespuestaRelatedByIdrespuesta($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MensajeRespuestaRelatedByIdrespuesta relation
 *
 * @method     ChildMensajeQuery leftJoinWithMensajeRespuestaRelatedByIdrespuesta() Adds a LEFT JOIN clause and with to the query using the MensajeRespuestaRelatedByIdrespuesta relation
 * @method     ChildMensajeQuery rightJoinWithMensajeRespuestaRelatedByIdrespuesta() Adds a RIGHT JOIN clause and with to the query using the MensajeRespuestaRelatedByIdrespuesta relation
 * @method     ChildMensajeQuery innerJoinWithMensajeRespuestaRelatedByIdrespuesta() Adds a INNER JOIN clause and with to the query using the MensajeRespuestaRelatedByIdrespuesta relation
 *
 * @method     \UsuarioQuery|\ViajeMensajesQuery|\MensajeRespuestaQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMensaje findOne(ConnectionInterface $con = null) Return the first ChildMensaje matching the query
 * @method     ChildMensaje findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMensaje matching the query, or a new ChildMensaje object populated from the query conditions when no match is found
 *
 * @method     ChildMensaje findOneByIdmensaje(int $idmensaje) Return the first ChildMensaje filtered by the idmensaje column
 * @method     ChildMensaje findOneByDescripcion(string $descripcion) Return the first ChildMensaje filtered by the descripcion column
 * @method     ChildMensaje findOneByAsunto(string $asunto) Return the first ChildMensaje filtered by the asunto column
 * @method     ChildMensaje findOneByIdusuario(string $idusuario) Return the first ChildMensaje filtered by the idusuario column *

 * @method     ChildMensaje requirePk($key, ConnectionInterface $con = null) Return the ChildMensaje by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMensaje requireOne(ConnectionInterface $con = null) Return the first ChildMensaje matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMensaje requireOneByIdmensaje(int $idmensaje) Return the first ChildMensaje filtered by the idmensaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMensaje requireOneByDescripcion(string $descripcion) Return the first ChildMensaje filtered by the descripcion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMensaje requireOneByAsunto(string $asunto) Return the first ChildMensaje filtered by the asunto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMensaje requireOneByIdusuario(string $idusuario) Return the first ChildMensaje filtered by the idusuario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMensaje[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMensaje objects based on current ModelCriteria
 * @method     ChildMensaje[]|ObjectCollection findByIdmensaje(int $idmensaje) Return ChildMensaje objects filtered by the idmensaje column
 * @method     ChildMensaje[]|ObjectCollection findByDescripcion(string $descripcion) Return ChildMensaje objects filtered by the descripcion column
 * @method     ChildMensaje[]|ObjectCollection findByAsunto(string $asunto) Return ChildMensaje objects filtered by the asunto column
 * @method     ChildMensaje[]|ObjectCollection findByIdusuario(string $idusuario) Return ChildMensaje objects filtered by the idusuario column
 * @method     ChildMensaje[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MensajeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MensajeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\Mensaje', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMensajeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMensajeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMensajeQuery) {
            return $criteria;
        }
        $query = new ChildMensajeQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMensaje|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MensajeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MensajeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMensaje A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idmensaje, descripcion, asunto, idusuario FROM mensaje WHERE idmensaje = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildMensaje $obj */
            $obj = new ChildMensaje();
            $obj->hydrate($row);
            MensajeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMensaje|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $keys, Criteria::IN);
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
     * @param     mixed $idmensaje The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByIdmensaje($idmensaje = null, $comparison = null)
    {
        if (is_array($idmensaje)) {
            $useMinMax = false;
            if (isset($idmensaje['min'])) {
                $this->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $idmensaje['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idmensaje['max'])) {
                $this->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $idmensaje['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $idmensaje, $comparison);
    }

    /**
     * Filter the query on the descripcion column
     *
     * Example usage:
     * <code>
     * $query->filterByDescripcion('fooValue');   // WHERE descripcion = 'fooValue'
     * $query->filterByDescripcion('%fooValue%'); // WHERE descripcion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descripcion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByDescripcion($descripcion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descripcion)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MensajeTableMap::COL_DESCRIPCION, $descripcion, $comparison);
    }

    /**
     * Filter the query on the asunto column
     *
     * Example usage:
     * <code>
     * $query->filterByAsunto('fooValue');   // WHERE asunto = 'fooValue'
     * $query->filterByAsunto('%fooValue%'); // WHERE asunto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $asunto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByAsunto($asunto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($asunto)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MensajeTableMap::COL_ASUNTO, $asunto, $comparison);
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
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByIdusuario($idusuario = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idusuario)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MensajeTableMap::COL_IDUSUARIO, $idusuario, $comparison);
    }

    /**
     * Filter the query by a related \Usuario object
     *
     * @param \Usuario|ObjectCollection $usuario The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = null)
    {
        if ($usuario instanceof \Usuario) {
            return $this
                ->addUsingAlias(MensajeTableMap::COL_IDUSUARIO, $usuario->getIdusuario(), $comparison);
        } elseif ($usuario instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MensajeTableMap::COL_IDUSUARIO, $usuario->toKeyValue('PrimaryKey', 'Idusuario'), $comparison);
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
     * @return $this|ChildMensajeQuery The current query, for fluid interface
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
     * Filter the query by a related \ViajeMensajes object
     *
     * @param \ViajeMensajes|ObjectCollection $viajeMensajes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByViajeMensajes($viajeMensajes, $comparison = null)
    {
        if ($viajeMensajes instanceof \ViajeMensajes) {
            return $this
                ->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $viajeMensajes->getIdmensaje(), $comparison);
        } elseif ($viajeMensajes instanceof ObjectCollection) {
            return $this
                ->useViajeMensajesQuery()
                ->filterByPrimaryKeys($viajeMensajes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByViajeMensajes() only accepts arguments of type \ViajeMensajes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ViajeMensajes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function joinViajeMensajes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ViajeMensajes');

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
            $this->addJoinObject($join, 'ViajeMensajes');
        }

        return $this;
    }

    /**
     * Use the ViajeMensajes relation ViajeMensajes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ViajeMensajesQuery A secondary query class using the current class as primary query
     */
    public function useViajeMensajesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinViajeMensajes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ViajeMensajes', '\ViajeMensajesQuery');
    }

    /**
     * Filter the query by a related \MensajeRespuesta object
     *
     * @param \MensajeRespuesta|ObjectCollection $mensajeRespuesta the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByMensajeRespuestaRelatedByIdmensaje($mensajeRespuesta, $comparison = null)
    {
        if ($mensajeRespuesta instanceof \MensajeRespuesta) {
            return $this
                ->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $mensajeRespuesta->getIdmensaje(), $comparison);
        } elseif ($mensajeRespuesta instanceof ObjectCollection) {
            return $this
                ->useMensajeRespuestaRelatedByIdmensajeQuery()
                ->filterByPrimaryKeys($mensajeRespuesta->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMensajeRespuestaRelatedByIdmensaje() only accepts arguments of type \MensajeRespuesta or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MensajeRespuestaRelatedByIdmensaje relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function joinMensajeRespuestaRelatedByIdmensaje($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MensajeRespuestaRelatedByIdmensaje');

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
            $this->addJoinObject($join, 'MensajeRespuestaRelatedByIdmensaje');
        }

        return $this;
    }

    /**
     * Use the MensajeRespuestaRelatedByIdmensaje relation MensajeRespuesta object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MensajeRespuestaQuery A secondary query class using the current class as primary query
     */
    public function useMensajeRespuestaRelatedByIdmensajeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMensajeRespuestaRelatedByIdmensaje($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MensajeRespuestaRelatedByIdmensaje', '\MensajeRespuestaQuery');
    }

    /**
     * Filter the query by a related \MensajeRespuesta object
     *
     * @param \MensajeRespuesta|ObjectCollection $mensajeRespuesta the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByMensajeRespuestaRelatedByIdrespuesta($mensajeRespuesta, $comparison = null)
    {
        if ($mensajeRespuesta instanceof \MensajeRespuesta) {
            return $this
                ->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $mensajeRespuesta->getIdrespuesta(), $comparison);
        } elseif ($mensajeRespuesta instanceof ObjectCollection) {
            return $this
                ->useMensajeRespuestaRelatedByIdrespuestaQuery()
                ->filterByPrimaryKeys($mensajeRespuesta->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMensajeRespuestaRelatedByIdrespuesta() only accepts arguments of type \MensajeRespuesta or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MensajeRespuestaRelatedByIdrespuesta relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function joinMensajeRespuestaRelatedByIdrespuesta($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MensajeRespuestaRelatedByIdrespuesta');

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
            $this->addJoinObject($join, 'MensajeRespuestaRelatedByIdrespuesta');
        }

        return $this;
    }

    /**
     * Use the MensajeRespuestaRelatedByIdrespuesta relation MensajeRespuesta object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MensajeRespuestaQuery A secondary query class using the current class as primary query
     */
    public function useMensajeRespuestaRelatedByIdrespuestaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMensajeRespuestaRelatedByIdrespuesta($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MensajeRespuestaRelatedByIdrespuesta', '\MensajeRespuestaQuery');
    }

    /**
     * Filter the query by a related Viaje object
     * using the viaje_mensajes table as cross reference
     *
     * @param Viaje $viaje the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByViaje($viaje, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useViajeMensajesQuery()
            ->filterByViaje($viaje, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Mensaje object
     * using the mensaje_respuesta table as cross reference
     *
     * @param Mensaje $mensaje the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByMensajeRelatedByIdrespuesta($mensaje, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useMensajeRespuestaRelatedByIdmensajeQuery()
            ->filterByMensajeRelatedByIdrespuesta($mensaje, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Mensaje object
     * using the mensaje_respuesta table as cross reference
     *
     * @param Mensaje $mensaje the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMensajeQuery The current query, for fluid interface
     */
    public function filterByMensajeRelatedByIdmensaje($mensaje, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useMensajeRespuestaRelatedByIdrespuestaQuery()
            ->filterByMensajeRelatedByIdmensaje($mensaje, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMensaje $mensaje Object to remove from the list of results
     *
     * @return $this|ChildMensajeQuery The current query, for fluid interface
     */
    public function prune($mensaje = null)
    {
        if ($mensaje) {
            $this->addUsingAlias(MensajeTableMap::COL_IDMENSAJE, $mensaje->getIdmensaje(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mensaje table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MensajeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MensajeTableMap::clearInstancePool();
            MensajeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MensajeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MensajeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            MensajeTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MensajeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MensajeQuery
