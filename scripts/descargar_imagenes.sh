#!/bin/bash

# rationale: descarga una lista de imagenes

urls=(\
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:0189d264-b64e-4129-8fd8-5a03de7565d3/file/1493053800273_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:0d39d930-ce40-46d7-94a0-0f14cf5e46c1/file/1492793396287_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:0ea262cf-a8e0-4280-aab6-eeca0ea58305/file/1492794774760_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:28b94e42-75d4-4846-844e-72fcb472c791/file/1492888790897_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:37c5ab4a-f234-40f8-80d3-477fa1e99ccc/file/1492874770294_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:581af895-11fd-404c-b938-c31cae16e6a3/file/1493048477322_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:5d9eb17e-ff5d-4fac-9a46-135c0137fbbd/file/1492870696148_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:60375df4-81a9-4ba6-b2be-6e85df346b9e/file/1493048000063_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:72dec976-7e9d-4bcc-9b16-db7d301f4d36/file/1493046033128_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:7e04a7cb-44a1-4931-b973-ac7db511acc7/file/1493047384585_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:b2d5afa0-5cff-4062-9ed7-04ecc46eeb60/file/1493045934019_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:c7b0b904-cfb4-4a9c-b169-f118d9a0bcc4/file/1492804311766_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:caadefa6-0b2b-48ff-b677-608a5be32aa5/file/1492891126930_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:dcc1aa57-e4a2-49e5-b174-a662755c7aae/file/1493049770541_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:f3b04633-0ba9-4c6f-8180-88f4b4544bb6/file/1492879168658_imei_359502060472539.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:0838cd9f-8fec-4ec5-8423-10b092dc17e9/file/1493419395908_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:08bd8379-e8c1-48dc-82dc-3621939cbc39/file/1493047376079_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:092625dd-68c5-46ed-8013-66f6293a4b6f/file/1492710014432_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:0e8a2ea6-51bf-47c6-8dcb-7b0f9619e9f2/file/1493311349680_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:1266bf23-d9d4-4d1e-9ea8-416e08be3e48/file/1493742692730_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:2561a6fd-9e33-47a3-b520-d4d848d82766/file/1492969890425_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:39d8be09-5a39-4566-a913-8cf41485d758/file/1492965740467_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:59bbd404-1e88-4f48-9db2-c0cf921046cf/file/1492787739723_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:6c1911c3-8b1f-43d2-a1d3-bbe31f729fab/file/1493051976819_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:825b5e66-e0b2-4de4-b274-a1de16f34d80/file/1492640038794_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:8dc3f446-22d5-4abb-90de-22511b47e400/file/1492882185095_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:952ac471-77f7-4269-9ef9-3d2baf2b0609/file/1492968052642_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:9d423004-295e-4f40-816f-fa28782a9370/file/1493313011838_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:c9f5776b-5b83-40eb-b5fa-f07a20b7ea70/file/1492958226829_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:d9f4477c-bff0-47a3-9abc-7b623715ba0c/file/1493311479342_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:de034543-f6c4-49f4-8aa7-cf51630c40af/file/1492969769324_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:f11f9c43-1c3c-4bb7-a563-537a1da4d82a/file/1493326878550_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:f514010c-8c33-4788-a957-d1fb85aa1076/file/1493312506680_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:f57ef5b8-5799-4c43-ad22-8dc0b0d37b9f/file/1492960906601_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:fc37f9e2-a7a6-4cf9-86ea-1a592464100c/file/1493051089951_imei_359502060473545.jpg" \
"http://odk.proadmintierra.info/odk/odktables/default/tables/ficha_predial/ref/uuid:12d2918f-9c7d-48f1-bcad-2ad9dff085cd/attachments/uuid:fd583128-ffc8-43ff-b697-7a6adadc347b/file/1492875215991_imei_359502060473545.jpg" \
)

for item in ${urls[*]}
do
    echo $item
    wget $item
done
