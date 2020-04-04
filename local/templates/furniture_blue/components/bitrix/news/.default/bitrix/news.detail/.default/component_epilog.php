<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Local\Classes\Collections\News\Complaint;
use Local\Classes\Repositories\ComplaintsRepository;
use Local\Classes\Utils\App\ApplicationUtils;
use Local\Classes\Utils\App\UserUtils;
use Local\Classes\Utils\Http\HttpUtils;
use Local\Classes\Utils\News\CanonicalIBlockUtils;
use Local\Classes\Utils\News\ComplaintUtils;

$canonicalUtils = new CanonicalIBlockUtils($arParams, $arResult);

if ($canonicalUtils->isInParametersIdCanonical() && $nameElement = $canonicalUtils->getNameCanonicalElement()) {
    $APPLICATION->SetDirProperty($canonicalUtils::CANONICAL_PROPERTY, $nameElement);
}

if (HttpUtils::isAjax() || HttpUtils::getQuery('COMPLAINT') === 'Y') {
    $userUtils = new UserUtils($USER);
    $appUtils = new ApplicationUtils($APPLICATION);
    $complaint = new Complaint('Очередная жалоба', $userUtils->complaintUserInfo(), (int)$arResult['ID']);

    $fields = ComplaintUtils::prepareFields($complaint);
    $idComplaint = ComplaintsRepository::save($fields);

    if (HttpUtils::isAjax()) {
        $APPLICATION->RestartBuffer();
        echo CUtil::PhpToJSObject([
            'idComplaint' => $idComplaint
        ]);
        die;
    }

    if (HttpUtils::getQuery('COMPLAINT') === 'Y') {
        LocalRedirect($appUtils->complaintUrlRedirect($idComplaint));
    }
}
?>
