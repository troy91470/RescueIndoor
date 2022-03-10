# attention a ne pas renommer ce fichier "qrcode.py"

import qrcode
code = qrcode.make('Hello world!')
code.save("a.png")