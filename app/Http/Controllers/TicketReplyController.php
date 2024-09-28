<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\TicketReplyRepository;

class TicketReplyController extends Controller
{
    protected $ticketReplyRepository;
    public function __construct(TicketReplyRepository $ticketReplyRepository)
    {
        $this->ticketReplyRepository = $ticketReplyRepository;
    }

    public function replyByAdmin(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', 
        ]);

        $request->merge(
            [
                "sender_id" => auth()->id(),
            ]
        );

        try{
            DB::beginTransaction();
            Ticket::where('id', $request->ticket_id)->update(['status' => $request->status]);
            $this->ticketReplyRepository->store($request->except('_token'));
            DB::commit();
            Toastr::success(__('Reply successfully sent.'), __('Success'));
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollBack();
            Toastr::error(__('ticket.Something went wrong.'), __('ticket.Error'));
            return redirect()->back();
        }
    }

    public function replyByUser(Request $request) {
        $request->validate([
            'message' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', 
        ]);

        $request->merge(
            [
                "sender_id" => auth()->id(),
            ]
        );

        try{
            DB::beginTransaction();
            Ticket::where('id', $request->ticket_id)->update(['status' => $request->status]);
            $this->ticketReplyRepository->store($request->except('_token'));
            DB::commit();
            Toastr::success(__('Reply successfully sent.'), __('Success'));
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollBack();
            Toastr::error(__('ticket.Something went wrong.'), __('ticket.Error'));
            return redirect()->back();
        }
    }
}
