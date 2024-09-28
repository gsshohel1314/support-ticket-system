<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Http\Controllers\Controller;
use App\Repositories\TicketReplyRepository;
use App\Repositories\TicketRepository;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    protected $ticketRepository;
    protected $ticketReplyRepository;
    public function __construct(TicketRepository $ticketRepository, TicketReplyRepository $ticketReplyRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->ticketReplyRepository = $ticketReplyRepository;
    }

    public function index()
    {
        return view('admin.tickets.index');
    }

    public function getList()
    {
        $ticket = $this->ticketRepository->getListForAdmin();

        return DataTables::of($ticket)
            ->addIndexColumn()
            ->addColumn('ticket_id', function ($ticket) {
                return $ticket->ticket_id;
            })
            ->editColumn('priority', function ($ticket) {
                return view('admin.tickets.components._priority_td', compact('ticket'));
            })
            ->editColumn('date', function ($ticket) {
                return $ticket->created_at->toFormattedDateString();
            })
            ->addColumn('status', function ($ticket) {
                return view('admin.tickets.components._status_td', compact('ticket'));
            })
            ->addColumn('action', function ($ticket) {
                return view('admin.tickets.components._action_td', compact('ticket'));
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }

    public function view($id)
    {
        $ticket = $this->ticketRepository->getTicketbyId($id);
        $ticketCategories = TicketCategory::where('status', 1)->get();
        $ticketReplies = $this->ticketReplyRepository->getTicketReplyByTicketId($id);

        if ($ticket) {
            return view('admin.tickets.view', compact('ticket', 'ticketCategories', 'ticketReplies'));
        }
    }

    public function reject($id) {
        try {
            $result = $this->ticketRepository->rejectedById($id);
            if($result){
                return response()->json([
                    'msg' => 'success'
                ],200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'error'
            ],500);
        }
    }
}
