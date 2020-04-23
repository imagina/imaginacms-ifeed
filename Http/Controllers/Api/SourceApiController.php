<?php

namespace Modules\Ifeeds\Http\Controllers\Api;

// Libs
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Log;
use DB;

// Custom Requests
use Modules\Ifeeds\Http\Requests\CreateSourceRequest;
use Modules\Ifeeds\Http\Requests\UpdateSourceRequest;

// Transformers
use Modules\Ifeeds\Transformers\SourceTransformer;
use Modules\Ifeeds\Transformers\SourceFeedTransformer;

// Repositories
use Modules\Ifeeds\Repositories\SourceRepository;

// Facades
use Modules\Ifeeds\Support\Facades\Rss;


class SourceApiController extends BaseApiController {

  private $source;

  public function __construct(SourceRepository $source){
    parent::__construct();
    $this->source = $source;
  }

  /**
   * @param Request $request
   * @return mixed
   */
  public function index (Request $request) {
    try {
      $params = $this->getParamsRequest($request);
      $sources = $this->source->getItemsBy($params);
      $response = ['data' => SourceTransformer::collection($sources)];
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($sources)] : false;
      $status = 200;
    } catch (Exception $exception) {
      Log::Error($exception);
      $status = $this->getStatusError($exception->getCode());
      $response = ['errors' => $exception->getMessage()];
    }
    return response()->json($response, $status);
  }

  /**
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function show ($criteria, Request $request) {
    try {
      $params = $this->getParamsRequest($request);
      $source = $this->source->getItem($criteria, $params);
      if(!$source) throw new Exception('Item not found',404);
      $response = ['data' => new SourceTransformer($source)];
      $status = 200;
    } catch (Exception $exception) {
      Log::Error($exception);
      $status = $this->getStatusError($exception->getCode());
      $response = ['errors' => $exception->getMessage()];
    }
    return response()->json($response, $status);
  }

  /**
   * @param Request $request
   * @return mixed
   */
  public function create (Request $request) {
    DB::beginTransaction();
    try {
      $data = $request->input('attributes') ?? [];
      $this->validateRequestApi(new CreateSourceRequest($data));
      $source = $this->source->create($data);
      $response = ['data' => new SourceTransformer($source)];
      $status = 200;
      DB::commit();
    } catch (Exception $exception) {
      Log::Error($exception);
      DB::rollback();
      $status = $this->getStatusError($exception->getCode());
      $response = ['errors' => $exception->getMessage()];
    }
    return response()->json($response, $status);
  }

  /**
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update ($criteria, Request $request) {
    DB::beginTransaction();
    try {
      $data = $request->input('attributes') ?? [];
      $this->validateRequestApi(new UpdateSourceRequest($data));
      $params = $this->getParamsRequest($request);
      $source = $this->source->getItem($criteria, $params);
      $this->source->update($source, $data);
      $response = ['data' => new SourceTransformer($source)];
      $status = 200;
      DB::commit();
    } catch (Exception $exception) {
      Log::Error($exception);
      DB::rollback();
      $status = $this->getStatusError($exception->getCode());
      $response = ['errors' => $exception->getMessage()];
    }
    return response()->json($response, $status);
  }

  /**
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function delete ($criteria, Request $request) {
    DB::beginTransaction();
    try {
      $params = $this->getParamsRequest($request);
      $source = $this->source->getItem($criteria, $params);
      $this->source->destroy($source);
      $response = ['data' => new SourceTransformer($source)];
      $status = 200;
      DB::commit();
    } catch (Exception $exception) {
      Log::Error($exception);
      DB::rollback();
      $status = $this->getStatusError($exception->getCode());
      $response = ['errors' => $exception->getMessage()];
    }
    return response()->json($response, $status);
  }

  public function feed ($criteria, Request $request) {
    try {
      $params = $this->getParamsRequest($request);
      $source = $this->source->getItem($criteria, $params);
      if(!$source) throw new Exception('Item not found',404);
      $data = new SourceFeedTransformer($source);
      $response = ['data' => $data];
      $status = 200;
    } catch (Exception $exception) {
      Log::Error($exception);
      $status = $this->getStatusError($exception->getCode());
      $response = ['errors' => $exception->getMessage()];
    }
    return response()->json($response, $status);
  }
}