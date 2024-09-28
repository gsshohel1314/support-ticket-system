<?php
namespace App\Repositories;

use App\Models\Ticket;
use App\Traits\MailSend;
use App\Traits\ImageStore;

class TicketRepository{
    use ImageStore, MailSend;

    public function getList(){
        $user_id = auth()->id();
        return Ticket::where('sender_id', $user_id)
            ->where('sender_type', 'App\\Models\\User')
            ->orWhere('receiver_id', $user_id)
            ->latest();
    }

    public function getListForAdmin(){
        $user_id = auth()->id();
        return Ticket::with('sender')->whereNot('status', 'rejected')->where('receiver_id', $user_id)->where('receiver_type','App\\Models\\User')->latest();
    }

    public function store($data){
        $filesArray = [];
        if(!empty($data['files'])) {
            foreach ($data['files'] as $file) {
                $filesArray[] = $this->uploadFile($file);
            }
        }

        $ticket = Ticket::create([
            'sender_id' => $data['sender_id'],
            'sender_type' => $data['sender_type'],
            'receiver_id' => $data['receiver_id'],
            'receiver_type' => $data['receiver_type'],
            'ticket_id' => rand(111111, 999999),
            'subject' => $data['subject'],
            'ticket_category_id' => $data['ticket_category'],
            'status' => 'pending',
            'priority' => $data['priority'],
            'description' => $data['description'],
            'files' => json_encode($filesArray)
        ]);

        $this->sendMailForTicketOpen($ticket, 'ticket_open');
    }


    public function getTicketbyId($id) {
        $ticket = Ticket::where('id', $id)->with('category','sender')->first();
        if($ticket){
            return $ticket;
        }
        return 'Invalid Id';
    }

    public function update($data){
        $ticket = Ticket::where('id', $data['id'])->first();

        $filesArray = json_decode($ticket->files);

        if(!empty($data['files'])){
            $filesArray = json_decode($ticket->files);
            foreach ($data['files'] as $file){
                $filesArray[] = $this->uploadFile($file);
            }
        }

        if($ticket){
            $ticket->update([
                'subject' => $data['subject'],
                'ticket_category_id' => $data['ticket_category'],
                'status' => $data['status'] ?? $ticket->status,
                'priority' => $data['priority'],
                'description' => $data['description'],
                'files' => json_encode($filesArray)
            ]);

            return true;
        }
        return 'Not found';
    }

    public function removeFile($data){
        $ticket = Ticket::where('id', $data['id'])->first();
        if($ticket){
            $files = json_decode($ticket->files);
            $filesArray = array_values(array_diff($files, [$data['fileName']]));
            $ticket->files = json_encode($filesArray);
            $ticket->save();
            $this->deleteImage($data['fileName']);
        }
        return 'Invalid Id';
    }

    public function deleteById($id){
        $ticket = Ticket::where('id', $id)->first();
        if($ticket){
            $ticket->delete();
            return true;
        }
        return false;
    }

    public function rejectedById($id) {
        $ticket = Ticket::where('id', $id)->first();
        if($ticket){
            $ticket->update([
                'status' => 'rejected'
            ]);
            $this->sendMailForTicketReject($ticket, 'ticket_reject');
            return true;
        }
        return false;
    }
}
