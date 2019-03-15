<?php
/* Smarty version 3.1.33, created on 2019-03-15 13:47:48
  from '/home/lars/git/elyday/adrastea/application/views/templates/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c8bad04b04ab7_20673245',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e8333918e44f8709ccd36b26827b4f828dc1cf1e' => 
    array (
      0 => '/home/lars/git/elyday/adrastea/application/views/templates/header.tpl',
      1 => 1552656781,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c8bad04b04ab7_20673245 (Smarty_Internal_Template $_smarty_tpl) {
?><html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Localhorst Viersen">

    <title>Adrastea - <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>

    <link href="/application/third_party/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/do/migration">Migration</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header><?php }
}
