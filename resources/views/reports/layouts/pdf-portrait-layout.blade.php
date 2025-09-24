<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }
        
        header {
            overflow: hidden;
            height: 80px;
            border-bottom: 1px solid #eee;
        }

        header div {
            width: 30%;
            float: left;
        }

        table {
            width: 100%;
            text-align: center;
            table-layout: fixed;
            border-radius: 5px;
            min-height: 95vh;
        }

        .t-head th {
            color: #222;
            font-size: 13px;
            font-weight: 400;
            letter-spacing: 1px;
            padding: 10px 8px ;
            border: none !;
        }

        .t-body td {
            color: #444;
            font-size: 11px;
            padding:  5px;
            border: none;
        }

        .t-head {
            background-color: #fafafa;
        }

        main {
            padding: 15px 30px;
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
    
    <main style="padding: 30px 30px 40px 30px;">
        @yield('content')
    </main>
    <footer >
        
    </footer>
    <script type="text/php">
    if ( isset($pdf) ) {
        
        $h = $pdf->get_height();
        $size = 8;
        $font_bold = $fontMetrics->getFont("sans-serif", "bold");
        $text_height = $fontMetrics->getFontHeight($font_bold, $size);
        $y = $h - $text_height - 20;
        $pdf->page_text(275, $y, "Page {PAGE_NUM} of {PAGE_COUNT}", $font_bold, $size, [0, 0, 0]);

      }
      
    </script>

</body>

</html>