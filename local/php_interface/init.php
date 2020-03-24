<?

use Bitrix\Main\Application;

require_once Application::getDocumentRoot() . '/local/php_interface/include/eventhandlers.php';

CModule::AddAutoloadClasses(
    '',
    [
        'Local\\Classes\\Utils\\News\\NewsUtils'
        => '/local/classes/utils/news/NewsUtils.php',

        'Local\\Classes\\Utils\\News\\CanonicalIBlockUtils'
        => '/local/classes/utils/news/CanonicalIBlockUtils.php',

        'Local\\Classes\\Utils\\Catalog\\ProductHelper'
        => '/local/classes/utils/catalog/ProductHelper.php',

        'Local\\Classes\\EventHandlers\\Catalog\\ProductEventHandler'
        => '/local/classes/eventhandlers/catalog/ProductEventHandler.php',

        'Local\\Classes\\EventHandlers\\Main\\MainEventHandler'
        => '/local/classes/eventhandlers/main/MainEventHandler.php',

        'Local\\Classes\\Loggers\\MainEventLogger'
        => '/local/classes/loggers/MainEventLogger.php',

        'Local\\Classes\\Utils\\App\\UserUtils'
        => '/local/classes/utils/app/UserUtils.php',

        'Local\\Classes\\Utils\\Menu\\AdminMenuBuilder'
        => '/local/classes/utils/menu/AdminMenuBuilder.php',

        'Local\\Classes\\Utils\\Catalog\\MetaTagsIblockUtils'
        => '/local/classes/utils/catalog/MetaTagsIblockUtils.php',

        'Local\\Classes\\EventHandlers\\Main\\PageEventHandler'
        => '/local/classes/eventhandlers/main/PageEventHandler.php',

        'Local\\Classes\\Utils\\App\\CIblockElementUtils'
        => '/local/classes/utils/app/CIblockElementUtils.php',

        'Local\\Classes\\Utils\\App\\ApplicationUtils'
        => '/local/classes/utils/app/ApplicationUtils.php',

        'Local\\Classes\\Repositories\\CatalogRepository'
        => '/local/classes/repositories/CatalogRepository.php',

        'Local\\Classes\\Repositories\\NewsRepository'
        => '/local/classes/repositories/NewsRepository.php',

        'Local\\Classes\\Repositories\\UserRepository'
        => '/local/classes/repositories/UserRepository.php',

        'Local\\Classes\\Collections\\Product\\Product'
        => '/local/classes/collections/product/Product.php',

        'Local\\Classes\\Collections\\Section\\Section'
        => '/local/classes/collections/section/Section.php',

        'Local\\Classes\\Collections\\News\\News'
        => '/local/classes/collections/news/News.php',

        'Local\\Classes\\Collections\\Product\\ProductsCollection'
        => '/local/classes/collections/product/ProductsCollection.php',

        'Local\\Classes\\Collections\\User\\User'
        => '/local/classes/collections/user/User.php',

        'Local\\Classes\\Collections\\User\\UsersCollection'
        => '/local/classes/collections/user/UsersCollection.php',

        'Local\\Classes\\Collections\\Product\\ProductProperties'
        => '/local/classes/collections/product/ProductProperties.php',

        'Local\\Classes\\Collections\\Section\\SectionsCollection'
        => '/local/classes/collections/section/SectionsCollection.php',

        'Local\\Classes\\Collections\\News\\NewsCollection'
        => '/local/classes/collections/news/NewsCollection.php',

        'Local\\Classes\\Collections\\Manufacturing\\Manufacturing'
        => '/local/classes/collections/manufacturing/Manufacturing.php',

        'Local\\Classes\\Collections\\Manufacturing\\ManufacturingCollection'
        => '/local/classes/collections/manufacturing/ManufacturingCollection.php',

        'Local\\Classes\\Utils\\Components\\SimpleCompResultDataUtil'
        => '/local/classes/utils/components/SimpleCompResultDataUtil.php',

        'Local\\Classes\\Entities\\ElementPropertyTable'
        => '/local/classes/entities/ElementPropertyTable.php',

    ]
);

?>