import qrcode
from qrcode.constants import ERROR_CORRECT_H

# URL
input_data = "http://sensorbasculas.granada.org/ecopunto.php?view=Recogidas&id="

# Cantidad de codigos a generar
n = input("Indique cuantos QR desea generar: ")

# Generacion masiva
if n > 1:
    desde = input("Indique desde que ecopunto desea generar: ")
    for i in range(desde, desde+n):
        qr = qrcode.QRCode(error_correction = 2, box_size=10, border=5)
        qr.add_data(input_data + str(i))
        qr.make(fit=True)
        img = qr.make_image(fill='black', back_color='white')
        img.save('./codigos/eco' + str(i) +'.png')
        print("Codigo " + str(i) + " generado")

# Generacion unica
elif n == 1:
    id = input("Indique el numero del ecopunto: ")
    qr = qrcode.QRCode(error_correction = 2, box_size=10, border=5)
    qr.add_data(input_data + str(id))
    qr.make(fit=True)
    img = qr.make_image(fill='black', back_color='white')
    img.save('./codigos/eco' + str(id) +'.png')
    print("Codigo " + str(id) + " generado")
