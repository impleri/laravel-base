<?php namespace app\models;

use Zizaco\Confide\ConfideUser;
use Zizaco\Entrust\HasRole;
use Confide;

class User extends ConfideUser
{
    use HasRole;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public static function findByLogin($username, $email = false)
    {
        $identity = array(
            'username' => $username,
            'email' => ($email) ? $email : $username
        );

        return Confide::model()->getUserFromCredsIdentity($identity);
    }
}
