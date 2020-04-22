<?php


namespace Modules\Ifeeds\Http\Controllers\Api;

use Modules\Ifeeds\Entities\Status;
use Exception;

class StatusApiController
{

  private $status;

  public function __construct(Status $status)
  {
    $this->status = $status;
  }

  public function index()
  {
    try {
      $statuses = $this->status->lists();
      $response=[
        'data' => $statuses
      ];
    }  catch (Exception $e) {
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }

}