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
    <link rel="stylesheet" href="/dist/vuetable.css">
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js"></script>
</head>
<body>
<div id="app" class="container">
<h1 class="text-center">vue-table, примеры</h1>
<p>&nbsp;</p>
    <ul>
        <li>
            <a href="#header-one">Полная таблица, шаблон по умолчанию</a>
        </li>
        <li>
            <a href="#header-two">Кастомизация шаблонов</a>
        </li>
        <li>
            <a href="#header-three">Измененный порядок вывода шаблонов</a>
        </li>
        <li>
            <a href="#header-four">Пагинация показать еще</a>
        </li>
    </ul>
    <button @click="test">Test</button>
<h2 id="header-one">Полная таблица, шаблон по умолчанию</h2>
<?php ob_start(); ?>
<vue-table
    id="first"
    :sync-url="'/api.php'"
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
        props: {label: 'Сумма выбранных'}
    }
    ]"
    :cell-components="[
    {
        label: '#',
        component: 'CheckboxCell',
        massOperation: 'selected',
        attrs: {
            width: '1%'
        }
    },
    {
        field: 'id',
        label: 'ID',
        component: 'string-cell'
    },
    {
        field: 'name',
        label: 'Название',
        props: {
            link: function(item) { return '/detail.php?id='+item.id; }
        },
        component: 'string-cell'
    },
    {
        field: 'price',
        label: 'Цена',
        component: 'string-cell'
    },
    {
        field: 'qty',
        label: 'Кол-во',
        component: 'string-cell'
    }
    ]"
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
<h2 id="header-two">Кастомизация шаблонов</h2>
<?php ob_start(); ?>
<vue-table
    id="second"
    :sync-url="'/api.php'"
    :templates-order="['filters', 'pagination', 'list']"
    :cell-components="[
    {
        field: 'id',
        label: 'ID',
        component: 'string-cell'
    },
    {
        field: 'name',
        label: 'Название',
        component: 'string-cell'
    },
    {
        field: 'price',
        label: 'Цена',
        component: 'string-cell'
    },
    {
        field: 'qty',
        label: 'Кол-во',
        component: 'string-cell'
    }
    ]"
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
    <h2 id="header-three">Измененный порядок вывода шаблонов</h2>
    <?php ob_start(); ?>
    <vue-table
            id="third"
            :sync-url="'/api.php'"
            :templates-order="['filters', 'list',  'pagination']"
            :cell-components="[
    {
        field: 'id',
        label: 'ID',
        component: 'string-cell'
    },
    {
        field: 'name',
        label: 'Название',
        component: 'string-cell'
    },
    {
        field: 'price',
        label: 'Цена',
        component: 'string-cell'
    },
    {
        field: 'qty',
        label: 'Кол-во',
        component: 'string-cell'
    }
    ]"
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
    <h2 id="header-four">Пагинация показать еще</h2>
    <?php ob_start(); ?>
    <vue-table
        id="appendpagination"
        :sync-url="'/api.php'"
        :pagination-append-mode="true"
        :templates-order="['list',  'pagination']"
        :cell-components="[
    {
        field: 'id',
        label: 'ID',
        component: 'string-cell'
    },
    {
        field: 'name',
        label: 'Название',
        component: 'string-cell'
    },
    {
        field: 'price',
        label: 'Цена',
        component: 'string-cell'
    },
    {
        field: 'qty',
        label: 'Кол-во',
        component: 'string-cell'
    }
    ]"
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