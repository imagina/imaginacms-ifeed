<?php

namespace Modules\Ifeeds\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Ifeeds\Transformers\FeedTransformer;
use Modules\Ifeeds\Support\Facades\Rss;
use Exception;

class FeedApiController extends BaseApiController
{
  /**
   * @param Request $request
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      /* Get Parameters from URL */
      $params = $this->getParamsRequest($request);
      if(!isset($params->filter->source) && empty($params->filter->source)){
        throw new Exception("Source is required");
      }
      /* Request to Repository */
      $originalData = collect(Rss::parse($params->filter->source));
      /* Transform data just if exist $params->filter->fields */
      $data = isset($params->filter->fields)
        ? new FeedTransformer($originalData)
        : $originalData;
      /* Response */
      $response = [ "data" => $data ];
      $status = 200;
    } catch (Exception $exception) {
      $status = $this->getStatusError($exception->getCode());
      $response = [ "errors" => $exception->getMessage() ];
    }
    /* Return response */
    return response()->json($response, $status);
  }
}