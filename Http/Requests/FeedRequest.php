<?php

namespace Modules\Ifeeds\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class FeedRequest extends BaseFormRequest
{

  public function rules()
  {
    return [];
  }

  public function translationRules()
  {
    return [
      'title' => 'required|min:2'
    ];
  }

  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [];
  }

  public function translationMessages()
  {
    return [
      
    ];
  }

}