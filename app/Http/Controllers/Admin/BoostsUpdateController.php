<?php

namespace App\Http\Controllers\Admin;

use App\Models\Boost;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class BoostsUpdateController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('boost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Boost::with(['channels'])->whereIn('status', [1, 2, 3, 5])->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('edit', 'edit');

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
            $table->editColumn('actual_cost', function ($row) {
                $label = sprintf('<p>$ %s</p>', $row->actual_cost);
                return $row->actual_cost ? $label : '';
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
                    $label = '<span class="badge badge-info badge-many">Done</span>';
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

            $table->editColumn('actions', function ($row) {
                $labels = [];
                
                if($row->status == 5){
                    $labels[] = sprintf('<button type="button" class="btn btn-sm btn-secondary" disabled="true">%s</button>', 'Completed');
                }elseif($row->status == 3){
                    $labels[] = sprintf('<button type="button" class="btn btn-sm btn-success" disabled="true">%s</button>', 'Running');
                    $labels[] = sprintf('<buuton type="button" class="btn btn-sm btn-primary" id="btn-done%s" onclick="done(%s, %s)">%s</buuton>',  $row->id, $row->id, '2', 'Done');
                }else{
                    $labels[] = sprintf('<button type="button" class="btn btn-sm btn-success" id="btn-run%s" onclick="run(%s, %s)">%s</button>', $row->id, $row->id, '1', 'Run now');
                    $labels[] = sprintf('<buuton type="button" class="btn btn-sm btn-primary" id="btn-done%s" onclick="done(%s, %s)">%s</buuton>', $row->id, $row->id, '2', 'Done');
                }

                return implode(' ', $labels);
            });

            $table->editColumn('edit', function ($row) {
                $route = route('admin.productions.edit', $row->id);
                $label = sprintf('<a class="btn btn-info btn-edit" href="%s">Edit</a>', $route);
                
                return $label ? $label : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'channel', 'status', 'reference', 'budget', 'edit', 'actual_cost']);

            return $table->make(true);
        }

        return view('admin.boosts.productions.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('boost_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $boost = Boost::findOrfail($id);

        return  view('admin.boosts.productions.edit', compact('boost'));
    }

    public function show(Boost $boost)
    {
        abort_if(Gate::denies('boost_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $boost->load('channels');

        return view('admin.boosts.productions.show', compact('boost'));
    }

    public function update(Request $request, $id)
    {
        $boost = Boost::findOrfail($id);

        if($request->st == 1){
            $boost->update(['status' => '3']);
        }elseif($request->st == 2){
            $boost->update(['status' => '5']);
        }elseif($request->st == 3){
            $boost->update([
                'actual_cost' => $request->actual_cost, 
                'status' => $request->status
            ]);
            
            return redirect()->route('admin.productions.index');
        }else{
            return response('Opss', 402);
        }

        return response('success', 200);
    }
}
