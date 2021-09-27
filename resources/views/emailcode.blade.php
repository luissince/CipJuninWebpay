<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
</head>

<body>
    <table style="background:#ECECEC; padding-top:25px;padding-bottom:25px;border-radius:20px;">
        <tr style="width:100%;">
            <td style="width:20%;"></td>
            <td style="width:60%; font-size:18px; font-weight:bold;text-align: center;">
                <img src="{{ $message->embed('./images/logologin.png') }}" style="width:80px;" />
                <h2> COLEGIO DE INGENIEROS DEL PERÚ - CD Junín</h2>
            </td>
            <td style="width:20%;"></td>
        </tr>
        <tr style="width:100%;">
            <td style="width:20%;"></td>
            <td style="width:60%; font-size:18px; ">Código de verificación</td>
            <td style="width:20%;"></td>
        </tr>
        <tr style="width:100%; padding-top: 20px;">
            <td style="width:20%;"></td>
            <td style="width:60%; font-size:22px;text-align: center; font-weight: bold;">{{$msg}}</td>
            <td style="width:20%;"></td>
        </tr>
    </table>
</body>

</html>