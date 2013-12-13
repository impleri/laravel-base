<?php namespace app\controllers;

use Zizaco\Confide\Confide;
use app\models\User;
use Redirect;
use Session;
use Config;
use Input;
use View;
use Lang;

/**
 * Confide Controller Template
 *
 * This is the default Confide controller template for controlling user
 * authentication. Feel free to change to your needs.
 */

class User extends Base
{
    public function getRegister()
    {

    }

    public function getProfile(User $user)
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            $this->data['user'] = $user;
            return $this->render('user.profile');
        }
    }

    /**
     * Login Form
     *
     * Displays the login form
     * @return  \Illuminate\View\View Renderable output
     */
    public function getLogin()
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            return $this->render(Config::get('confide::login_form'));
        }
    }

    /**
     * Login Callback
     *
     * Attempt to do login
     * @return \Illuminate\Http\RedirectResponse Redirection
     */
    public function postLogin()
    {
        $input = array(
            'email'    => Input::get('email'),
            'username' => Input::get('email'),
            'password' => Input::get('password'),
            'remember' => Input::get('remember'),
        );

        if (Confide::logAttempt($input, Config::get('confide::signup_confirm'))) {
            $redirect = Session::get('loginRedirect');
            if (!empty($redirect)) {
                $redirect = '/';
            } else {
                Session::forget('loginRedirect');
            }

            return Redirect::to($redirect);
        } else {
            $user = new User;

            // Figure out the error message
            if (Confide::isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($user->checkUserExists($input) && !$user->isConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('app\controllers\User@getLogin')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param string $code
     */
    public function getConfirm ($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('app\controllers\User@getLogin')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('app\controllers\User@getLogin')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgotPassword()
    {
        return $this->render(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     */
    public function postForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('app\controllers\User@getLogin')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('app\controllers\User@getForgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getResetPassword ($token)
    {
        return $this->render(Config::get('confide::reset_password_form'))
            ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     */
    public function postResetPassword()
    {
        $input = array(
            'token' => Input::get('token'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if (Confide::resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('UserController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UserController@reset_password', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();
        return Redirect::to('/');
    }
}
