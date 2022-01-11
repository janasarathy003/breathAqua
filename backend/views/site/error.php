<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="page-header" style="visibility:hidden;">
        <h3 class="page-title"> </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="" href=""> </a></li>
            <li class="breadcrumb-item active" aria-current="page"> </li>
        </ol>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>
