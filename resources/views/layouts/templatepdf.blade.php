<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dokumen PDF</title>


<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        margin: 40px;
    }

    .content {
        margin-top: 10px;
    }

    .line {
        border-top: 1px solid black;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
</style>

    @yield('css')

</head>
<body>
    <div class="header" style=" margin-bottom: 10px;">
        <table width="100%" style="border: none;">
            <tr>
                <td style="width: 25%; text-align: center;">
                    <img src="{{ asset('assets/img/logo/logo-splatinum-1.png') }}" style="width: 150px;" alt="Logo">
                </td>
                <td style="width: 75%; text-align: center;">
                    <h1 style="margin: 0; font-size: 20px; font-weight: bold;">PT. Splatinum Skyreach Indonesia</h1>
                    <p style="margin: 2px 0; font-size: 12px;">Kec. Rawalumbu, Bekasi Timur, Jawa Barat 17115</p>
                    <p style="margin: 2px 0; font-size: 12px;">Telp: 0812 1415 5598 | Email: marketing@splatinum.co.id | Website: www.splatinum.co.id</p>
                </td>
            </tr>
        </table>
    </div>


    <div class="content">
        @yield('content')
        <br>
    </div>

</body>
</html>
