<?php
/*
   MySQL Database Connection Class
*/

class MySQL 
{
  var  $host;
  var  $dbUser;
  var  $dbPass;
  var  $dbName;
  var  $dbConn;

  function __construct( $dbUser , $dbPass )
  {
     $this->host   = 'localhost';
     $this->dbUser = $dbUser;
     $this->dbPass = $dbPass;
     $this->dbName = 'beatblox_scores';
     $this->connectToServer();
     $this->selectDatabase();
   }


  function connectToServer()
  {
       $this->dbConn = mysqli_connect( $this->host , $this->dbUser , $this->dbPass );
       if ( !$this->dbConn )
       {
           trigger_error('could not connect to server' );
       }
       else
       {
        echo "Connect Success!";
       }
  }

    function selectDatabase()
    {
    if (! mysqli_select_db( $this->dbConn, $this->dbName ) )
           {
              trigger_error( 'could not select database' );  
           }
      }

  function query( $sql )
  {
    mysqli_query( $this->dbConn, "set character_set_results='utf8'"); 
     if (!$queryResource = mysqli_query($this->dbConn, $sql ))
     {
      echo "ERRORRRRRRR";
      trigger_error ( 'Query Failed: <br>' . mysqli_error($this->dbConn ) . '<br> SQL: ' . $sql );
      return false;
     }
   
     return new MySQLResult( $this, $queryResource ); 
   }
   
}

class MySQLResult 
{
   var $mysql;
   var $query;

   function __construct( $mysql, $query )
   {
     $this->mysql = $mysql;
     $this->query = $query;
   }

    function size()
    {
        return mysqli_num_rows($this->query);
    }

    function fetch()
    {
        return $this->query;
    }

    function insertID()
    {
            /**
            * returns the ID of the last row inserted
            * @return  int
            * @access  public
            */
          return mysqli_insert_id($this->mysql->dbConn);
    }

}