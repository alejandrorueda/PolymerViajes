<?php

namespace Base;

use \Viaje as ChildViaje;
use \ViajeQuery as ChildViajeQuery;
use \Exception;
use \PDO;
use Map\ViajeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'viaje' table.
 *
 * 
 *
 * @method     ChildViajeQuery orderByIdviaje($order = Criteria::ASC) Order by the idviaje column
 * @method     ChildViajeQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildViajeQuery orderByInformacion($order = Criteria::ASC) Order by the informacion column
 * @method     ChildViajeQuery orderByTransporte($order = Criteria::ASC) Order by the transporte column
 * @method     ChildViajeQuery orderByHospedaje($order = Criteria::ASC) Order by the hospedaje column
 * @method     ChildViajeQuery orderByDestino($order = Criteria::ASC) Order by the destino column
 * @method     ChildViajeQuery orderByFechaInicio($order = Criteria::ASC) Order by the fecha_inicio column
 * @method     ChildViajeQuery orderByFechaFinal($order = Criteria::ASC) Order by the fecha_final column
 * @method     ChildViajeQuery orderByPrecio($order = Criteria::ASC) Order by the precio column
 * @method     ChildViajeQuery orderByImagenes($order = Criteria::ASC) Order by the imagenes column
 * @method     ChildViajeQuery orderByEtiquetas($order = Criteria::ASC) Order by the etiquetas column
 *
 * @method     ChildViajeQuery groupByIdviaje() Group by the idviaje column
 * @method     ChildViajeQuery groupByNombre() Group by the nombre column
 * @method     ChildViajeQuery groupByInformacion() Group by the informacion column
 * @method     ChildViajeQuery groupByTransporte() Group by the transporte column
 * @method     ChildViajeQuery groupByHospedaje() Group by the hospedaje column
 * @method     ChildViajeQuery groupByDestino() Group by the destino column
 * @method     ChildViajeQuery groupByFechaInicio() Group by the fecha_inicio column
 * @method     ChildViajeQuery groupByFechaFinal() Group by the fecha_final column
 * @method     ChildViajeQuery groupByPrecio() Group by the precio column
 * @method     ChildViajeQuery groupByImagenes() Group by the imagenes column
 * @method     ChildViajeQuery groupByEtiquetas() Group by the etiquetas column
 *
 * @method     ChildViajeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildViajeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildViajeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildViajeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildViajeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildViajeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildViajeQuery leftJoinViajeMensajes($relationAlias = null) Adds a LEFT JOIN clause to the query using the ViajeMensajes relation
 * @method     ChildViajeQuery rightJoinViajeMensajes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ViajeMensajes relation
 * @method     ChildViajeQuery innerJoinViajeMensajes($relationAlias = null) Adds a INNER JOIN clause to the query using the ViajeMensajes relation
 *
 * @method     ChildViajeQuery joinWithViajeMensajes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ViajeMensajes relation
 *
 * @method     ChildViajeQuery leftJoinWithViajeMensajes() Adds a LEFT JOIN clause and with to the query using the ViajeMensajes relation
 * @method     ChildViajeQuery rightJoinWithViajeMensajes() Adds a RIGHT JOIN clause and with to the query using the ViajeMensajes relation
 * @method     ChildViajeQuery innerJoinWithViajeMensajes() Adds a INNER JOIN clause and with to the query using the ViajeMensajes relation
 *
 * @method     ChildViajeQuery leftJoinViajeUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the ViajeUsuario relation
 * @method     ChildViajeQuery rightJoinViajeUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ViajeUsuario relation
 * @method     ChildViajeQuery innerJoinViajeUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the ViajeUsuario relation
 *
 * @method     ChildViajeQuery joinWithViajeUsuario($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ViajeUsuario relation
 *
 * @method     ChildViajeQuery leftJoinWithViajeUsuario() Adds a LEFT JOIN clause and with to the query using the ViajeUsuario relation
 * @method     ChildViajeQuery rightJoinWithViajeUsuario() Adds a RIGHT JOIN clause and with to the query using the ViajeUsuario relation
 * @method     ChildViajeQuery innerJoinWithViajeUsuario() Adds a INNER JOIN clause and with to the query using the ViajeUsuario relation
 *
 * @method     ChildViajeQuery leftJoinGrupoViaje($relationAlias = null) Adds a LEFT JOIN clause to the query using the GrupoViaje relation
 * @method     ChildViajeQuery rightJoinGrupoViaje($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GrupoViaje relation
 * @method     ChildViajeQuery innerJoinGrupoViaje($relationAlias = null) Adds a INNER JOIN clause to the query using the GrupoViaje relation
 *
 * @method     ChildViajeQuery joinWithGrupoViaje($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GrupoViaje relation
 *
 * @method     ChildViajeQuery leftJoinWithGrupoViaje() Adds a LEFT JOIN clause and with to the query using the GrupoViaje relation
 * @method     ChildViajeQuery rightJoinWithGrupoViaje() Adds a RIGHT JOIN clause and with to the query using the GrupoViaje relation
 * @method     ChildViajeQuery innerJoinWithGrupoViaje() Adds a INNER JOIN clause and with to the query using the GrupoViaje relation
 *
 * @method     \ViajeMensajesQuery|\ViajeUsuarioQuery|\GrupoViajeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildViaje findOne(ConnectionInterface $con = null) Return the first ChildViaje matching the query
 * @method     ChildViaje findOneOrCreate(ConnectionInterface $con = null) Return the first ChildViaje matching the query, or a new ChildViaje object populated from the query conditions when no match is found
 *
 * @method     ChildViaje findOneByIdviaje(int $idviaje) Return the first ChildViaje filtered by the idviaje column
 * @method     ChildViaje findOneByNombre(string $nombre) Return the first ChildViaje filtered by the nombre column
 * @method     ChildViaje findOneByInformacion(string $informacion) Return the first ChildViaje filtered by the informacion column
 * @method     ChildViaje findOneByTransporte(string $transporte) Return the first ChildViaje filtered by the transporte column
 * @method     ChildViaje findOneByHospedaje(string $hospedaje) Return the first ChildViaje filtered by the hospedaje column
 * @method     ChildViaje findOneByDestino(string $destino) Return the first ChildViaje filtered by the destino column
 * @method     ChildViaje findOneByFechaInicio(string $fecha_inicio) Return the first ChildViaje filtered by the fecha_inicio column
 * @method     ChildViaje findOneByFechaFinal(string $fecha_final) Return the first ChildViaje filtered by the fecha_final column
 * @method     ChildViaje findOneByPrecio(double $precio) Return the first ChildViaje filtered by the precio column
 * @method     ChildViaje findOneByImagenes(array $imagenes) Return the first ChildViaje filtered by the imagenes column
 * @method     ChildViaje findOneByEtiquetas(array $etiquetas) Return the first ChildViaje filtered by the etiquetas column *

 * @method     ChildViaje requirePk($key, ConnectionInterface $con = null) Return the ChildViaje by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOne(ConnectionInterface $con = null) Return the first ChildViaje matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildViaje requireOneByIdviaje(int $idviaje) Return the first ChildViaje filtered by the idviaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByNombre(string $nombre) Return the first ChildViaje filtered by the nombre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByInformacion(string $informacion) Return the first ChildViaje filtered by the informacion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByTransporte(string $transporte) Return the first ChildViaje filtered by the transporte column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByHospedaje(string $hospedaje) Return the first ChildViaje filtered by the hospedaje column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByDestino(string $destino) Return the first ChildViaje filtered by the destino column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByFechaInicio(string $fecha_inicio) Return the first ChildViaje filtered by the fecha_inicio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByFechaFinal(string $fecha_final) Return the first ChildViaje filtered by the fecha_final column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByPrecio(double $precio) Return the first ChildViaje filtered by the precio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByImagenes(array $imagenes) Return the first ChildViaje filtered by the imagenes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildViaje requireOneByEtiquetas(array $etiquetas) Return the first ChildViaje filtered by the etiquetas column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildViaje[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildViaje objects based on current ModelCriteria
 * @method     ChildViaje[]|ObjectCollection findByIdviaje(int $idviaje) Return ChildViaje objects filtered by the idviaje column
 * @method     ChildViaje[]|ObjectCollection findByNombre(string $nombre) Return ChildViaje objects filtered by the nombre column
 * @method     ChildViaje[]|ObjectCollection findByInformacion(string $informacion) Return ChildViaje objects filtered by the informacion column
 * @method     ChildViaje[]|ObjectCollection findByTransporte(string $transporte) Return ChildViaje objects filtered by the transporte column
 * @method     ChildViaje[]|ObjectCollection findByHospedaje(string $hospedaje) Return ChildViaje objects filtered by the hospedaje column
 * @method     ChildViaje[]|ObjectCollection findByDestino(string $destino) Return ChildViaje objects filtered by the destino column
 * @method     ChildViaje[]|ObjectCollection findByFechaInicio(string $fecha_inicio) Return ChildViaje objects filtered by the fecha_inicio column
 * @method     ChildViaje[]|ObjectCollection findByFechaFinal(string $fecha_final) Return ChildViaje objects filtered by the fecha_final column
 * @method     ChildViaje[]|ObjectCollection findByPrecio(double $precio) Return ChildViaje objects filtered by the precio column
 * @method     ChildViaje[]|ObjectCollection findByImagenes(array $imagenes) Return ChildViaje objects filtered by the imagenes column
 * @method     ChildViaje[]|ObjectCollection findByEtiquetas(array $etiquetas) Return ChildViaje objects filtered by the etiquetas column
 * @method     ChildViaje[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ViajeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ViajeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'viajes', $modelName = '\\Viaje', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildViajeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildViajeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildViajeQuery) {
            return $criteria;
        }
        $query = new ChildViajeQuery();
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
     * @return ChildViaje|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ViajeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ViajeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildViaje A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idviaje, nombre, informacion, transporte, hospedaje, destino, fecha_inicio, fecha_final, precio, imagenes, etiquetas FROM viaje WHERE idviaje = :p0';
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
            /** @var ChildViaje $obj */
            $obj = new ChildViaje();
            $obj->hydrate($row);
            ViajeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildViaje|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $keys, Criteria::IN);
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
     * @param     mixed $idviaje The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByIdviaje($idviaje = null, $comparison = null)
    {
        if (is_array($idviaje)) {
            $useMinMax = false;
            if (isset($idviaje['min'])) {
                $this->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $idviaje['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idviaje['max'])) {
                $this->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $idviaje['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $idviaje, $comparison);
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
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByNombre($nombre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombre)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_NOMBRE, $nombre, $comparison);
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
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByInformacion($informacion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($informacion)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_INFORMACION, $informacion, $comparison);
    }

    /**
     * Filter the query on the transporte column
     *
     * Example usage:
     * <code>
     * $query->filterByTransporte('fooValue');   // WHERE transporte = 'fooValue'
     * $query->filterByTransporte('%fooValue%'); // WHERE transporte LIKE '%fooValue%'
     * </code>
     *
     * @param     string $transporte The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByTransporte($transporte = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($transporte)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_TRANSPORTE, $transporte, $comparison);
    }

    /**
     * Filter the query on the hospedaje column
     *
     * Example usage:
     * <code>
     * $query->filterByHospedaje('fooValue');   // WHERE hospedaje = 'fooValue'
     * $query->filterByHospedaje('%fooValue%'); // WHERE hospedaje LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hospedaje The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByHospedaje($hospedaje = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hospedaje)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_HOSPEDAJE, $hospedaje, $comparison);
    }

    /**
     * Filter the query on the destino column
     *
     * Example usage:
     * <code>
     * $query->filterByDestino('fooValue');   // WHERE destino = 'fooValue'
     * $query->filterByDestino('%fooValue%'); // WHERE destino LIKE '%fooValue%'
     * </code>
     *
     * @param     string $destino The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByDestino($destino = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($destino)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_DESTINO, $destino, $comparison);
    }

    /**
     * Filter the query on the fecha_inicio column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaInicio('2011-03-14'); // WHERE fecha_inicio = '2011-03-14'
     * $query->filterByFechaInicio('now'); // WHERE fecha_inicio = '2011-03-14'
     * $query->filterByFechaInicio(array('max' => 'yesterday')); // WHERE fecha_inicio > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaInicio The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByFechaInicio($fechaInicio = null, $comparison = null)
    {
        if (is_array($fechaInicio)) {
            $useMinMax = false;
            if (isset($fechaInicio['min'])) {
                $this->addUsingAlias(ViajeTableMap::COL_FECHA_INICIO, $fechaInicio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaInicio['max'])) {
                $this->addUsingAlias(ViajeTableMap::COL_FECHA_INICIO, $fechaInicio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_FECHA_INICIO, $fechaInicio, $comparison);
    }

    /**
     * Filter the query on the fecha_final column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaFinal('2011-03-14'); // WHERE fecha_final = '2011-03-14'
     * $query->filterByFechaFinal('now'); // WHERE fecha_final = '2011-03-14'
     * $query->filterByFechaFinal(array('max' => 'yesterday')); // WHERE fecha_final > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaFinal The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByFechaFinal($fechaFinal = null, $comparison = null)
    {
        if (is_array($fechaFinal)) {
            $useMinMax = false;
            if (isset($fechaFinal['min'])) {
                $this->addUsingAlias(ViajeTableMap::COL_FECHA_FINAL, $fechaFinal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaFinal['max'])) {
                $this->addUsingAlias(ViajeTableMap::COL_FECHA_FINAL, $fechaFinal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_FECHA_FINAL, $fechaFinal, $comparison);
    }

    /**
     * Filter the query on the precio column
     *
     * Example usage:
     * <code>
     * $query->filterByPrecio(1234); // WHERE precio = 1234
     * $query->filterByPrecio(array(12, 34)); // WHERE precio IN (12, 34)
     * $query->filterByPrecio(array('min' => 12)); // WHERE precio > 12
     * </code>
     *
     * @param     mixed $precio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByPrecio($precio = null, $comparison = null)
    {
        if (is_array($precio)) {
            $useMinMax = false;
            if (isset($precio['min'])) {
                $this->addUsingAlias(ViajeTableMap::COL_PRECIO, $precio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($precio['max'])) {
                $this->addUsingAlias(ViajeTableMap::COL_PRECIO, $precio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ViajeTableMap::COL_PRECIO, $precio, $comparison);
    }

    /**
     * Filter the query on the imagenes column
     *
     * @param     array $imagenes The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByImagenes($imagenes = null, $comparison = null)
    {
        $key = $this->getAliasedColName(ViajeTableMap::COL_IMAGENES);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($imagenes as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($imagenes as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($imagenes as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ViajeTableMap::COL_IMAGENES, $imagenes, $comparison);
    }

    /**
     * Filter the query on the imagenes column
     * @param     mixed $imagenes The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByImagene($imagenes = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($imagenes)) {
                $imagenes = '%| ' . $imagenes . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $imagenes = '%| ' . $imagenes . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(ViajeTableMap::COL_IMAGENES);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $imagenes, $comparison);
            } else {
                $this->addAnd($key, $imagenes, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ViajeTableMap::COL_IMAGENES, $imagenes, $comparison);
    }

    /**
     * Filter the query on the etiquetas column
     *
     * @param     array $etiquetas The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByEtiquetas($etiquetas = null, $comparison = null)
    {
        $key = $this->getAliasedColName(ViajeTableMap::COL_ETIQUETAS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($etiquetas as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($etiquetas as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($etiquetas as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ViajeTableMap::COL_ETIQUETAS, $etiquetas, $comparison);
    }

    /**
     * Filter the query on the etiquetas column
     * @param     mixed $etiquetas The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function filterByEtiqueta($etiquetas = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($etiquetas)) {
                $etiquetas = '%| ' . $etiquetas . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $etiquetas = '%| ' . $etiquetas . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(ViajeTableMap::COL_ETIQUETAS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $etiquetas, $comparison);
            } else {
                $this->addAnd($key, $etiquetas, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ViajeTableMap::COL_ETIQUETAS, $etiquetas, $comparison);
    }

    /**
     * Filter the query by a related \ViajeMensajes object
     *
     * @param \ViajeMensajes|ObjectCollection $viajeMensajes the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildViajeQuery The current query, for fluid interface
     */
    public function filterByViajeMensajes($viajeMensajes, $comparison = null)
    {
        if ($viajeMensajes instanceof \ViajeMensajes) {
            return $this
                ->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $viajeMensajes->getIdviaje(), $comparison);
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
     * @return $this|ChildViajeQuery The current query, for fluid interface
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
     * Filter the query by a related \ViajeUsuario object
     *
     * @param \ViajeUsuario|ObjectCollection $viajeUsuario the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildViajeQuery The current query, for fluid interface
     */
    public function filterByViajeUsuario($viajeUsuario, $comparison = null)
    {
        if ($viajeUsuario instanceof \ViajeUsuario) {
            return $this
                ->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $viajeUsuario->getIdviaje(), $comparison);
        } elseif ($viajeUsuario instanceof ObjectCollection) {
            return $this
                ->useViajeUsuarioQuery()
                ->filterByPrimaryKeys($viajeUsuario->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByViajeUsuario() only accepts arguments of type \ViajeUsuario or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ViajeUsuario relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function joinViajeUsuario($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ViajeUsuario');

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
            $this->addJoinObject($join, 'ViajeUsuario');
        }

        return $this;
    }

    /**
     * Use the ViajeUsuario relation ViajeUsuario object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ViajeUsuarioQuery A secondary query class using the current class as primary query
     */
    public function useViajeUsuarioQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinViajeUsuario($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ViajeUsuario', '\ViajeUsuarioQuery');
    }

    /**
     * Filter the query by a related \GrupoViaje object
     *
     * @param \GrupoViaje|ObjectCollection $grupoViaje the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildViajeQuery The current query, for fluid interface
     */
    public function filterByGrupoViaje($grupoViaje, $comparison = null)
    {
        if ($grupoViaje instanceof \GrupoViaje) {
            return $this
                ->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $grupoViaje->getIdviaje(), $comparison);
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
     * @return $this|ChildViajeQuery The current query, for fluid interface
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
     * Filter the query by a related Mensaje object
     * using the viaje_mensajes table as cross reference
     *
     * @param Mensaje $mensaje the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildViajeQuery The current query, for fluid interface
     */
    public function filterByMensaje($mensaje, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useViajeMensajesQuery()
            ->filterByMensaje($mensaje, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Usuario object
     * using the viaje_usuario table as cross reference
     *
     * @param Usuario $usuario the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildViajeQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useViajeUsuarioQuery()
            ->filterByUsuario($usuario, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Grupo object
     * using the grupo_viaje table as cross reference
     *
     * @param Grupo $grupo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildViajeQuery The current query, for fluid interface
     */
    public function filterByGrupo($grupo, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useGrupoViajeQuery()
            ->filterByGrupo($grupo, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildViaje $viaje Object to remove from the list of results
     *
     * @return $this|ChildViajeQuery The current query, for fluid interface
     */
    public function prune($viaje = null)
    {
        if ($viaje) {
            $this->addUsingAlias(ViajeTableMap::COL_IDVIAJE, $viaje->getIdviaje(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the viaje table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ViajeTableMap::clearInstancePool();
            ViajeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ViajeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ViajeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ViajeTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ViajeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ViajeQuery
