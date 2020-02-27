<?php

use Bitrix\Main\Page\Asset;
use test\CApp;

define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_CHECK', true);
define('NO_AGENT_STATISTIC', true);
define('DisableEventsCheck', true);
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->ShowHead();

// JAVASCRIPT
Asset::getInstance()->addJs('/local/js/uikit.min.js');
Asset::getInstance()->addJs('/local/js/uikit-icons.min.js');

//CSS
Asset::getInstance()->addCss('/local/css/uikit.min.css');

$CApp = new CApp();
CJSCore::Init(['jquery', 'date']);
?>

<div class="uk-container">
    <form action="">
        <div class="uk-grid uk-margin-medium-top uk-flex-middle">
            <div class="uk-width-1-2 uk-text-right">
                <label>
                    <input class="uk-input" type="text" value="<?= $CApp->getFilterDate() ?>" name="DATE"
                           onclick="BX.calendar({node: this, field: this, bTime: false});">
                </label>
            </div>
            <div class="uk-width-auto">
                Выберите дату
            </div>
            <div class="uk-width-expand">
                <button type="reset" class="uk-button uk-button-primary">Сбросить</button>
            </div>
        </div>
    </form>

    <table class="uk-table uk-table-striped">
        <thead>
        <tr>
            <th>Города</th>
            <th>Мероприятия</th>
            <th>Участники</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($CApp->city as $arCity): ?>
            <tr>
                <td colspan="3">
                    <h3><?= $arCity['NAME'] ?></h3>
                </td>
            </tr>
            <?php if (count($CApp->events->events[$arCity['ID']])): ?>
                <?php foreach ($CApp->events->events[$arCity['ID']] as $arEvent): ?>
                    <tr>
                        <td></td>
                        <td><?= $arEvent['EVENT_DATE'] ?> <b><?= $arEvent['NAME'] ?></b></td>
                        <td>
                            <?php if (count($arEvent['USERS'])): ?>
                                <?php foreach ($arEvent['USERS'] as $arUser): ?>
                                    <?= $arUser ?><br>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span style="color: red">Нет записанных участников</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <span style="color: red">Нет мероприятий в этом городе</span>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(() => {
        const dateElement = $('input[name=DATE]');
        const resetButton = $('button[type=reset]');
        const form = $('form');

        dateElement.on('change', (event) => {
            form.submit();
        });
        resetButton.on('click', (event) => {
            event.preventDefault();
            dateElement.val('');
            form.submit();
        })
    });
</script>