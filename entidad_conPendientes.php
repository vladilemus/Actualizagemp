<?php
session_start();
include_once("../configuracion_sistema/configuracion.php");
include_once("../librerias/PDOConsultas.php");
global $NOMBRE_CARPETA_PRINCIPAL;

$datos_query = new PDOConsultas();
$datos_query->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

// Número de registros por página
$registros_por_pagina = 12;

// Obtener la página actual desde la URL, si no se establece, se utiliza la página 1
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcular el desplazamiento
$offset = ($pagina_actual - 1) * $registros_por_pagina;
//PROCESO DE OBTENER LOS VALORES DEL FORMULARIO DE BÚSQUEDA
$buscarPor = isset($_POST['buscar']) ? $_POST['buscar'] : (isset($_GET['buscar']) ? $_GET['buscar'] : '');
$valor = isset($_POST['valor']) ? $_POST['valor'] : (isset($_GET['valor']) ? $_GET['valor'] : '');
$anio = isset($_POST['año']) ? $_POST['año'] : (isset($_GET['año']) ? $_GET['año'] : '');

if (!empty($buscarPor) && !empty($valor) && !empty($anio)){
    if ($buscarPor == "folio"){
        $consulta2 = "
        SELECT 
            p.PFolio AS Folio,
            p.PFecha AS \"Fecha de Registro\",
            u.ClaveServidor AS \"Clave de Servidor Publico\",
            CONCAT(u.nom_usuario, ' ', u.ApePat, ' ', u.ApeMat) AS \"Nombre del Servidor Publico\",
            u.FechaIngIss AS \"Fecha de Ingreso\",
            (CONCAT(u.antia, ' años ', u.antim, ' meses ', u.antid, ' días')) AS antiguedad,
            e.EDescripcion AS Estatus
        FROM peticiones p
            LEFT JOIN sb_usuario u ON p.PCveUsufk = u.cve_usuario
            LEFT  JOIN estatus e ON p.PCveEfk = e.ECveE
            LEFT JOIN cat_puesto c ON u.CvePF = c.PCveP
        WHERE 
            u.cve_perfil = 4    
            AND p.PFolio = '$valor' 
            AND p.PFecha >= '$anio-01-01'
            AND u.ClaveServidor NOT IN (SELECT ClaveServidor FROM dt_constancias WHERE TDCveTD = 5)
        AND (
            (p.PCveEfk = 2 AND p.PPaso = 1)
            OR (p.PCveEfk = 3 AND p.PPaso = 1)
            OR p.checkConstancia = 'true'
        )
        ORDER BY 
            CASE WHEN p.PCveURfk = 1 THEN 1 ELSE 0 END, 
            p.PFolio ASC, 
            p.PCveURfk DESC
            LIMIT $registros_por_pagina OFFSET $offset
        ";
    } elseif ($buscarPor == 'nombre'){
        $consulta2 = "
        SELECT 
	    p.PFolio AS Folio,
	    p.PFecha AS \"Fecha de Registro\",
	    u.ClaveServidor AS \"Clave de Servidor Publico\",
        CONCAT(u.nom_usuario, ' ', u.ApePat, ' ', u.ApeMat) AS \"Nombre del Servidor Publico\",
        u.FechaIngIss AS \"Fecha de Ingreso\",
        (CONCAT(u.antia, ' años' , u.antim, 'meses ', u.antid, ' días')) AS antiguedad,
        e.EDescripcion AS Estatus
        FROM peticiones p
            LEFT JOIN sb_usuario u ON p.PCveUsufk = u.cve_usuario
            LEFT  JOIN estatus e ON p.PCveEfk = e.ECveE
            LEFT JOIN cat_puesto c ON u.CvePF = c.PCveP
        WHERE 
            u.cve_perfil = 4  AND   CONCAT(TRIM(u.nom_usuario), ' ', TRIM(u.ApePat), ' ', TRIM(u.ApeMat)) = '$valor' 
            AND p.PFecha >= '$anio-01-01'
            AND u.ClaveServidor NOT IN (SELECT ClaveServidor FROM dt_constancias WHERE TDCveTD = 5)
            AND (
                (p.PCveEfk = 2 AND p.PPaso = 1)
                OR (p.PCveEfk = 3 AND p.PPaso = 1)
                OR p.checkConstancia = 'true'
            )
        ORDER BY 
            CASE WHEN p.PCveURfk = 1 THEN 1 ELSE 0 END, 
            p.PFolio ASC, 
            p.PCveURfk DESC
            LIMIT $registros_por_pagina OFFSET $offset
        ";
        
    }elseif ($buscarPor == 'clave'){
        $consulta2 = "
        SELECT 
	    p.PFolio AS Folio,
	    p.PFecha AS \"Fecha de Registro\",
	    u.ClaveServidor AS \"Clave de Servidor Publico\",
        CONCAT(u.nom_usuario, ' ', u.ApePat, ' ', u.ApeMat) AS \"Nombre del Servidor Publico\",
        u.FechaIngIss AS \"Fecha de Ingreso\",
        (CONCAT(u.antia, ' años' , u.antim, 'meses ', u.antid, ' días')) AS antiguedad,
        e.EDescripcion AS Estatus
        FROM peticiones p
            LEFT JOIN sb_usuario u ON p.PCveUsufk = u.cve_usuario
            LEFT  JOIN estatus e ON p.PCveEfk = e.ECveE
            LEFT JOIN cat_puesto c ON u.CvePF = c.PCveP
        WHERE 
            u.cve_perfil = 4   AND u.ClaveServidor = '$valor'
            AND p.PFecha >= '$anio-01-01'
            AND u.ClaveServidor NOT IN (SELECT ClaveServidor FROM dt_constancias WHERE TDCveTD = 5)
            AND (
                (p.PCveEfk = 2 AND p.PPaso = 1)
                OR (p.PCveEfk = 3 AND p.PPaso = 1)
                OR p.checkConstancia = 'true'
            )
        ORDER BY 
            CASE WHEN p.PCveURfk = 1 THEN 1 ELSE 0 END, 
            p.PFolio ASC, 
            p.PCveURfk DESC
            LIMIT $registros_por_pagina OFFSET $offset
        ";
    } elseif ($anio == '2023'){
        $consulta_total = "
        SELECT COUNT(*) AS total
        FROM peticiones p 
        INNER JOIN sb_usuario u ON p.PCveUsufk = u.cve_usuario
        INNER JOIN estatus e ON p.PCveEfk = e.ECveE
        ";
        $total_resultado = $datos_query->executeQuery($consulta_total);
        $total_registros = $total_resultado[0]['total'];
        $consulta2 = "
        SELECT 
            p.PFolio AS Folio,
            p.PFecha AS \"Fecha de Registro\",
            u.ClaveServidor AS \"Clave de Servidor Publico\",
            CONCAT(u.nom_usuario, ' ', u.ApePat, ' ', u.ApeMat) AS \"Nombre del Servidor Publico\",
             u.FechaIngIss AS \"Fecha de Ingreso\",
            (CONCAT(u.antia, ' años ', u.antim, ' meses ', u.antid, ' días')) AS antiguedad,
           e.EDescripcion AS Estatus
        FROM peticiones p
        LEFT JOIN sb_usuario u ON p.PCveUsufk = u.cve_usuario
        LEFT  JOIN estatus e ON p.PCveEfk = e.ECveE
        LEFT JOIN cat_puesto c ON u.CvePF = c.PCveP
        WHERE 
        PFecha >= '$anio-01-1' 
        AND u.cve_perfil = 4
        AND u.ClaveServidor NOT IN (SELECT ClaveServidor FROM dt_constancias WHERE TDCveTD = 5)
        AND (
            (p.PCveEfk = 2 AND p.PPaso = 1)
            OR (p.PCveEfk = 3 AND p.PPaso = 1)
            OR p.checkConstancia = 'true'
        )
        ORDER BY 
            CASE WHEN p.PCveURfk = 1 THEN 1 ELSE 0 END, 
            p.PFolio ASC, 
            p.PCveURfk DESC
            LIMIT $registros_por_pagina OFFSET $offset
        ";
    }
    $total_paginas = ceil($total_registros / $registros_por_pagina);
    $paginas_visibles = 5;
    $start_page = max(1, $pagina_actual - floor($paginas_visibles / 2));
    $end_page = min($total_paginas, $pagina_actual + floor($paginas_visibles / 2));

    if($end_page - $start_page < $paginas_visibles -1 ){
        $start_page = max(1, $end_page - $paginas_visibles +1);
    }

    $resultado = $datos_query->executeQuery($consulta2);

} else  {
    // Consulta por defecto cuando no hay filtro de búsqueda
    $consulta_total = "
    SELECT COUNT(*) AS total
    FROM peticiones p 
    INNER JOIN sb_usuario u ON p.PCveUsufk = u.cve_usuario
    INNER JOIN estatus e ON p.PCveEfk = e.ECveE
    ";
    $total_resultado = $datos_query->executeQuery($consulta_total);
    $total_registros = $total_resultado[0]['total'];
    $consulta2 = "
    SELECT 
	    p.PFolio AS Folio,
	    p.PFecha AS \"Fecha de Registro\",
	    u.ClaveServidor AS \"Clave de Servidor Publico\",
	    CONCAT(u.nom_usuario, ' ', u.ApePat, ' ', u.ApeMat) AS \"Nombre del Servidor Publico\",
	     u.FechaIngIss AS \"Fecha de Ingreso\",
	    (CONCAT(u.antia, ' años ', u.antim, ' meses ', u.antid, ' días')) AS antiguedad,
       e.EDescripcion AS Estatus
    FROM peticiones p
    LEFT JOIN sb_usuario u ON p.PCveUsufk = u.cve_usuario
    LEFT  JOIN estatus e ON p.PCveEfk = e.ECveE
    LEFT JOIN cat_puesto c ON u.CvePF = c.PCveP
    WHERE 
    PFecha >= '2024-01-1' 
    AND u.cve_perfil = 4
    AND u.ClaveServidor NOT IN (SELECT ClaveServidor FROM dt_constancias WHERE TDCveTD = 5)
    AND (
        (p.PCveEfk = 2 AND p.PPaso = 1)
        OR (p.PCveEfk = 3 AND p.PPaso = 1)
        OR p.checkConstancia = 'true'
    )
    ORDER BY 
        CASE WHEN p.PCveURfk = 1 THEN 1 ELSE 0 END, 
        p.PFolio ASC, 
        p.PCveURfk DESC
        LIMIT $registros_por_pagina OFFSET $offset
    ";
    $total_paginas = ceil($total_registros / $registros_por_pagina);

    $paginas_visibles = 5;
    $start_page = max(1, $pagina_actual - floor($paginas_visibles / 2));
    $end_page = min($total_paginas, $pagina_actual + floor($paginas_visibles / 2));

    if ($end_page - $start_page < $paginas_visibles - 1) {
        $start_page = max(1, $end_page - $paginas_visibles + 1);
    }
    $resultado = $datos_query->executeQuery($consulta2);
}
?>

