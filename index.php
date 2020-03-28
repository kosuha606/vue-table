<?php


function lines($string) {
    $result = '';
    $parts = explode("\n", $string);
    $i = 1;
    foreach ($parts as $part) {
        $numb = str_pad($i, 4, ' ', STR_PAD_LEFT);
        $result .= "$numb. ".$part."\n";
        $i++;
    }

    return $result;
}

?>

<html>
<head>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js"></script>
</head>
<body>
<div id="app" class="container">
<h1 class="text-center">vue-table, примеры</h1>
<p>&nbsp;</p>
<h2>Полная таблица по умолчанию</h2>
<?php ob_start(); ?>
<vue-table
    id="first"
    :filter-components="[
    {
        field: 'name',
        label: 'Имя',
        component: 'FilterInput'
    }
    ]"
    :mass-operation-components="[
    {
        operation: 'operationName',
        component: 'Button',
        props: {label: 'Операция'}
    }
    ]"
    :cell-components="[
    {
        field: 'id',
        label: 'ID',
        component: 'StringCell'
    },
    {
        field: 'name',
        label: 'Имя',
        component: 'StringCell'
    },
    {
        field: 'post',
        label: 'Пост',
        component: 'StringCell'
    },
    {
        field: 'is_active',
        label: 'Активность',
        component: 'StringCell'
    },
    {
        field: 'created_at',
        label: 'Создан',
        component: 'StringCell'
    }
    ]"
    :sync-url="'/api.php'"
></vue-table><?php
$one = ob_get_clean();
?>
<?= $one ?>
<h3>Исходный код:</h3>
<pre class="code">
 <code class="html">
<?= lines(htmlentities($one)) ?>
 </code>
</pre>
<h2>Кастомизация шаблонов</h2>
<?php ob_start(); ?>
<vue-table
    id="second"
    :sync-url="'/api.php'"
    :templates-order="['filters', 'pagination', 'list']"
></vue-table><?php
$one = ob_get_clean();
?>
<?= $one ?>
<h3>Исходный код:</h3>
<pre class="code">
 <code class="html">
<?= lines(htmlentities($one)) ?>
 </code>
</pre>
<h2>Измененный порядок вывода шаблонов</h2>
<?php ob_start(); ?>
<vue-table
    id="third"
    :sync-url="'/api.php'"
    :templates-order="['filters', 'list',  'pagination']"
></vue-table><?php
$one = ob_get_clean();
?>
<?= $one ?>
<h3>Исходный код:</h3>
<pre class="code">
<code class="html">
<?= lines(htmlentities($one)) ?>
</code>
</pre>
    <p>&nbsp;</p>
    <div class="text-center">
        &copy;
        <?= date('Y'); ?>
    </div>
</div>
<script src="dist/app.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>