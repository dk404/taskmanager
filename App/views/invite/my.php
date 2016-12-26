<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><? echo $pageTitle ?></title>

    <? require_once "App/views/blocks/metaHeaders.php"; ?>


    <link href="/resources/lumino/css/datepicker3.css" rel="stylesheet">
    <link href="/resources/lumino/css/styles.css" rel="stylesheet">

    <!--Icons-->
    <script src="/resources/lumino/js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
    <script src="/resources/lumino/js/html5shiv.js"></script>
    <script src="/resources/lumino/js/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<? require_once "App/views/blocks/header.php"; ?>
<? require_once "App/views/blocks/sidebar.php"; ?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Приглашения</li>
            <li class="active">Мои</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><? echo $pageTitle ?></h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12 text-right mb35">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="" method="post" enctype="multipart/form-data" name="myForm" target="_self">
                        <input type="hidden" name="method_name" value="create"/>

                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Укажите email" required>
                            <div class="input-group-btn">
                                <input name="submit" type="submit" value="Создать приглашение" class="btn btn-success"/>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->


<!--    --><?// if($taskItems["items"]): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
<!--                <div class="panel-heading">Basic Table</div>-->
                <div class="panel-body">

                    <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                        <tr class="active">
                            <th class="text-center">
                                <div class="th-inner ">Date</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th class="text-center">
                                <div class="th-inner ">Email</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th class="text-center">
                                <div class="th-inner ">Status</div>
                                <div class="fht-cell"></div>
                            </th>
                            <th class="text-center">
                                <div class="th-inner ">Settings</div>
                                <div class="fht-cell"></div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
<!--                        --><?// foreach ($taskItems["items"] as $item) { ?>
                            <tr data-index="0">
                                <td class=""><? echo date("d.m.Y") ?></td>
                                <td style=""> <a href="#">sdsdsd@dfdf.ru</a></td>
                                <td style=""><span class="label label-default">ожидается</span></td>
                                <td class="text-center">
                                    <a title="Скрыть?" href="#<? echo $item["ID"] ?>" class="ml5 glyphicon glyphicon-trash"></a>
                                    
                                </td>
                            </tr>
<!--                        --><?// } ?>
                        </tbody>

                    </table>

                    <? if($taskItems["stack"]) {
                       $paginationUrl   = $thisUrl."?p=";
                       $stack           = $taskItems["stack"];

                    ?>
                    <div>
                        <div class="pull-right">
                            <? include "App/views/blocks/pagination.php"; ?>
                        </div>
                    </div>
                    <? } ?>


                    </div>


                </div>
            </div>
        </div>

    </div>
<!--    --><?// endif; ?>

</div>	<!--/.main-->

<!--<script src="/resources/lumino/js/jquery-1.11.1.min.js"></script>
<script src="/resources/lumino/js/bootstrap.min.js"></script>-->
<? require_once "App/views/blocks/scripts.php"; ?>

<script src="/resources/lumino/js/chart.min.js"></script>
<script src="/resources/lumino/js/chart-data.js"></script>
<script src="/resources/lumino/js/easypiechart.js"></script>
<script src="/resources/lumino/js/easypiechart-data.js"></script>
<script src="/resources/lumino/js/bootstrap-datepicker.js"></script>
<script>
    $('#calendar').datepicker({
    });

    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
</body>
</html>