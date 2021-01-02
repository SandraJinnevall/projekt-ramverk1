<?php $filter   = new \Anax\TextFilter\TextFilter(); ?>
<div class="user-profil" style="width:100%;margin:auto;padding-top:30px;">
    <?php foreach ($user as $u) : ?>
        <div style="width:15%;height:180px;float:left;">
            <img style="width:150px;" src="<?= $u->img ?>" alt="There is no picture to show">
        </div>
        <div class="user-text" style="margin-left: 18%;height: 180px;">
            <h4><?= $u->displayname ?></h4>
            <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;">Last active <?= $u->active ?></p>
            <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;">Reputation [<?= $u->reputation ?>]</p>
        </div>
        <div class="right-profil">
            <div class="bio">
                <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;"><?= $u->bio ?></p>
                <?php if (!$u->bio) { ?>
                    <p>Användaren har inte lagt något i sin bio.</p>
                <?php } ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<h4>Ställda frågor</h4>
<table>
    <?php foreach ($question as $q) : ?>
    <tr>
        <td>
            <?php $parsedtitle = $filter->parse($q->title, ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../../displayquestion/<?=$q->questionid?>"><?= $parsedtitle->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!$question) { ?>
    <p>Användaren har inte ställt någon fråga.</p>
<?php } ?>

<h4>Svarade frågor</h4>
<table>
    <?php foreach ($questionanswer as $qa) : ?>
    <tr>
        <td>
            <?php $parsedtitleq = $filter->parse($qa['title'], ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../../displayquestion/<?=$qa['questionid']?>"><?= $parsedtitleq->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!$questionanswer) { ?>
    <p>Användaren har inte svarat på någon fråga.</p>
<?php } ?>

<h4>Kommenterade frågor</h4>
<table>
    <?php foreach ($questioncomment as $qc) : ?>
    <tr>
        <td>
            <?php $parsedtitleqc = $filter->parse($qc['title'], ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../../displayquestion/<?=$qc['questionid']?>"><?= $parsedtitleqc->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!$questioncomment) { ?>
    <p>Användaren har inte kommenterat någon fråga.</p>
<?php } ?>


<h4>Kommenterade svar</h4>
<table>
    <?php foreach ($answercomment as $ac) : ?>
    <tr>
        <td>
            <?php $parsedtitleqc = $filter->parse($ac['title'], ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../../displayquestion/<?=$ac['questionid']?>"><?= $parsedtitleqc->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!$answercomment) { ?>
    <p>Användaren har inte kommenterat något svar.</p>
<?php } ?>
