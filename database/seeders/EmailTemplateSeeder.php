<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::create([
            'title' => 'Ticket Open Successfull',
            'type' => 'ticket_open',
            'subject' => 'A new ticket open',
            'status' => 1,
            'template_design' =>"<meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>{title}</title>
            <table role=\"presentation\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"background-color: #EFF1F4; padding: 20px; border-radius: 10px; margin-top: 30px; margin-bottom: 30px; max-width: 1320px; margin-right: auto; margin-left: auto;\">
                <tbody>
                    <tr>
                        <td style=\"padding: 10px;\">
                            <img src=\"{logo}\" alt=\"Logo\" style=\"max-width: 100px; display: block; margin: 0 auto;\">
                            <h3 style=\"font-size: 25px; font-weight: 700; margin-top: 20px; text-align: center; color: black !important;\">{subject}</h3>
                            <p style=\"color: black !important;\">Hello {receiver_name},</p>
                            <p style=\"color: black !important;\">A new ticket has been opened with the following details:</p>
                            <ul style=\"color: black !important; padding-left: 15px;\">
                                <li><strong>Ticket ID:</strong> {ticket_id}</li>
                                <li><strong>Category:</strong> {ticket_category}</li>
                                <li><strong>Priority:</strong> {priority}</li>
                                <li><strong>Status:</strong> {status}</li>
                            </ul>
                            <p style=\"color: black !important;\">Ticket opened by: {sender_name}</p>
                            <p style=\"margin-bottom: 5px; line-height: 1.4; color: black !important;\"><strong>Note:</strong> Please address this ticket as soon as possible.</p>
                            <p style=\"line-height: 1.4; color: black !important;\">This email was sent from an automated system. Please do not reply directly to this email.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"background-color: #EFF1F4; border-top: 1px solid white; padding: 16px;\">
                            <p style=\"margin: 0; font-size: 12px; text-align: center; color: black !important;\">If this wasn't you, please ignore this email or contact our customer service center for further assistance.</p>
                            <p style=\"margin: 0; font-size: 12px; color: black !important; text-align: center;\">Copyright Ⓒ 2024 Support Ticket</p>
                        </td>
                    </tr>
                </tbody>
            </table>"
        ]);

        EmailTemplate::create([
            'title' => 'Ticket Reject Successfull',
            'type' => 'ticket_reject',
            'subject' => 'Admin has rejected a ticket',
            'status' => 1,
            'template_design' =>"<meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>{title}</title>
            <table role=\"presentation\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"background-color: #EFF1F4; padding: 20px; border-radius: 10px; margin-top: 30px; margin-bottom: 30px; max-width: 1320px; margin-right: auto; margin-left: auto;\">
                <tbody>
                    <tr>
                        <td style=\"padding: 10px;\">
                            <img src=\"{logo}\" alt=\"Logo\" style=\"max-width: 100px; display: block; margin: 0 auto;\">
                            <h3 style=\"font-size: 25px; font-weight: 700; margin-top: 20px; text-align: center; color: black !important;\">{subject}</h3>
                            <p style=\"color: black !important;\">Hello {sender_name},</p>
                            <p style=\"color: black !important;\">A ticket has been rejected. The ticket details are::</p>
                            <ul style=\"color: black !important; padding-left: 15px;\">
                                <li><strong>Ticket ID:</strong> {ticket_id}</li>
                                <li><strong>Category:</strong> {ticket_category}</li>
                                <li><strong>Priority:</strong> {priority}</li>
                                <li><strong>Status:</strong> {status}</li>
                            </ul>
                            <p style=\"color: black !important;\">Ticket rejected by: {receiver_name}</p>
                            <p style=\"margin-bottom: 5px; line-height: 1.4; color: black !important;\"><strong>Note:</strong> Please address this ticket as soon as possible.</p>
                            <p style=\"line-height: 1.4; color: black !important;\">This email was sent from an automated system. Please do not reply directly to this email.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"background-color: #EFF1F4; border-top: 1px solid white; padding: 16px;\">
                            <p style=\"margin: 0; font-size: 12px; text-align: center; color: black !important;\">If this wasn't you, please ignore this email or contact our customer service center for further assistance.</p>
                            <p style=\"margin: 0; font-size: 12px; color: black !important; text-align: center;\">Copyright Ⓒ 2024 Support Ticket</p>
                        </td>
                    </tr>
                </tbody>
            </table>"
        ]);
    }
}
        
