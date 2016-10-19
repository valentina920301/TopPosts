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

 $sScriptName = explode('/', $_SERVER['SCRIPT_NAME']);
 $sRequestUri = explode('/', $_SERVER['REQUEST_URI']);
 $aCustomUri = array();
 $iControllerIndex = 0;

 foreach ($sScriptName as $iKey => $sValue){
     if ($sValue == 'index.php') {
         $iControllerIndex = $iKey;
         break;
     }
 }
 $iActionIndex = $iControllerIndex + 1;
 $sControllerName = $sRequestUri[$iControllerIndex];
 $sActionName = $sRequestUri[$iActionIndex];

 $sControllerClassName = '\\TopPosts\\Controllers\\'.ucfirst($sControllerName).'Controller';

 $sTemplate = new \TopPosts\Template($sControllerName, $sActionName);

 try{
     $oController = new $sControllerClassName($sTemplate);
 } catch (\Exception $e) {
     echo "No such controller";
 }

 if (!method_exists($oController, $sActionName)) {
     die("No such action");
 }
 $oController->$sActionName();
 $sTemplate->render();