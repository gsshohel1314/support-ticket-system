<?php
namespace App\Repositories;

use App\Traits\ImageStore;
use App\Models\TicketReply;

class TicketReplyRepository{
    use ImageStore;

    public function getTicketReplyByTicketId($id) {
        $ticketReplies = TicketReply::with('sender', 'receiver')->where('ticket_id', $id)->get();
        if($ticketReplies){
            return $ticketReplies;
        }
        return 'Invalid Id';
    }

    public function store($data) {
        $filesArray = [];
        if(!empty($data['files'])) {
            foreach ($data['files'] as $file) {
                $filesArray[] = $this->uploadFile($file);
            }
        }

        TicketReply::create([
            'ticket_id'     => $data['ticket_id'],
            'sender_id'     => $data['sender_id'],
            'receiver_id'   => $data['receiver_id'],
            'message'       => $data['message'],
            'files'         => json_encode($filesArray),
        ]);
    }
}
