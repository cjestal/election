<?php
  require_once('models/result.php');
  class ResultsController {
    public function index() {
      $this->showAll();
    }

    public function showAll () {
      $result = new Result();
      $positionIDs = $result->getDistinctPositions();
      $data = array();

      foreach ($positionIDs as $positionID) {
        $data[$positionID]['name'] = $result->getPositionName($positionID);
        $data[$positionID]['results'] = $result->getVotesByPosition($positionID);
        $data[$positionID]['total'] = 0;

        //calculate total votes made for current position
        foreach ($data[$positionID]['results'] as $candidate) {
          $data[$positionID]['total'] += (int)$candidate['votes']; 
        }
      }
      require_once('views/results/index.php');
    }
  }
?>