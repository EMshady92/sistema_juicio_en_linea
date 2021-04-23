<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;

trait ResetsPasswords
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {
        return view('auth.password');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $email=$request->get('email');

        $messages = [
            'email.required' => 'El campo es requerido',
            'email.email' => 'El formato de email es incorrecto',
        ];
        $this->validate($request, ['email' => 'required|email'], $messages);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) use ($email) {
            $message->subject($this->getEmailSubject());
            $message->to($email,'Recuperar Contraseña');
            $message->from('admin_sis@sijel.com.mx','SISTEMA SIJEL');
        });
      
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', 'Hemos enviando un link a tu cuenta de correo electrónico para que puedas resetear el password');

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Tu link para resetear el password';
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        $email=DB::table('password_resets')->where('token','=',$token)->first()->email;

        return view('auth.reset',['email'=>$email])->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        
        $messages = [
            'email.required' => 'El campo es requerido',
            'email.email' => 'El formato de email es incorrecto',
            'password.required' => 'El campo es requerido',
            'password.confirmed' => 'Los passwords no coinciden',
            'password.min' => 'El mínimo de caracteres permitidos son 6',
            'password.max' => 'El máximo de caracteres permitidos son 18',
        ];
        
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6|max:18',
        ], $messages);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath())->with('status', 'Enhorabuena tu password ha sido reseteado con éxito');

            default:
                return redirect()->back()
                            ->withInput($request->only('email'))
                            ->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        $user->save();

        Auth::login($user);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/expedientes';
    }
}