<?php
if (!preg_match('/^([[:digit:]])*$/',$_REQUEST['id'])) {
  echo "error";
  exit();
}

$servidor = getenv('ODK_SERVIDOR');
$database = getenv('ODK_DATABASE');
$user = getenv('ODK_USER');
$pass = getenv('ODK_PASS');

$link = pg_Connect("host=$servidor port=5432 dbname=$database user=$user password=$pass options='--client_encoding=UTF8'");
if(isset($_REQUEST['id'])){
  $numero_predial = intval($_REQUEST['id']);
  $cadena_sql = <<<EOT
  SELECT "_URI",
         "_CREATOR_URI_USER",
         "_CREATION_DATE",
         "_LAST_UPDATE_URI_USER",
         "_LAST_UPDATE_DATE",
         "NBANOS",
         "NBODEGAS",
         "NCOCINAS",
         "NCOMEDORES",
         "NESTUDIOS",
         "NHABITACIONES",
         "NLOCALES",
         "NOFICINAS",
         "NPISOS",
         "NSALAS",
         "ACABADO_PISOS_BANO_LIST",
         "ACABADO_PISOS_COCINA_LIST",
         "ACABADO_PISOS_LIST",
         "ACCESO_CONS_LIST",
         "ACTIVIDAD_ECONOMICA",
         "ACTIVIDAD_ECONOMICA_UNIDAD",
         "ANO_CONS",
         "ANOTACION_MEDIDA",
         "ANOTACION_PROTECCION",
         "ANOTACION_RTDAF",
         "ANOTACION_RUPTA",
         "APROVECHAMIENTO_AGUA_LIST",
         "AREA_BOSCOSA",
         "AREA_CONSTRUIDA_TOTAL",
         "AREA_CONSTRUIDA_TOTALVAR",
         "AREAS_AGRICOLAS",
         "ATIENDE_VISITA",
         "AVALUO_CATASTRAL",
         "AVALUO_EDIFICACIONES",
         "AVALUO_TERRENO",
         "BARRIO",
         "BIENES_COMUNES_USO_EX_LIST",
         "BOSQUES",
         "BOSQUES_AREAS",
         "CAPA_VEGETAL_LIST",
         "CATEGORIA_SUELO",
         "CELULAR_DENOMINACION",
         "CLASE_SUELO",
         "CLASEPREDIO",
         "CLASIFICACION_POT",
         "CODIGO_FICHA",
         "CODIGO_HOMOGENA",
         "CODIGO_ZHFG",
         "COMUNA",
         "CONDICION_PREDIO",
         "COORDENADAS_ACCURACY",
         "COORDENADAS_ALTITUDE",
         "COORDENADAS_LATITUDE",
         "COORDENADAS_LONGITUDE",
         "CUAL_EXPLOTACION",
         "CULTIVOS",
         "DEPARTAMENTO",
         "DERECHO_PREDIO",
         "DESTINO_ECONOMICOS",
         "DIRECCION_PREDIO",
         "DISPONIBLEOFERTA",
         "DISTANCIA_FUENTES_AGUA",
         "DOCUMENTO_IDENTIF_CONTESTA",
         "DOCUMENTO_IDENTIF_ELABORA",
         "DOMICILIO_NOTIFICACIONES",
         "EMAIL_DENOMINACION",
         "ENCHAPE_BANO_LIST",
         "ENCHAPE_COCINA_LIST",
         "ESTILO_CONS_LIST",
         "ESTRATO_SOCIECON",
         "FECHA_CONSTITUCION_DENOM",
         "FECHA_MEDIDA",
         "FECHA_PROTECCION",
         "FECHA_RTDAF",
         "FECHA_RUPTA",
         "FONDO",
         "FORMA_CONS_LIST",
         "FOTO_PREDIO_CONTENTTYPE",
         "FOTO_PREDIO_URIFRAGMENT",
         "FRENTE",
         "FUNCIONALIDAD_LIST",
         "HITOS_CONS_LIST",
         "IDENTIFICACION_HABITANTE",
         "IMAGEN_CONTENTTYPE",
         "IMAGEN_URIFRAGMENT",
         "INSCRITO_RTDAF",
         "INSCRITO_RUPTA",
         "LINEA_ECONOMICA_ACCESORIOS_LIST",
         "LINEA_ECONOMICA_BANO_LIST",
         "LINEA_ECONOMICA_CARPINTERIA_LIST",
         "LINEA_ECONOMICA_CARPINTERIA_METAL_LIST",
         "LUGAR_ONSTITUCION",
         "MANZANA",
         "MAT_CIELO_RASO_LIST",
         "MAT_CIMENTACION_LIST",
         "MAT_CUB_MAT_LIST",
         "MAT_CUB_PENDIENTE_LIST",
         "MAT_ESTRUCTURA_LIST",
         "MAT_FACHADA_MAT_LIST",
         "MAT_FACHADA_TIPO_LIST",
         "MAT_ILUMINACION_LIST",
         "MAT_MAPOSTERIA_LIST",
         "MAT_MOBILIARIO_LIST",
         "MAT_PANETE_PANETE_LIST",
         "MAT_PLACA_PISO_LIST",
         "MATRICULA_PREDIO",
         "MEDIDA_PROTECCION",
         "MUNICIPIO",
         "NAIONALIDAD",
         "NOMBRE_CONTESTA",
         "NOMBRE_ELABORA",
         "NOMBRE_HABITANTE",
         "NOMBRE_OFERENTE",
         "NUCLEO",
         "NUM_BALCONES",
         "NUM_DOCUMENTO_IDENTIF_CONTESTA",
         "NUM_DOCUMENTO_IDENTIF_ELABORA",
         "NUM_MEZANINES",
         "NUM_TERRAZAS",
         "NUMERO_CONTACTO",
         "NUMERO_MATRIZ_PH",
         "NUMERO_PISO",
         "NUMERO_PREDIAL",
         "NUMERO_PREDIAL_VIEJO",
         "OBRA_INFRA_INTERIOR_LIST",
         "OBSERVACIONES",
         "OBSERVACIONES_OFERTA",
         "OPCION_TIPO_TENENCIA",
         "OPCIONPREDIODT",
         "OPCIONPREDIOPR",
         "OPCIONPREDIOUSOPUB",
         "OPCIONTIPOBIEN",
         "OPCIONTIPOBIENADMON",
         "OTRA_TENENCIA",
         "OTRAS_AFECTACION",
         "OTRAS_CAPA_VEGETAL",
         "OTRAS_SERVIDUMBRE",
         "OTRO_DOCUMENTO",
         "PASTOS",
         "PENDIENTE",
         "PENULTIMAVIGENCIAFISCAL",
         "PERSONA_HABITA_PREDIO",
         "PLANTA_FORESTAL",
         "PRESENCIA_AGUA",
         "PROTECCION_JURIDICA",
         "REGISTRO_MERCANTIL",
         "SERVICIOS_PUBLICOS",
         "TERRENO_ESCRITURA",
         "TERRENO_RESULTANTE",
         "TERRITORIOS_AGRICOLAS",
         "TIEMPO_EXPLOTADO",
         "TIEMPO_HABITADO",
         "TIPO_AFECTACION",
         "TIPO_DERECHO",
         "TIPO_DESARROLLO_CONS_LIST",
         "TIPO_DOCUMENTO",
         "TIPO_EXPLOTACION",
         "TIPO_FUENTE_AGUA_LIST",
         "TIPO_OFERTA",
         "TIPO_PERSON_JUR",
         "TIPO_PERSONA",
         "TIPO_PREDIO",
         "TIPO_SERVIDUMBRE",
         "TIPO_TERRITORIO_AGRICOLA",
         "TIPOLOGIA_CONS_LIST",
         "TITULAR_DERECHO",
         "UBICACION_COPROPIEDAD_CONS_LIST",
         "UBICACION_MANZANA",
         "ULTIMAVIGENCIAFISCAL",
         "VALOR_NEGOCIADO",
         "VALOR_OFRECIDO",
         "VIGENCIA_FISCAL",
         "_ROW_ETAG",
         "_DATA_ETAG_AT_MODIFICATION",
         "_CREATE_USER",
         "_LAST_UPDATE_USER",
         "_DELETED",
         "_FILTER_TYPE",
         "_FILTER_VALUE",
         "_FORM_ID",
         "_LOCALE",
         "_SAVEPOINT_TYPE",
         "_SAVEPOINT_TIMESTAMP",
         "_SAVEPOINT_CREATOR",

    (SELECT display_text
     FROM public.dominios
     WHERE tabla ='ficha_predial'
       AND choice_list_name = 'actividad_economica'
       AND data_value = ficha_predial."ACTIVIDAD_ECONOMICA") AS actividad_economica
  FROM odk_prod."__ODKTABLES__TABLE_FICHA_PREDIAL" AS ficha_predial
  WHERE "NUMERO_PREDIAL" = '$numero_predial';
EOT;
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
    'Actividad económica' => $row["actividad_economica"],
    'Capa Vegetal' => $row ["CAPA_VEGETAL_LIST"],
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
