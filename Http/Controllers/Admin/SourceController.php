<?php

namespace Modules\Ifeeds\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ifeeds\Entities\Source;
use Modules\Ifeeds\Http\Requests\CreateSourceRequest;
use Modules\Ifeeds\Http\Requests\UpdateSourceRequest;
use Modules\Ifeeds\Repositories\SourceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SourceController extends AdminBaseController
{
    /**
     * @var SourceRepository
     */
    private $source;

    public function __construct(SourceRepository $source)
    {
        parent::__construct();

        $this->source = $source;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$sources = $this->source->all();

        return view('ifeeds::admin.sources.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ifeeds::admin.sources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSourceRequest $request
     * @return Response
     */
    public function store(CreateSourceRequest $request)
    {
        $this->source->create($request->all());

        return redirect()->route('admin.ifeeds.source.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ifeeds::sources.title.sources')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Source $source
     * @return Response
     */
    public function edit(Source $source)
    {
        return view('ifeeds::admin.sources.edit', compact('source'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Source $source
     * @param  UpdateSourceRequest $request
     * @return Response
     */
    public function update(Source $source, UpdateSourceRequest $request)
    {
        $this->source->update($source, $request->all());

        return redirect()->route('admin.ifeeds.source.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ifeeds::sources.title.sources')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Source $source
     * @return Response
     */
    public function destroy(Source $source)
    {
        $this->source->destroy($source);

        return redirect()->route('admin.ifeeds.source.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ifeeds::sources.title.sources')]));
    }
}
