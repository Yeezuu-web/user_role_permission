<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Boost;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Boost\StoreBoostRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Boost\UpdateBoostRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\Boost\MassDestroyBoostRequest;

class BoostsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('boost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Boost::with(['channels'])->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'boost_show';
                $editGate = 'boost_edit';
                $deleteGate = 'boost_delete';
                $crudRoutePart = 'boosts';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('requester_name', function ($row) {
                return $row->requester_name ? $row->requester_name : '';
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ? $row->company_name : '';
            });
            $table->editColumn('group', function ($row) {
                return $row->group ? $row->group : '';
            });
            $table->editColumn('budget', function ($row) {
                $label = sprintf('<p>$ %s</p>', $row->budget);
                return $row->budget ? $label : '';
            });
            $table->editColumn('program_name', function ($row) {
                return $row->program_name ? $row->program_name : '';
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ? $row->company_name : '';
            });
            $table->editColumn('boost_start', function ($row) {
                return $row->boost_start ? $row->boost_start : '';
            });
            $table->editColumn('target_url', function ($row) {
                return $row->target_url ? $row->target_url : '';
            });
            $table->editColumn('detail', function ($row) {
                return $row->detail ? $row->detail : '';
            });
            $table->editColumn('status', function ($row) {
                if ($row->status == 0)
                {
                    $label = '<span class="badge badge-success badge-many">In review</span>';
                }
                elseif ($row->status == 1) 
                {
                    $label = '<span class="badge badge-warning badge-many">1st Approved</span>';
                }
                elseif ($row->status == 2) 
                {
                    $label = '<span class="badge badge-warning badge-many">2nd Approved</span>';
                }
                elseif ($row->status == 3) 
                {
                    $label = '<span class="badge badge-success badge-many">Running</span>';
                }
                elseif ($row->status == 4) 
                {
                    $label = '<span class="badge badge-danger badge-many">Rejected</span>';
                }
                else
                {
                    $label = '<span class="badge badge-secondary badge-many">Completed</span>';
                }

                return $label;
            });
            $table->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at : '';
            });
            $table->editColumn('channel', function ($row) {
                $labels = [];
                foreach ($row->channels as $channel) {
                    $labels[] = sprintf('<span class="badge badge-info badge-many">%s</span>', $channel->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('reference', function ($row) {
                if ($photo = $row->reference) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }
                    return '';
                });

            $table->rawColumns(['actions', 'placeholder', 'channel', 'status', 'reference', 'budget']);

            return $table->make(true);
        }

        return view('admin.boosts.index');
    }

    public function boostRequest()
    {
        $channels = Channel::pluck('title', 'id');

        return view('admin.boosts.form-request', compact('channels'));
    }

    public function boostStore(StoreBoostRequest $request)
    {
        $boost = Boost::create($request->all());

        $boost->channels()->sync($request->input('channel_id', []));

        $route = route('admin.boosts.firstApprove', $boost);

        $details = [
            'title' => 'Dear Sir/Madam,',
            'company' => $request->company_name,
            'link' => $route,
            'brand' => $request->program_name,
            'budget' => $request->budget,
            'action' => 'review',
            'btn' => 'Check and Review Request',
        ];
       
        \Mail::to('piseth.chhun@ctn.com.kh')->send(new \App\Mail\BoostMail($details));

        if ($request->input('reference', false)) {
            $boost->addMedia(storage_path('tmp/uploads/' . basename($request->input('reference'))))->toMediaCollection('reference');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $boost->id]);
        }

        return back();
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

        return view('admin.boosts.edit', compact('boost', 'channels'));
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

    public function storeCKEditorImages(Request $request)
    {
        $model         = new Boost();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function firstApprove(Boost $boost)
    {
        abort_if(Gate::denies('boost_first_approve'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.boosts.approvals.first_approve', compact('boost'));
    }

    public function firstApproveUpdate(Request $request, $id)
    {
        abort_if(Gate::denies('boost_first_approve'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $boost = Boost::findOrfail($id);

        if ( $request->action == 'approve' ) {
            $now = now();
            $boost->update(['status' => '1', 'reviewed_at' => $now]);

            $boost->user()->associate($request->user)->save();

            $route = route('admin.boosts.secondApprove', $boost);

            $details = [
                'title' => 'Dear Sir/Madam,',
                'company' => $request->company_name,
                'link' => $route,
                'brand' => $boost->program_name,
                'budget' => $boost->budget,
                'action' => 'finnal approve',
                'review_by' => $boost->user->name,
                'btn' => 'Check and Approve',
            ];
           
            \Mail::to('piseth.chhun@ctn.com.kh')->send(new \App\Mail\BoostMail($details));
        }elseif ( $request->action == 'reject' ) {
            $boost->update(['status' => '4']);
            
        }else{
            return response('Opps', 200);
        }

        return response('success', 200);
    }

    public function secondApprove(Boost $boost)
    {
        abort_if(Gate::denies('boost_second_approve'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $boost->load('user');

        return view('admin.boosts.approvals.second_approve', compact('boost'));
    }

    public function secondApproveUpdate(Request $request, $id)
    {
        abort_if(Gate::denies('boost_second_approve'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $boost = Boost::findOrfail($id);

        if ($request->action == 'approve') {

            $boost->update(['status' => '2']);

        }elseif($request->action == 'reject'){

            $boost->update(['status' => '4']);
            
        }else{
            return response('Opss', 402);
        }
        return response('success', 200);
    }
}
