<?php
/*
|--------------------------------------------------------------------------
| Your Application's PHP classes auto-loading
|
| All classes in PIMF are statically mapped. It's just a simple array of
| class to file path maps for ultra-fast file loading.
|--------------------------------------------------------------------------
*/
spl_autoload_register(
    function ($class) {

        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
        // FEEL FREE TO CHANGE THE MAPPINGS AND DIRECTORIES
        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

        /**
         * The mappings from class names to file paths.
         */
        static $mappings = [
            'Credits\\Application\\Listener'               => '/Credits/Application/Listener.php',
            'Credits\\DataMapper\\Credit'                 => '/Credits/DataMapper/Credit.php',
            'Credits\\Model\\Credit'                      => '/Credits/Model/Credit.php',
            'Credits\\Service\\FindExistingCredit'         => '/Credits/Service/FindExistingCredit.php',
            'Credits\\Service\\ListApiUsageOptions'        => '/Credits/Service/ListApiUsageOptions.php',
            'Credits\\Service\\CreateNewCredit'           => '/Credits/Service/CreateNewCredit.php',
            'Credits\\Service\\UpdateExistingCredit'      => '/Credits/Service/UpdateExistingCredit.php',
            'Credits\\Service\\DeleteExistingCredit'       => '/Credits/Service/DeleteExistingCredit.php',
            'Credits\\Service\\WriteAllowedRequestMethods' => '/Credits/Service/WriteAllowedRequestMethods.php',
        ];

        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
        //  END OF USER CONFIGURATION!!!
        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

        // load the class from the static heap of classes.
        if (isset($mappings[$class])) {
            return require __DIR__ . DIRECTORY_SEPARATOR . $mappings[$class];
        }

        return false;
    }
);
