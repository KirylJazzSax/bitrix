<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Local\Classes\Collections\News\News;
use Local\Classes\Collections\User\User;

?>
<div>
    <?php /** @var $user User */ ?>
    <?php foreach ($arResult['DATA'] as $user): ?>
        <ul>
            <li>
                <p>[<?= $user->id ?>] - <?= $user->login ?></p>
                <ul>
                    <?php /** @var $news News */ ?>
                    <?php foreach ($user->news->getAllNews() as $news): ?>
                        <li>
                            - <?= $news->name ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    <?php endforeach; ?>
</div>