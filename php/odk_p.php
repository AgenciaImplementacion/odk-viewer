<?php

$servidor = getenv('ODK_SERVIDOR');
$database = getenv('ODK_DATABASE');
$user = getenv('ODK_USER');
$pass = getenv('ODK_PASS');

$link = pg_Connect("host=$servidor port=5432 dbname=$database user=$user password=$pass options='--client_encoding=UTF8'");
if(isset($_REQUEST['id'])){
  $numero_predial = intval($_REQUEST['id']);
  $cadena_sql = 'SELECT * from odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL" WHERE "NUMERO_PREDIAL" = \'' . $numero_predial . '\';';
} else {
  $cadena_sql = 'SELECT * from odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL";';
}
$result = pg_exec($link, $cadena_sql);
$numrows = pg_numrows($result);

$predios = array();

for($ri = 0; $ri < $numrows; $ri++) {
  $row = pg_fetch_array($result, $ri);
  $predios[$ri] = array(
    'Número' => $row["NUMERO_PREDIAL"],
    'Dirección' => $row["DIRECCION_PREDIO"],
    'Número predial viejo' => $row["NUMERO_PREDIAL_VIEJO"],
    'Clase predio' => $row["CLASEPREDIO"],
    'Clase suelo' => $row["CLASE_SUELO"],
    'Condición del predio' => $row["CONDICION_PREDIO"],
    'Comuna' => $row["COMUNA"],
    'Departamento' => $row["DEPARTAMENTO"],
    'Derecho del predio' => $row["DERECHO_PREDIO"],
    'Disponibilidad de la oferta' => $row["DISPONIBLEOFERTA"],
    'Estrato socio económico' => $row["ESTRATO_SOCIECON"],
    'Municipio' => $row["MUNICIPIO"],
    'Obra infraestructura interior lista' => $row["OBRA_INFRA_INTERIOR_LIST"],
    'Observaciones' => $row["OBSERVACIONES"],
    'Opcion de predio' => $row["OPCIONPREDIOPR"],
    'Territorios Agricolas' => $row["TERRITORIOS_AGRICOLAS"],
    'Tipo derecho' => $row["TIPO_DERECHO"],
    'Tipo documento' => $row["TIPO_DOCUMENTO"],
    'Tipo fuente de agua lista' => $row["TIPO_FUENTE_AGUA_LIST"],
    'Tipo de persona' => $row["TIPO_PERSONA"],
    'Tipo de predio' => $row["TIPO_PREDIO"],
    'Titular del predio' => $row["TITULAR_DERECHO"]
  );

  // foreach ($predios[$ri] as $key => $value) {
  //   $predios[$ri][$key] = utf8_encode($value);
  //   //$predios[$ri][$key] = json_decode($value, false, 512, JSON_UNESCAPED_UNICODE);
  // }
}

//var_dump($predios);

pg_close($link);

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
//header('Content-type: application/json; charset=utf-8');
echo json_encode($predios);
//echo json_encode($predios, JSON_PRETTY_PRINT);
//echo json_encode($predios, JSON_UNESCAPED_UNICODE);
