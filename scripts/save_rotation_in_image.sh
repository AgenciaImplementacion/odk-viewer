#!/bin/bash

# rationale: debido a que las imagenes no tienen guardardada la
# rotacion en la imagen si no como metadato, se abren las imagenes
# con gimp y se automatiza la conversión
# se ejecuta con:
# for i in `seq 1 10`; do sleep 1 && ./save_rotation_in_image; done

xdotool mousemove --sync 10 90
xdotool click 1

xdotool mousemove --sync 10 420
xdotool click 1

sleep 1

xdotool mousemove --sync 1050 570
xdotool click 1

sleep 3
xdotool key "Ctrl+w"
