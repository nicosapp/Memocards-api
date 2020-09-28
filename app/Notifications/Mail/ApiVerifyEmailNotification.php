<?php

namespace App\Notifications\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class ApiVerifyEmailNotification extends VerifyEmail
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  protected function verificationUrl($notifiable)
  {
    return URL::temporarySignedRoute(
      'verificationapi.verify',
      Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
      [
        'id' => $notifiable->getKey(),
        'hash' => sha1($notifiable->getEmailForVerification()),
      ]
    );
  }

  public function verificationNumbers($notifiable)
  {
    // dd($notifiable);
    $passNumbers = mt_rand(100000, 999999);
    if ($notifiable->verification()->exists()) {
      $notifiable->verification()->delete(); //we delete last recordings
    }

    $notifiable->verification()->create([
      'token' => Hash::make($passNumbers),
      'tentative' => 0
    ]);
    return $passNumbers;
  }


  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    // $verificationUrl = $this->verificationUrl($notifiable);
    $passNumbers = $this->verificationNumbers($notifiable);
    $links = env('APP_URL_CLIENT') . '/auth/email/';

    // if (static::$toMailCallback) {
    //     return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
    // }

    return (new MailMessage)
      ->subject(__('Verify Email Address'))
      ->line(sprintf(__('Please enter the following numbers: %s after clicking on the button below.'), $passNumbers))
      ->action(__('Verify Email Address'), $links)
      ->line(__('If you did not create an account, no further action is required.'));
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}
