# Quiero que convierta todas las imágenes de la carpeta y subcarpetas en .jpg para web sin modificar el directorio original

import os
from PIL import Image

def convert_images(path):
    for root, dirs, files in os.walk(path):
        for file in files:
            if file.endswith('.jpg') or file.endswith('.jpg') or file.endswith('.jpg'):
                img_path = os.path.join(root, file)
                img = Image.open(img_path)
                img = img.convert('RGB')
                img.save(os.path.join(root, file.split('.')[0] + '.jpg'), quality=85)
                os.remove(img_path)
                
convert_images('./')
