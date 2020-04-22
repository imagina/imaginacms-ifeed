<?php


namespace Modules\Ifeeds\Http\Controllers\Api;

use Modules\Ifeeds\Entities\Type;

class TypeApiController
{

  private $type;

  public function __construct(Type $type)
  {
    $this->type = $type;
  }

  public function index()
  {
    try {
      $types = $this->type->lists();
      $response=[
        'data' => $types
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