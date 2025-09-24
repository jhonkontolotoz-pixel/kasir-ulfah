<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        header {
            overflow: hidden;
            padding: 2rem 30px;
            background: #eee;

        }

        header div {
            width: 30%;
            float: left;
        }

        table {
            width: 100%;
            text-align: center;
        }

        .t-head td {

            color: #000;
            font-size: 12px;
            font-weight: bold;
            padding: 8px !important;
        }

        .t-body td {
            color: #000;
            font-size: 8px;
            padding: 5px;

        }

        .t-head {
            background-color: #fa525a;
        }

        main {
            padding: 10px 30px;
        }

        .native-color {
            background-color: #ffffff;
        }

        .alt-color {
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <header>
        <div style="text-align: left;">
            Logo
        </div>
        <div style="text-align: center;">
            Categories Report
        </div>
        <div style="text-align: right;">
            {{$date}}
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>

    </footer>

    <script type="text/php">
        if ( isset($pdf) ) {
          $h = $pdf->get_height();

          $size = 8;
          $font_bold = $fontMetrics->getFont("helvetica", "bold");
          $text_height = $fontMetrics->getFontHeight($font_bold, $size);
          $y = $h - $text_height - 20;

         $pdf->page_text(650, $y , "Page {PAGE_NUM} of {PAGE_COUNT}", $font_bold, $size, [0, 0, 0]);
        }
    </script>

</body>

</html>