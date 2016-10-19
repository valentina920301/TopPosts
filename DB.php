<?php
namespace TopPosts;

class DB
{

  /**
  * @var \PDO
  */
  private $oConnection;

  /**
  * @var \PDOStatement
  */
  private $oStatement;

  /**
  * @var DB
  */
  private static $oInstance = null;

  /**
   * DB constructor.
   * @param string $sUsername
   * @param string $sPassword
   * @param string $sDBName
   * @param string $sHost
   */
  private function __construct($sUsername, $sPassword, $sDBName, $sHost)
  {
    $sDSN = 'mysql:dbname='.$sDBName.';host='.$sHost;
    try{
      $this->oConnection = new \PDO($sDSN, $sUsername, $sPassword);
    }catch(PDOexception $e){
        echo 'Connection failed: '.$e->getMessage();
    }
  }

  /**
   * @param string $sUsername
   * @param string $sPassword
   * @param string $sDBName
   * @param string $sHost
   */
  public static function setInstance($sUsername, $sPassword, $sDBName, $sHost)
  {
    if (self::$oInstance == null) {
      self::$oInstance = new self($sUsername, $sPassword, $sDBName, $sHost);
    }
  }

  /**
  * @return DB
  */
  public static function getInstance()
  {
    return self::$oInstance;
  }

  /**
   * @param string $sQuery
   * @param array  $aParams
   * @return bool
   */
  public function query($sQuery, $aParams)
  {
    $this->oStatement = $this->oConnection->prepare($sQuery);
    $this->oStatement->execute($aParams);
  }

  /**
   * @return array
   */
  public function fetchAll()
  {
    return $this->oStatement->fetchAll();
  }

  /**
   * @return mixed
   */
  public function row()
  {
    return $this->oStatement->fetch();
  }

  /**
   * @return int
   */
  public function rows()
  {
    return $this->oStatement->rowCount();
  }

  public function getLastInsertId()
  {
    return $this->oConnection->lastInsertId();
  }

}

?>