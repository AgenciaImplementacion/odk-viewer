<?php

$servidor = getenv('ODK_SERVIDOR');
$database = getenv('ODK_DATABASE');
$user = getenv('ODK_USER');
$pass = getenv('ODK_PASS');

$link = pg_Connect("host=$servidor port=5432 dbname=$database user=$user password=$pass options='--client_encoding=UTF8'");
//if(isset($_REQUEST['id'])){
  //$numero_predial = intval($_REQUEST['id']);
$cadena_sql = <<<EOT
SELECT (SELECT
         CASE
           WHEN pn."CODIGO_FICHA" IS NULL THEN pd."CODIGO_FICHA"
           ELSE pn."CODIGO_FICHA"
         END)
       AS cod_predial,
       (SELECT
         CASE
           WHEN pn."SEXO_PERSONA" IS NULL THEN pd."SEXO_PERSONA"
           ELSE pn."SEXO_PERSONA"
         END)
       AS sexo
FROM odk_prod."__ODKTABLES__TABLE_PERSONAN_PREDIO" AS pn
FULL OUTER JOIN odk_prod."__ODKTABLES__TABLE_PERSONAN_DOCUMENTO" AS pd
  ON pn."CODIGO_FICHA" = pd."CODIGO_FICHA"
EOT;
//'SELECT * from odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL" WHERE "NUMERO_PREDIAL" = \'' . $numero_predial . '\';';
//} else {
//echo "no sirver";  //$cadena_sql = 'SELECT * from odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL";';
//}
$result = pg_exec($link, $cadena_sql);
$numrows = pg_numrows($result);

$sexo = array();
for($ri = 0; $ri < $numrows; $ri++) {
  $row = pg_fetch_array($result, $ri);
  if (!isset($sexo[$row["sexo"]])){
    $sexo[$row["sexo"]]['nombre'] = $row["sexo"];
    $sexo[$row["sexo"]]['alias'] = $row["sexo"];
    $sexo[$row["sexo"]]['predio'] = array();
  }
  $sexo[$row["sexo"]]['predios'][] = $row["cod_predial"];
}

$sexo_ordenadas = array();
foreach ($sexo as $clave => $sex) {
  $sexo_ordenadas[] = array(
    'nombre' => $sex['nombre'],
    'alias' => $sex['alias'],
    'predios' => $sex['predios']
  );
}


//var_dump($predios);

pg_close($link);

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
//header('Content-type: application/json; charset=utf-8');
//echo json_encode($predios);
echo json_encode($sexo_ordenadas, JSON_PRETTY_PRINT);
//echo json_encode($predios, JSON_UNESCAPED_UNICODE);
