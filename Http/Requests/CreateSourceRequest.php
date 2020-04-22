<?php

namespace Modules\Ifeeds\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateSourceRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'name' => 'required|min:2',
      'url' => 'required|min:2'
    ];
  }

  public function translationRules()
  {
    return [];
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
    return [];
  }
}
