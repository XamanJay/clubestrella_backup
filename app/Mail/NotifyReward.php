<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\User;
use App\Regalo;
use App\Rendencion_Puntos;

class NotifyReward extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $canje_id;


    public function __construct($canje_id)
    {
        $this->canje_id = $canje_id;
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

        $path = "";
        if($reward->custom == 1){
            $url_img = json_decode($reward->imgs);
            $path = config('app.url').'/'.$url_img[0];
        }
        if($reward->custom == 2){
            $url_img = json_decode($reward->imgs);
            $path = config('app.url').Storage::url($url_img[0]);
        }

        return $this->markdown('Mails.notify_reward')->with([
            'canje' => $canje,
            'reward' => $reward,
            'room' => $room,
            'path' => $path
        ]);
    }
}
