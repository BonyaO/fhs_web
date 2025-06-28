<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        body {
            font-family: 'Time New Roman', Arial, sans-serif;
            font-size: 11px;
            margin: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #888888;
            padding: 6px;
        }

        #header td,
        th {
            border-color: transparent;
        }

        h1,
        h2,
        h3 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-sm {
            font-size: 12px;
            line-height: 1.2;
        }

        .student-header {
            list-style: none;
            margin-left: -2rem;
        }
    </style>

</head>

<body class="font-sans antialiased">
    @php
        function getImage($path)
        {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    @endphp

    <div class="min-h-screen bg-gray-75 dark:bg-gray-900">
        <table id="header">
            <tr>
                <td style="text-align: center">
                    <h3 style="margin-bottom: 0">The Republic of Cameroon</h3>
                    <p>Peace-Work-Fatherland</p>
                    <h3>The University of Bamenda</h3>
                    <p style="margion-botto: 0">Faculty of Health Sciences</p>
                    <p style="margin: 3px">Website: <a href="www.fhs.uniba.cm">www.fhs.uniba.cm</a></p>
                    <p style="margin: 3px">Email: <a href="mailto:fhs_admissions@uniba.cm">fhs_admissions@uniba.cm</a>
                </td>
                <td></td>
                {{-- middle --}}
                <td style="text-align: center">
                    <img width="85" height="85" style="margin: 0 auto; display: inline-block"
                        src="{{ getImage(asset('/images/uba.png')) }}" alt="University of Bamenda logo">
                </td>
                <td></td>
                {{-- last --}}
                <td style="text-align: center">
                    <h3 style="margin-bottom: 0">République du Cameroun</h3>
                    <p>Paix-Travail-Patrie</p>
                    <h3>Université de Bamenda </h3>
                    <p style="margion-botto: 0"> Faculté des Sciences de la Santé </p>
                    <p style="margin: 3px">Site Web: <a href="www.fhs.uniba.cm">www.fhs.uniba.cm</a></p>
                    <p style="margin: 3px">Email: <a href="mailto:fhs_admissions@uniba.cm">fhs_admissions@uniba.cm</a>
                    </p>
                </td>
                <td></td>
            </tr>
        </table>
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
<html>
