<?php

  class DataBase {

    /**
    * @var string
    */
    private $name;

    /**
    * @var string
    */
    private $server;

    /**
    * @var mysql_link_ID
    */
    private $connection;

    /**
    * @param string $name
    */
    public function __construct( $dataBaseName, $serverName = 'localhost' ) {
      $this->name = $dataBaseName;
      $this->server = $serverName;
    }

    /**
    * @return string $this->name
    */
    public function getName() {
      return $this->name;
    }

    /**
    * @return string The most recent mysql error
    */
    public function getErrorMessage() {
      return mysql_error( $this->connection );
    }

    /**
    * @param  string  $serverName
    * @param  string  $username
    * @return string  $password
    */
    public function connect( $username, $password = null ) {

      $isPasswordDefined = ! is_null( $password );

      if ( $isPasswordDefined ) $this->connection = mysql_connect( $this->server, $username, $password );
      else $this->connection = mysql_connect( $this->server, $username );

      $isConnectionEstablished = mysql_select_db( $this->name, $this->connection );

      return $isConnectionEstablished;

    }

    /**
    * @return boolean
    */
    public function disconnect() {

      $isDisconnected = mysql_close( $this->connection );
      return $isDisconnected;

    }

    /**
    * @param  string  $tableName
    * @param  string[]  $attributes
    * @param  string  $rowFilters
    * @return ON FAIL: false, ON SUCCESS: [ attributeName => attributeValue ][]
    */
    public function selectRows( $tableName, $attributes, $rowFilters ) {

      $query = 'SELECT';
      $query .= ' ';
      $indexAttributes = 0;

      foreach ( $attributes as $attribute ) {

        if ( $indexAttributes > 0 ) $query .= ', ';

        $query .= $attribute;
        $indexAttributes++;

      }

      $query .= ' ';
      $query .= "FROM $tableName WHERE $rowFilters";

      $areRowsFetched = mysql_query( $query, $this->connection );

      if ( $areRowsFetched ) {

        $fetchedRows = $areRowsFetched;
        $selectedRows = array();

        while ( $row = mysql_fetch_assoc( $fetchedRows ) ) array_push( $selectedRows, $row );

        return $selectedRows;

      } else return false;

    }

    /**
    * @param  string  $tableName
    * @param  [ attribute => attributeValue, ... ]  $row
    * @return boolean
    */
    public function insertRow( $tableName, $row ) {

      $query = "INSERT INTO $tableName (";
      $indexAttributes = 0;

      foreach ( $row as $attribute => $attributeValue ) {

        if ( $indexAttributes > 0 ) $query .= ', ';

        $query .= $attribute;
        $indexAttributes++;

      }

      $query .= ') VALUES (';
      $indexAttributesValues = 0;

      foreach ( $row as $attribute => $attributeValue ) {

        if ( $indexAttributesValues > 0 ) $query .= ', ';

        $query .= "'$attributeValue'";
        $indexAttributesValues++;

      }

      $query .= ')';

      $isRowInserted = mysql_query( $query, $this->connection );

      return $isRowInserted;

    }

    /**
    * @param  string  $tableName
    * @param  string  $rowFilters
    * @return boolean
    */
    public function deleteRow( $tableName, $rowFilters ) {

      $query = "DELETE FROM $tableName WHERE $rowFilters";
      $isRowDeleted = mysql_query( $query, $this->connection );

      return $isRowDeleted;

    }

    // IMPLEMENTACION

    public function getRegistrationsByTeacherId( $teacherId ) {

      $query = 'SELECT a.nombrealumno, c.matricula, c.clvasig, c.cpar1, c.cpar2, c.cpar3, c.cpar4, c.cpar5, c.cpar6 ';
      $query .= "FROM calificaciones c INNER JOIN alumnos a ON a.matricula = c.matricula AND c.clvprof=$teacherId";

      $areClassRegistrarions = mysql_query( $query, $this->connection );

      if ( $areClassRegistrarions ) {

        $fetchedClassRegistrarions = $areClassRegistrarions;
        $classRegistrations = array();

        while ( $classRegistration = mysql_fetch_assoc( $fetchedClassRegistrarions ) ) {
          array_push( $classRegistrations, $classRegistration );
        }

        return $classRegistrations;

      } else return null;

    }

    public function groupRegistrationsBySubjects( $classRegistrations ) {

      # Verifying the entry values:
      $arentRegistrarionsInClass = !( is_array( $classRegistrations ) and count( $classRegistrations ) > 0 );
      if ( $arentRegistrarionsInClass ) return null;

      # Grouping registrarions:
      $groupedRegistrarions = array();

      foreach ( $classRegistrations as $classRegistration ) {

        $subjectKey = $classRegistration['clvasig'];
        unset( $classRegistration['clavasig'] );

        $isSubjectNotInArray = !isset( $groupedRegistrarions[ $subjectKey ] );
        if ( $isSubjectNotInArray ) $groupedRegistrarions[ $subjectKey ] = array( 'clvasig' => $subjectKey, 'registrarions' => array() );

        $groupedRegistrarions[ $subjectKey ]['registrarions'][ $classRegistration['matricula'] ] = $classRegistration;

      }

      return $groupedRegistrarions;

    }

    public function authenticateUser( $username, $password ) {

      $query = "SELECT pwdprof FROM profesores WHERE cprof=$username";

      $isValidUsername = mysql_query( $query, $this->connection );

      if ( $isValidUsername ) {

        $fetchedPassword = $isValidUsername;
        $doesPasswordMatch = $password == mysql_fetch_assoc( $fetchedPassword )['pwdprof'];

        return $doesPasswordMatch;

      } else return false;

    }

    public function getTeacherNameByTeacherId( $teacherId ) {

      $query = "SELECT nomprof FROM profesores WHERE cprof=$teacherId";

      $areTeacherData = mysql_query( $query, $this->connection );

      if ( $areTeacherData ) {

        $fetchedTeacherName = $areTeacherData;
        $teacherName = mysql_fetch_assoc( $fetchedTeacherName );

        return $teacherName;

      } else return false;

    }

    public function updateStudentPartialGrades( $studentId, $classId, $partialGrades ) {

      $query = 'UPDATE calificaciones SET';
      $query .= ' ';

      $partialGradeIndex = 0;

      foreach ( $partialGrades as $partialGradeFieldName => $partialGrade ) {

        if ( $partialGradeIndex > 0 ) $query .= ', ';
        $query .= "$partialGradeFieldName=$partialGrade";

        $partialGradeIndex++;

      }

      $query .= ' ';
      $query .= "WHERE matricula=$studentId AND clvasig='$classId'";

      $isUpdateSuccessful = mysql_query( $query, $this->connection );

      return $isUpdateSuccessful;

    }

    public function addStudent( $row ) {

      /* TODO: Verify row */

      $isAdditionSuccessful = $this->insertRow( 'alumnos', $row );

      return $isAdditionSuccessful;

    }

  }
