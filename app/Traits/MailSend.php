<?php

namespace App\Traits;

use App\Models\User;
use App\Models\EmailTemplate;
use App\Models\TicketCategory;
use App\Jobs\TicketOpenEmailJob;
use App\Jobs\TicketRejectEmailJob;

trait MailSend{
    public function sendMailForTicketOpen($ticket, $type)
    {
        $receiver = User::find($ticket->receiver_id);
        $sender = User::find($ticket->sender_id);
        $ticket_category = TicketCategory::find($ticket->ticket_category_id);
        $items = [
            'subject'           => 'A new ticket open',
            'sender_name'       => $sender->name,
            'sender_email'      => $sender->email,
            'receiver_name'     => $receiver->name,
            'receiver_email'    => $receiver->email,
            'ticket_category'   => $ticket_category->name,
            'ticket_id'         => $ticket->ticket_id,
            'ticket_subject'    => $ticket->subject,
            'status'            => $ticket->status,
            'priority'          => $ticket->priority,
            'email'             => $receiver->email,
            'logo'              => asset('assets/media/logos/apple-touch-icon.png')
        ];
        try {
            $template = EmailTemplate::where('type', $type)->where('status', 1)->first();
            if ($template) {
                TicketOpenEmailJob::dispatch($items['email'], $this->mailData($template, $items));
            }
        } catch (\Exception $e) {
            info($e);
        }
    }

    public function sendMailForTicketReject($ticket, $type)
    {
        $receiver = User::find($ticket->receiver_id);
        $sender = User::find($ticket->sender_id);
        $ticket_category = TicketCategory::find($ticket->ticket_category_id);
        $items = [
            'subject'           => 'A ticket has been rejected',
            'sender_name'       => $sender->name,
            'sender_email'      => $sender->email,
            'receiver_name'     => $receiver->name,
            'receiver_email'    => $receiver->email,
            'ticket_category'   => $ticket_category->name,
            'ticket_id'         => $ticket->ticket_id,
            'ticket_subject'    => $ticket->subject,
            'status'            => $ticket->status,
            'priority'          => $ticket->priority,
            'email'             => $receiver->email,
            'logo'              => asset('assets/media/logos/apple-touch-icon.png')
        ];
        try {
            $template = EmailTemplate::where('type', $type)->where('status', 1)->first();
            if ($template) {
                TicketRejectEmailJob::dispatch($items['email'], $this->mailData($template, $items));
            }
        } catch (\Exception $e) {
            info($e);
        }
    }

    public function mailData($template, $items = [])
    {
        $datas["subject"] = isset($items['subject']) ? $items['subject']: $template->subject;
        $datas["content"] = $template->template_design;
        $datas["content"] = str_replace("{title}", $template ? $template->title : '', $datas["content"]);
        $datas["content"] = str_replace("{logo}", isset($items['logo']) ? $items['logo'] : asset('assets/media/logos/apple-touch-icon.png'), $datas["content"]);
        $datas["content"] = str_replace("{subject}", $template ? $template->subject : '', $datas["content"]);

        $datas["content"] = str_replace("{sender_name}", isset($items['sender_name']) ? $items['sender_name'] : '', $datas["content"]);
        $datas["content"] = str_replace("{receiver_name}", isset($items['receiver_name']) ? $items['receiver_name'] : '', $datas["content"]);
        $datas["content"] = str_replace("{ticket_id}", isset($items['ticket_id']) ? $items['ticket_id'] : '', $datas["content"]);
        $datas["content"] = str_replace("{ticket_category}", isset($items['ticket_category']) ? $items['ticket_category'] : '', $datas["content"]);
        $datas["content"] = str_replace("{priority}", isset($items['priority']) ? $items['priority'] : '', $datas["content"]);
        $datas["content"] = str_replace("{status}", isset($items['status']) ? $items['status'] : '', $datas["content"]);

        return $datas;
    }
}
