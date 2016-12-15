<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <style type="text/css">

        ::selection { background-color: #E13300; color: white; }
        ::-moz-selection { background-color: #E13300; color: white; }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            display: inline-block;

            /*background-color: #f9f9f9;*/
            /*border: 1px solid #D0D0D0;*/
            color: #002166;
            /*display: block;*/
            /*margin: 14px 0 14px 0;*/
            /*padding: 12px 10px 12px 10px;*/
        }

        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }

        .content {
            margin: 12px 15px 12px 15px;
        }

        .content pre{
            margin: 0;
            padding:0;
        }

        .content pre ol {
            margin:0px;
        }
        .content pre li{
            border-left: 1px solid #ddd;
            height: 20px;
            line-height: 20px;
            padding-left:10px;
        }

        .line-error{
            background: #f8cbcb;
        }

    </style>
</head>
<body>
<div id="container">
    <h1><?php echo $title;?></h1>
    <div class="content">
        <?php echo $content?>
    </div>
    <?php if( !empty($source) ) {?>
    <div class="content"><pre><ol start="<?php echo $source['first'];?>"><?php
                foreach( $source['source'] as $k => $v ) {
                    $num = $k+$source['first'];
                    $curr_line = ( $num == $line ) ? 'line-error' : '' ;
                    echo '<li class="line-'.$num.' '.$curr_line.'"><code>'.htmlentities($v).'</code></li>';
                }
                ?>
            </ol></pre>
    </div>
    <?php }?>
</div>
</body>
</html>