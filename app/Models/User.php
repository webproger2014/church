<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'login',
        'password',
        'email',
        'surname',
        'last_name',
        'first_name',
        'sex',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function get_users() {
      $db = User::where([]);

      //Поиск по дате
      if (isset($filter['date']) && !empty($filter['date'])) {
        $db->whereBetween('created_at', $filter['date']);
      }



      $page = 1;
      if (isset($filter['page'])) {
        $page = $filter['page'];
      }

      $paginate = $db->paginate(100, ['*'], 'page', $page);

      return [
        'data' => $paginate->items(),
        'count' => $paginate->count(),
        'last_page' => $paginate->lastPage(),
        'current_page' => $paginate->currentPage(),
        'per_page' => $paginate->perPage(),
        'total' => $paginate->total()
      ];
    }
}
