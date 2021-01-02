<?php $filter   = new \Anax\TextFilter\TextFilter(); ?>

<?php foreach ($question as $q) : ?>
<div>
    <h4>Fråga av  <img style="width:40px;" src="<?= $q->img ?>" alt="Ingen bild"> <?= $q->displayname ?></h4>
    <div style="border-left: 3px solid grey; padding-left: 8px; margin-bottom: 15px;">
        <p style="font-style: oblique; font-size: 14px;">Frågad <?= $q->created ?></p>
        <?php $parsedtitle = $filter->parse($q->title, ["shortcode", "markdown"]); ?>
        <?= $parsedtitle->text ?>
        <?php $parsedquestion = $filter->parse($q->question, ["shortcode", "markdown"]); ?>
        <?= $parsedquestion->text ?>
        <?php
        $arr =  explode(" ", $q->tags);
        if ($q->tags) {
            foreach ($arr as $v) { ?>
                <span style="background-color: lightblue; padding: 1px;"> <?= $v ?></span>
                <?php
            }
        }
        ?>
    </div>
</div>
<?php endforeach; ?>
<?php foreach ($cq as $c) : ?>
<div class="comment-question" style="width: 95%; margin: 0 auto; border-top: 1px solid black; border-bottom: 1px solid black;">
    <?php $parsedcomment = $filter->parse("$c->comment - $c->displayname - $c->created", ["shortcode", "markdown"]); ?>
    <?= $parsedcomment->text ?>
</div>
<?php endforeach; ?>

<?php if ($loggedin) {?>
    <form style="padding-top: 5px; width: 95%; margin: 0 auto;" method="POST" action="../displayquestion/<?= $id ?>">
        <input name="comment" placeholder="comment" maxlength="30" required>
        <input type="submit" name="btncomment" value="Skicka"/>
    </form>
    <?php
}
?>
<?php if ($loggedin) {?>
    <h1>Svar</h1>
    <form method="POST" action="../displayquestion/<?= $id ?>">
        <textarea type="text" name="answer" placeholder="answer" required></textarea>
        <input type="submit" name="btnanswer" value="Skicka"/>
    </form>
    <?php
}
?>

<?php foreach ($aq as $a) : ?>
<div class="answer-div">
    <h4>Svar från  <img style="width:40px;" src="<?= $a->img ?>" alt="There is no picture to show"> <?= $a->displayname ?></h4>
    <div>
        <p style="font-style: oblique; font-size: 14px;">Svarad <?= $a->created ?></p>
        <?php $parsedanswer = $filter->parse($a->answer, ["shortcode", "markdown"]); ?>
        <?= $parsedanswer->text ?>
    </div>
    <?php foreach ($ac as $commenta) : ?>
          <?php if ($a->answerid == $commenta->answerid) { ?>
              <div class="comment-question" style="width: 95%; margin: 0 auto; border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 5px;">
                  <?php $parsedcommentans = $filter->parse("$commenta->answercomment - $commenta->displayname - $commenta->created", ["shortcode", "markdown"]); ?>
                  <?= $parsedcommentans->text ?>
              </div>
          <?php } ?>
    <?php endforeach; ?>
    <?php if ($loggedin) {?>
        <form style="padding-top: 5px; width: 95%; margin: 0 auto;" method="POST" action="../displayquestion/<?= $id ?>">
            <input name="comment" placeholder="comment" required>
            <input type="hidden" name="id" value="<?= $a->answerid ?>">
            <input class="comment-bth" type="submit" name="<?= $a->answerid ?>" value="Skicka"/>
        </form>
        <?php
    }
    ?>
</div>
<?php endforeach; ?>
