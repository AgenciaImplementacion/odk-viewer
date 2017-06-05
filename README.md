# odk-viewer
Visor web básico de datos geográficos.

# Requerimientos

- Openlayers 4
- Webpack 2
- nodejs (necesario instalar)
- npm (necesario instalar)

# Entorno de desarrollo
1) Clonar el proyecto.

```bash
git clone https://github.com/AgenciaImplementacion/odk-viewer
```

2) Instalar las dependencias.

```bash
cd odk-viewer
npm install
```
## Desarrollo live-reload

```bash
npm run live
```

# Despliegue
Crear el bundle.

```bash
npm run build
```
# Abrir proyecto
Abrir el `index.html` para ver los resultados.

```bash
open index.html
```

# Conveniciones para construir el projecto
 - https://github.com/kriasoft/Folder-Structure-Conventions

# Basado en
 - https://github.com/gipong/shp2geojson.js
 - https://github.com/wavded/js-shapefile-to-geojson
 - https://www.genbetadev.com/javascript/webpack-gestion-integrada-y-eficiente-de-tus-assets
