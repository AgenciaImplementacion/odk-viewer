<?php

$servidor = getenv('ODK_SERVIDOR');
$database = getenv('ODK_DATABASE');
$user = getenv('ODK_USER');
$pass = getenv('ODK_PASS');

$link = pg_Connect("host=$servidor port=5432 dbname=$database user=$user password=$pass options='--client_encoding=UTF8'");
//if(isset($_REQUEST['id'])){
  //$numero_predial = intval($_REQUEST['id']);
$cadena_sql = <<<EOT
  SELECT "ACTIVIDAD_ECONOMICA",
         "NUMERO_PREDIAL",

    (SELECT display_text
     FROM public.dominios
     WHERE tabla ='ficha_predial'
       AND choice_list_name = 'actividad_economica'
       AND data_value = ficha_predial."ACTIVIDAD_ECONOMICA") AS actividad_economica
  FROM odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL" AS ficha_predial
  WHERE "NUMERO_PREDIAL" IS NOT NULL
  ORDER BY "ACTIVIDAD_ECONOMICA" ASC;
EOT;
//'SELECT * from odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL" WHERE "NUMERO_PREDIAL" = \'' . $numero_predial . '\';';
//} else {
//echo "no sirver";  //$cadena_sql = 'SELECT * from odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL";';
//}
$result = pg_exec($link, $cadena_sql);
$numrows = pg_numrows($result);

$actividades = array();
for($ri = 0; $ri < $numrows; $ri++) {
  $row = pg_fetch_array($result, $ri);
  if (!isset($actividades[$row["ACTIVIDAD_ECONOMICA"]])){
    $actividades[$row["ACTIVIDAD_ECONOMICA"]]['nombre'] = $row["ACTIVIDAD_ECONOMICA"];
    $actividades[$row["ACTIVIDAD_ECONOMICA"]]['alias'] = $row["actividad_economica"];
    $actividades[$row["ACTIVIDAD_ECONOMICA"]]['predios'] = array();
  }
  $actividades[$row["ACTIVIDAD_ECONOMICA"]]['predios'][] = $row["NUMERO_PREDIAL"];
}

$actividades_ordenadas = array();
foreach ($actividades as $clave => $actividad) {
  $actividades_ordenadas[] = array(
    'nombre' => $actividad['nombre'],
    'alias' => $actividad['alias'],
    'predios' => $actividad['predios']
  );
}


//var_dump($predios);

pg_close($link);

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
//header('Content-type: application/json; charset=utf-8');
//echo json_encode($predios);
echo json_encode($actividades_ordenadas, JSON_PRETTY_PRINT);
//echo json_encode($predios, JSON_UNESCAPED_UNICODE);
