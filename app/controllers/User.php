<?php namespace app\controllers;

use app\models\User as UserModel;
use Redirect;
use Session;
use Confide;
use Config;
use Input;
use Lang;

/**
 * User Controller
 *
 * This controller handles user authentication and profiles. CRUD actions can be
 * found in app\controllers\resources\User.
 */
class User extends Base
{
    public function getRegister()
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            return $this->render(Config::get('confide::signup_form'));
        }
    }

    /**
     * Get Confirmation
     *
     * Attempt to confirm account with code.
     * @param string $code Confirmation code
     * @return
     */
    public function getConfirm ($code)
    {
        $redirect = Redirect::action('app\controllers\User@getLogin');
        if (Confide::confirm($code)) {
            $msg = Lang::get('confide::confide.alerts.confirmation');
            return $redirect->with('notice', $msg);
        } else {
            $msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return $redirect->with('error', $msg);
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
            $user = new UserModel;

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
            return Redirect::action('app\controllers\User@getLogin')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('app\controllers\User@getResetPassword', array('token' => $input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    public function getProfile($user = 0)
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            if (is_numeric($user) && $user) {
                $user = UserModel::find($user);
            } elseif (is_numeric($user)) {
                $user = Confide::user();
            } else {
                $user = UserModel::findByLogin($user);
            }

            if ($user) {
                $this->data['user'] = $user;
                $response = $this->render('user.show');
            } else {
                $response = Redirect::action('app\controllers\Home@notfound', array('message' => 'Unable to find user'));
            }
            return $response;
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
