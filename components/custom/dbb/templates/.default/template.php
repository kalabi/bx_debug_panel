<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/* @var $arResult array */
/* @var $arParams array */
?>


<div class="debug-bar-wrapper debug-closed" id="debugBar">
    <div class="debug-bar">
        <ul class="nav nav-tabs">
            <?php
            foreach ($arResult['messages'] as $bar => $messages) {

                $safeBar = str_replace(' ', '_', $bar);
                $safeBar = str_replace(':', '-', $safeBar);
                $safeBar = str_replace('.', '_', $safeBar);
                ?>
                <li>
                    <a href="#<?= $safeBar ?>" data-toggle="tab"><?= $bar ?><span class="badge"><?= count($messages) ?></span></a>
                </li>
                <?
            }
            ?>
        </ul>
	    <div style="float: right; margin-top: 10px; font-size: 12px">
		    <span class="badge" style="font-size: 14px;"><?=$arResult['info']['template']?></span>
		    <span class="badge" style="font-size: 14px;"><?=$arResult['info']['user']?></span>
		    <span class="badge" style="font-size: 14px;"><?=$arResult['info']['error']?></span>
		    <span>&nbsp;&nbsp;</span>
	    </div>
        <div class="clearfix"></div>
        <div class="tab-content" id="debugContent">
            <?php
            foreach ($arResult['messages'] as $bar => $messages) {
                $safeBar = str_replace(' ', '_', $bar);
                $safeBar = str_replace(':', '-', $safeBar);
                $safeBar = str_replace('.', '_', $safeBar);
                ?>
                <div class="tab-pane" id="<?= $safeBar ?>">
                    <?
                    foreach ($messages as $message) {
                        ?>
                        <blockquote>

                            <?


                            $var = $message['text'];

                            if ($message['label'] && $message['label'] !== '') {
                                ?>
                                <span class="label label-default"><?= $message['label'] ?></span>
                                <?
                            }

                            if (is_array($var) || is_object($var)) {

                                if (is_array($var) && count($var) <= 5) {
                                    if ($arParams['NF_PP'] === 'Y') {
                                        pp($var);
                                    } else {
                                        !d($var);
                                    }
                                } else {
                                    if ($arParams['NF_PP'] === 'Y') {
                                        pp($var);
                                    } else {
                                        d($var);
                                    }
                                }
                            } else {
                                ?>
                                <pre class="alert alert-<?= $message['type'] ?>"><?= $var; ?></pre>
                                <?
                            }
                            ?>
                            <div class="message-info">
                                <?php
                                if ($message['date'] && $message['trace_last']){
                                ?>
                                <span class="small">
                            <?= $message['date'] ?: '' ?>
                            <?= $message['trace_last'] ?: '' ?>
                        </span>
                            </div>
                        <? } ?>
                            <span><?= $message['var'] ?></span>

                        </blockquote>
                        <?

                    }
                    ?>
                </div>
                <?
            }
            ?>
        </div>
    </div>
</div>