<style>
    .custom-select,
    .custom-input,
    .custom-select-year,
    .custom-button {
        width: 200px; /* Ancho uniforme */
        margin-right: 10px; /* Espacio entre elementos */
    }

    .search-container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 20px; /* Espacio arriba */
        margin-left: 20px; /* Espacio a la izquierda */
        margin-bottom: 20px; /* Espacio debajo de los inputs */
    }
</style>

<section class="historial_registro">
    <div class="row">
        <div class="card">
            <!--- ZONA DE LOS INPUT PARA BUSCAR --->
            <form action="" method="post">
                <div class="row align-items-center search-container">
                    <select class="form-control form-control-sm custom-select" title="SELECCIONE" id="buscar" name="buscar" >
                        <option value="">-BUSCAR POR-</option> 
                        <option value="folio">Folio de Peticion</option>
                        <option value="nombre">Nombre De Servidor Publico</option>
                        <option value="clave">Clave Del Servidor Publico</option>
                        <option value="prueba">Año</option>
                    </select>
                        <input type="text" class="form-control form-control-sm custom-input" id="valor" name="valor" 
                        aria-describedby="defaultFormControlHelp" placeholder="Ingrese su búsqueda aquí" />
                    <select class="form-control form-control-sm custom-select-year" title="año" name="año" id="año" required>
                        <option value="">-SELECCIONE UN AÑO-</option>
                        <option value="2023">-AÑO 2023-</option>
                        <option value="2024">-AÑO 2024-</option>
                    </select>
                    <input type="submit" class="btn btn-primary btn-block custom-button" id="buscar_btn" name="buscar_btn" value="Buscar">            
                </div>
            </form>
            <!--FIN DE LA ZONA DE LOS INPUT--->
            <!-- AREA DE LA TABLA -->
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <!-- ENCABEZADO DE LA TABLA -->
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha registros</th>
                            <th>Clave de Servidor Publico</th>
                            <th>Nombre</th>
                            <th>Fecha de Ingreso</th>
                            <th>Antiguedad</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <!-- CUERPO DE LA TABLA -->
                    <tbody class="table-border-bottom-0">
                        <?php if (!empty($resultado)): ?>
                            <?php foreach ($resultado as $fila): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fila['Folio']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['Fecha de Registro']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['Clave de Servidor Publico']);?></td>
                                    <td><?php echo htmlspecialchars($fila['Nombre del Servidor Publico']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['Fecha de Ingreso']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['antiguedad']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['Estatus']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No se encontraron resultados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            <nav>
                <ul class="pagination">
                    <!-- Enlace a la página anterior -->
                    <?php if ($pagina_actual > 1): ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_actual - 1 . "&buscar=" . urlencode($buscarPor) . "&valor=" . urlencode($valor) . "&año=" . urlencode($anio); ?>">Anterior</a></li>
                    <?php endif; ?>

                    <!-- Enlaces a las páginas visibles -->
                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i . "&buscar=" . urlencode($buscarPor) . "&valor=" . urlencode($valor) . "&año=" . urlencode($anio); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Enlace a la página siguiente -->
                    <?php if ($pagina_actual < $total_paginas): ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_actual + 1 . "&buscar=" . urlencode($buscarPor) . "&valor=" . urlencode($valor) . "&año=" . urlencode($anio); ?>">Siguiente</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>