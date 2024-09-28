<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\TicketRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Repositories\TicketReplyRepository;

class TicketController extends Controller
{
    protected $ticketRepository;
    protected $ticketReplyRepository;
    public function __construct(TicketRepository $ticketRepository, TicketReplyRepository $ticketReplyRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->ticketReplyRepository = $ticketReplyRepository;
    }

    public function index(){
        return view('user.tickets.index');
    }

    public function getList(){
        $ticket = $this->ticketRepository->getList();

        return DataTables::of($ticket)
            ->addIndexColumn()
            ->addColumn('ticket_id', function($ticket){
                return $ticket->ticket_id;
            })
            ->addColumn('subject', function($ticket){
                return Str::limit($ticket->subject, 100);
            })
            ->addColumn('from', function($ticket){
                return __('Own');
            })
            ->addColumn('date', function ($ticket) {
                return $ticket->created_at->toFormattedDateString();
            })
            ->addColumn('priority', function($ticket){
                return view('user.tickets.components._priority_td', compact('ticket'));
            })
            ->addColumn('status', function ($ticket) {
                return view('user.tickets.components._status_td', compact('ticket'));
            })
            ->addColumn('action', function ($ticket) {
                return view('user.tickets.components._action_td', compact('ticket'));
            })
            ->rawColumns(['status','action'])
            ->toJson();
    }

    public function create(){
        $ticketCategories = TicketCategory::where('status', 1)->get();

        return view('user.tickets.create', compact('ticketCategories'));
    }

    public function store(TicketCreateRequest $request){
        $admin_user = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->first();
        
        $request->merge(
            [
                "sender_id" => auth()->id(),
                "sender_type" => 'App\Models\User',
                "receiver_id" => $admin_user->id,
                "receiver_type" => "App\Models\User"
            ]
        );

        DB::beginTransaction();
        try{
            $this->ticketRepository->store($request->except('_token'));
            DB::commit();
            Toastr::success(__('Ticket created successfully.'), __('Success'));

            return redirect(url('/user/tickets'));

        }catch(Exception $e){
            DB::rollBack();
            Toastr::error(__('Something went wrong.'), __('Error'));
            
            return redirect()->back();
        }
    }

    public function view($id)
    {
        $ticket = $this->ticketRepository->getTicketbyId($id);
        $ticketCategories = TicketCategory::where('status', 1)->get();
        $ticketReplies = $this->ticketReplyRepository->getTicketReplyByTicketId($id);

        if ($ticket) {
            return view('user.tickets.view', compact('ticket', 'ticketCategories', 'ticketReplies'));
        }
    }

    public function edit($id){
        $ticket = $this->ticketRepository->getTicketbyId($id);
        $ticketCategories = TicketCategory::where('status', 1)->get();
        if($ticket){
            return view('user.tickets.edit', compact('ticket', 'ticketCategories'));
        }
    }

    public function update(TicketUpdateRequest $request){
        DB::beginTransaction();
        try{
             $this->ticketRepository->update($request->except('_token'));
            DB::commit();
            Toastr::success(__('Ticket updated successfully.'), __('Success'));
            return redirect(url('/user/tickets'));
        }catch(Exception $e){
            DB::rollBack();
            Toastr::error(__('Something went wrong.'), __('Error'));
            return redirect()->back();
        }
    }

    public function removeFile(Request $request)
    {
        try {
            $this->ticketRepository->removeFile($request->except('_token'));
            DB::commit();
            return redirect(url('/user/tickets'));
        }catch(Exception $e){
            DB::rollBack();
            Toastr::error(__('Something went wrong.'), __('Error'));
            return redirect()->back();
        }
    }

    public function destroy($id){
        try{
            $result = $this->ticketRepository->deleteById($id);
            if($result){
                return response()->json([
                    'msg' => 'success'
                ],200);
            }
            return response()->json([
                'msg' => __('Cannot delete because this support ticket has replies')
            ],500);
        }catch(Exception $e){
            return response()->json([
                'msg' => __('Cannot delete because this support ticket has replies')
            ],500);
        }
    }
}
