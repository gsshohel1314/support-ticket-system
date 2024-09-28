<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\TicketCategoriesRepository;

class TicketCategoryController extends Controller
{
    protected $ticketCategoriesRepository;
    public function __construct(TicketCategoriesRepository $ticketCategoriesRepository){
        $this->ticketCategoriesRepository = $ticketCategoriesRepository;
    }
    
    public function index(){
        return view('admin.ticket-categories.index');
    }

    public function getList(){
        $ticketCategory = $this->ticketCategoriesRepository->getList();

        return DataTables::of($ticketCategory)
            ->addIndexColumn()
            ->addColumn('name', function($ticketCategory){
                return $ticketCategory->name;
            })
            ->addColumn('status', function ($ticketCategory) {
                return view('admin.ticket-categories.components._status_td', compact('ticketCategory'));
            })
            ->addColumn('action', function ($ticketCategory) {
                return view('admin.ticket-categories.components._action_td', compact('ticketCategory'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create(){
        return view('admin.ticket-categories.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        DB::beginTransaction();
        try{
            $this->ticketCategoriesRepository->store($request->except('_token'));
            DB::commit();
            Toastr::success(__('Ticket Catetory created successfully.'), __('Success'));
            return redirect(url('/admin/ticket-categories'));
        }catch(\Exception $e){
            DB::rollBack();
            Toastr::error(__('Something went wrong.'), __('Error'));
            return redirect()->back();
        }

    }

    public function edit($id){
        $ticketCategory = $this->ticketCategoriesRepository->getTicketCategorybyId($id);
        if($ticketCategory){
            return view('admin.ticket-categories.edit', compact('ticketCategory'));
        }
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required|exists:ticket_categories,id'
        ]);

        DB::beginTransaction();
        try{
            $this->ticketCategoriesRepository->update($request->except('_token'));
            DB::commit();
            Toastr::success(__('Ticket Category updated successfully.'), __('Success'));
            return redirect(url('/admin/ticket-categories'));
        }catch(Exception $e){
            DB::rollBack();
            Toastr::error(__('Something went wrong.'), __('Error'));
            return redirect()->back();
        }

    }

    public function destroy($id){
        try{
            $result = $this->ticketCategoriesRepository->deleteById($id);
            if($result){
                return response()->json([
                    'msg' => 'success'
                ],200);
            }
            return response()->json([
                'msg' => __('Cannot delete because ticket category has tickets.')
            ],404);
        }catch(Exception $e){
            return response()->json([
                'msg' => __('Cannot delete because ticket category has tickets.')
            ],500);
        }
    }
}
