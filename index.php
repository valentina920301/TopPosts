 <?php
 spl_autoload_register(function($sClassName){
    $aClassPathSplitted = explode('\\', $sClassName);
    $sVendor = $aClassPathSplitted[0].'\\';
    $sClassPath = str_replace($sVendor, '', $sClassName);
    $sClassPath = str_replace("\\", '/', $sClassPath);
    require_once $sClassPath.'.php';
 });

 $sConfigName = getenv('CONFIG_NAME');

/**
 * @var \TopPosts\Configs\DBConfig $oDBConfigClass
 */
 $oDBConfigClass = '\\TopPosts\\Configs\\'.$sConfigName.'\\DBConfig';


 TopPosts\DB::setInstance(
    $oDBConfigClass::USER,
    $oDBConfigClass::PASSWORD,
    $oDBConfigClass::DBNAME,
    $oDBConfigClass::HOST
 );
