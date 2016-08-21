<?php
  require_once('models/candidates.php');

  class HomeController {
    
    public function index() {
      $candidates = new Candidates();
      $positionIDs = $candidates->getDistinctPositions();
      $data = array();

      foreach ($positionIDs as $positionID) {
        $data[$positionID]['name'] = $candidates->getPositionName($positionID);
        $data[$positionID]['results'] = $candidates->getVotesByPosition($positionID);
      }
      require_once('views/home/index.php');
    }


    public function vote () {
      $model = new Candidates();
      $hasNoErrors = true;
      //validate each votes made
      foreach ($_POST as $positionId => $candidateId) {
        if ($hasNoErrors) {
          $hasNoErrors = $this->validateVote($model, $positionId, $candidateId);
        }
      }

      //if no errors, increment votes
      if ($hasNoErrors) {
        foreach ($_POST as $candidateId) {
          $model->addVote($candidateId);
        }
        $this->success();
      }

    }

    private function validateVote ($model, $positionId, $candidateId) {
      $positions = $model->getDistinctPositions();
      $error = '';

      if (empty($candidateId)) {
        $this->failed("You're not done yet! Now you have to repeat. :(");
        return false;
      }

      $candidateIds = $model->getCandidates();
      $candidateIds = array_keys($candidateIds); //get only the keys!
      
      if (!in_array($positionId, $positions)) { //check if position exists and correct
        $this->failed("You have chosen an invalid position! Now you have to repeat. :(");
        return false;
      } elseif (!in_array($candidateId, $candidateIds)) { //check if candidate exists and correct
        $this->failed("You voted for someone not registered! Now you have to repeat. :(");
        return false;
      } elseif ($model->getCandidate($candidateId)['position_id'] != $positionId) { //check if candidate and position match
        $this->failed("The candidate is running for another position! Now you have to repeat. :(");
        return false;
      }

      return true;

    }

    private function success () {
      require_once('views/home/success.php');
    }

    private function failed ($error) {
      require_once('views/home/failed.php');
    }

    public function error() {
      require_once('views/error.php'); //display an awesome 404 page!
    }
  }
?>