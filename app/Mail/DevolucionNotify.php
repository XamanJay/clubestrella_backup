<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DevolucionNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $canje;
    public $reservation;
    public $reward;

    public function __construct($canje,$user,$reward,$reservation)
    {
        $this->user = $user;
        $this->canje = $canje;
        $this->reservation = $reservation;
        $this->reward = $reward;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $path = "";
        if($this->reward->custom == 1){
            $url_img = json_decode($this->reward->imgs);
            $path = config('app.url').'/'.$url_img[0];
        }
        if($this->reward->custom == 2){
            $url_img = json_decode($this->reward->imgs);
            $path = config('app.url').Storage::url($url_img[0]);
        }

        return $this->markdown('Mails.devolucion')->with([
            'user' => $this->user,
            'canje' => $this->canje,
            'reward' => $this->reward,
            'reservation' => $this->reservation,
            'path' => $path
        ]);
    }
}
