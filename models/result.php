<?php


  class Result {
    
    private $rawData = null; // data container. private so that it can only be accessed through public functions.
    private $totalData = 0;
    private $data = null;
    private $positionNames = [
      1 => "Mayor",
      2 => "Tribe Chief", 
      3 => "Tribe Sergeant", 
      4 => "Lead Hunter", 
      5 => "Project Manager" 
    ];

    public function __construct() {
      $file = fopen("C:/wamp/www/election/SIXA.csv","r");
      $row = 0;
      
      while (!feof($file)) {
        $this->rawData[$row] = fgetcsv($file);
        $row++;
      }

      array_pop($this->rawData); // remove residue
      $this->totalData = $row - 1; //excludes header row

      $newData = $this->rawData;
      array_shift($newData); // remove header
      $this->data = $newData;

      fclose($file);
    }

    public function getCandidate ($id) {
      $data = $this->data;
      $headers = $this->rawData[0];
      $candidate = array_fill_keys($headers,""); // convert values to keys
      
      $isSearching = true;
      $index = 0;
      $candidateData = null;

      //iterate through each data until id is found
      while ($isSearching) {
        if ($data[$index][0] == $id) {
          $isSearching = false;
          $candidateData = $data[$index];
        } else {
          $index++;
        }
      }

      $index=0;
      foreach($candidate as $key => $value){
          $candidate[$key] = $candidateData[$index];
          $index++;
      }

      return $candidate;
    }

    public function getCandidates () {
      $data = $this->data;
      $headers = $this->rawData[0];

      $template = array_fill_keys($headers,""); // convert values to keys
      $result = array();

      foreach ($data as $key => $value) {
        $attributes = $template; //use a copy of template
        
        $formatterIndex = 0;
        foreach($attributes as $formatterKey => $formatterValue){
          $attributes[$formatterKey] = $value[$formatterIndex];
          $formatterIndex++;
        }
        $result[$value[0]] = $attributes;
      }
      return $result;
    }

    //returns an array of position IDs in increasing order
    public function getDistinctPositions () {
      $data = $this->data;
      $positions = array();
      foreach ($data as $key => $value) {
        if (!in_array($value[3], $positions)) {
          array_push($positions, (int)$value[3]);
        }
      }
      asort($positions);
      return $positions;
    }

    public function getPositionName ($positionId) {
      return $this->positionNames[$positionId];
    }

    //returns an array of candidate id
    public function getCandidatesByPositionId ($positionId) {
      $candidates = $this->getCandidates();
      $positionCandidates = array();
      foreach ($candidates as $key => $candidate) {
        if ($candidate['position_id'] == $positionId) {
          array_push($positionCandidates, $candidate);
        }
      }

      return $positionCandidates;
    }

    public function addVote ($candidateId, $token = null) {
      if (is_null($token) || $token == '') {
        return "Invalid token";
      }

      $candidate = $this->getCandidate($candidateId);
      $votes = (int) $candidate['votes'];
      $this->data[$candidateId][8] = $votes + 1; //todo create separate update function

      return 'vote successful!';
    }

    //return the result in descending order
    public function getVotesByPosition ($positionId) {
      $candidates = $this->getCandidatesByPositionId($positionId);
      return $candidates;
    }

  }
?>