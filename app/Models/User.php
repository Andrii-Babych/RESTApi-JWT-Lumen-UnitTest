<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordInterface;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject, CanResetPasswordInterface
{
    use Authenticatable, Authorizable, HasFactory;
    use CanResetPasswordTrait;
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'phone'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * @param string $firstName
     * @return string
     */
    public function setFirstName(string $firstName): string
    {
        $this->attributes['first_name'] = $firstName;
        return $firstName;
    }

    /**
     * @param string $lastName
     * @return string
     */
    public function setLastName(string $lastName): string
    {
        $this->attributes['last_name'] = $lastName;
        return $lastName;
    }

    /**
     * @param string $email
     * @return string
     */
    public function setEmail(string $email): string
    {
        $this->attributes['email'] = $email;
        return $email;
    }

    /**
     * @param string $password
     * @return string
     */
    public function setPassword(string $password): string
    {
        $this->attributes['password'] = app('hash')->make($password);
        return $password;
    }

    /**
     * @param int $phone
     * @return int
     */
    public function setPhone(int $phone): int
    {
        $this->attributes['phone'] = $phone;
        return $phone;
    }

}
