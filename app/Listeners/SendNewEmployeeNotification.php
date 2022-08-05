<?php

namespace App\Listeners;

use App\Events\NewEmployee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewEmployeeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewEmployee $event)
    {
        $employee = $event->employee;
        Mail::send('emails.newEmployeeMail', ['data' =>$employee->toArray()], function($message) use ($employee) {
            $message->to($employee->email);
            $message->subject('Sending Email to new employee');
        });
    }
}
