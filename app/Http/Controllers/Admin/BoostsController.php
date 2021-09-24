<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Boost;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boost\StoreBoostRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Boost\UpdateBoostRequest;
use App\Http\Requests\Boost\MassDestroyBoostRequest;

class BoostsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('boost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.boosts.index');
    }

    public function boostRequest()
    {
        $channels = Channel::pluck('title', 'id');

        return view('admin.boosts.form-request', compact('channels'));
    }

    public function store(StoreBoostRequest $request)
    {
        dd($request->all);
        $boost = Boost::create($request->all);

        $boost->channels->attach([
            'channel_id' => $request->channel_id,
        ]);

        return response('success', 200);
    }

    public function show(Boost $boost)
    {
        abort_if(Gate::denies('boost_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $boost->load('channels');

        return view('admin.boosts.show', compact('boost'));
    }

    public function edit(Boost $boost)
    {
        abort_if(Gate::denies('boost_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channels = Channel::pluck('title', 'id');

        return view('admin.boosts.create', compact('boost', 'channels'));
    }

    public function update(UpdateBoostRequest $request, Boost $boost)
    {
        $boost->update($request->all);

        return redirect()->route('admin.boosts.index')
            ->with('success', 'Boost has been update successfull.');
    }

    public function destroy(Boost $boost)
    {
        abort_if(Gate::denies('boost_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $boost->delete();

        return response('success', 200);
    }

    public function MassDestroy(MassDestroyBoostRequest $request) 
    {
        Boost::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
