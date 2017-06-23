<?php

$servidor = getenv('ODK_SERVIDOR');
$database = getenv('ODK_DATABASE');
$user = getenv('ODK_USER');
$pass = getenv('ODK_PASS');

$link = pg_Connect("host=$servidor port=5432 dbname=$database user=$user password=$pass options='--client_encoding=UTF8'");
//if(isset($_REQUEST['id'])){
  //$numero_predial = intval($_REQUEST['id']);
$cadena_sql = <<<EOT
SELECT "CAPA_VEGETAL_LIST",
     "NUMERO_PREDIAL"
FROM odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL" AS ficha_predial
WHERE  "NUMERO_PREDIAL" IS NOT NULL  ORDER BY "CAPA_VEGETAL_LIST" ASC;

EOT;
$result = pg_exec($link, $cadena_sql);
$numrows = pg_numrows($result);

$condicionpredio = array();
for($ri = 0; $ri < $numrows; $ri++) {
  $row = pg_fetch_array($result, $ri);
  if (!isset($condicionpredio[$row["CAPA_VEGETAL_LIST"]])){
    $condicionpredio[$row["CAPA_VEGETAL_LIST"]]['nombre'] = $row["CAPA_VEGETAL_LIST"];
    $condicionpredio[$row["CAPA_VEGETAL_LIST"]]['alias'] = $row["CAPA_VEGETAL_LIST"];
    $condicionpredio[$row["CAPA_VEGETAL_LIST"]]['predios'] = array();
  }
  $condicionpredio[$row["CAPA_VEGETAL_LIST"]]['predios'][] = $row["NUMERO_PREDIAL"];
}
$condicionpredio_ordenadas = array();
foreach ($condicionpredio as $clave => $vegetal) {
  $condicionpredio_ordenadas[] = array(
    'nombre' => $vegetal['nombre'],
    'alias' => $vegetal['alias'],
    'predios' => $vegetal['predios']
  );
}

//var_dump($predios);

pg_close($link);

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
//header('Content-type: application/json; charset=utf-8');
//echo json_encode($predios);
echo json_encode($condicionpredio_ordenadas, JSON_PRETTY_PRINT);
//echo json_encode($predios, JSON_UNESCAPED_UNICODE);
