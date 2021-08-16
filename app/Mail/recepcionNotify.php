<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Rendencion_Puntos;
use App\Regalo;

class recepcionNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $canje_id;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($canje_id,$user)
    {
        $this->canje_id = $canje_id;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $canje = Rendencion_Puntos::findorFail($this->canje_id);
        $reward = Regalo::findorFail($canje->regalo_id);
        $tags = json_decode($reward->tag);
        $room = false;
        if(in_array("room", $tags)){
            $room = true;
        }


        return $this->markdown('Mails.notify_recepcion')->with([
            'canje' => $canje,
            'reward' => $reward,
            'room' => $room,
            'user' => $this->user
        ]);
    }
}
