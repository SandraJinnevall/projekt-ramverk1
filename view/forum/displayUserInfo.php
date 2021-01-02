<?php $filter   = new \Anax\TextFilter\TextFilter(); ?>

<div class="profil">
    <?php foreach ($user as $u) : ?>
        <div class="left-profil">
            <div class="" style="width:17%;height:180px;float:left;">
                <img style="width:150px;" src="<?= $u->img ?>" alt="Finns ingen bild.">
            </div>
            <div class="user-text" style="margin-left: 18%;height: 180px;">
                <p style="margin-top:2px;margin-bottom:2px;"><a href="displayuser/<?= $u->id ?>"><?= $u->acronym ?></a></p>
                <p style="margin-top:2px;margin-bottom:2px;"><a href="displayuser/<?= $u->id ?>"><?= $u->displayname ?></a></p>
                <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;">Skapad <?= $u->created ?></p>
                <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;">Senast inloggad <?= $u->active ?></p>
                <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;">Rykte [<?= $u->reputation ?>]</p>
            </div>
        </div>
        <div class="right-profil">
            <div class="bio">
                <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;"><?= $u->bio ?></p>
                <?php if (!$u->bio) { ?>
                    <p>Uppdatera din info för att lägga något i din bio.</p>
                <?php } ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<form style="padding-top: 5px;" method="POST" action="update">
    <button type="submit">Uppdatera info om mig</button>
</form>




<h4>Mina frågade frågor</h4>
<table>
    <?php foreach ($question as $q) : ?>
    <tr>
        <td>
            <?php $parsedtitle = $filter->parse($q->title, ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../displayquestion/<?=$q->questionid?>"><?= $parsedtitle->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!$question) { ?>
    <p>Du har inte ställt någon fråga.</p>
<?php } ?>

<h4>Frågor som jag har svarat</h4>
<table>
    <?php foreach ($questionanswer as $qa) : ?>
    <tr>
        <td>
            <?php $parsedtitleq = $filter->parse($qa['title'], ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../displayquestion/<?=$qa['questionid']?>"><?= $parsedtitleq->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!$questionanswer) { ?>
    <p>Du har inte svarat på någon fråga.</p>
<?php } ?>

<h4>Frågor som jag har kommenterat</h4>
<table>
    <?php foreach ($questioncomment as $qc) : ?>
    <tr>
        <td>
            <?php $parsedtitleqc = $filter->parse($qc['title'], ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../displayquestion/<?=$qc['questionid']?>"><?= $parsedtitleqc->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (!$questioncomment) { ?>
    <p>Du har inte kommenterat någon fråga.</p>
<?php } ?>

<h4>Frågors svar som jag har kommenterat</h4>
<table>
    <?php foreach ($answercomment as $ac) : ?>
    <tr>
        <td>
            <?php $parsedtitleqc = $filter->parse($ac['title'], ["shortcode", "markdown"]); ?>
            <a class="questions-link" href="../displayquestion/<?=$ac['questionid']?>"><?= $parsedtitleqc->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (!$answercomment) { ?>
    <p>Du har inte kommenterat något svar.</p>
<?php } ?>
