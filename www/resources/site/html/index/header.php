<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nemean</title>
    <?php foreach ($data['css'] as $css) : ?>
    <link href="../css/<?php echo $css; ?>.css" rel="stylesheet" type="text/css" />
    <?php endforeach; ?>
    <script src="../js/main.js"></script>
</head>
<body>
    <header></header>

    <?php echo $data['menu']->display(); ?>

    <section id="left">
        Left section
        <br /> <br />
        <?php // $userModule->leftContent(); ?>
    </section>

    <section id="right">
        Right section
    </section>

    <section id="content">
