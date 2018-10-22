<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name','size'];

    public function add($user)
    {
        $this->guardAgainstTooManyMembers();


        $method = $user instanceof User ? 'save' : 'saveMany';

        $this->members()->$method($user);
    }

    public function remove($users)
    {
        if($users instanceof User){
            return $users->leaveTeam();
        }

        return $this->removeMany($users);
    }

    public function removeMany($users)
    {
        return $this->members()
            ->whereIn('id',$users->pluck('id'))
            ->update(['team_id' => null]);
    }

    public function restart()
    {
        $this->members()->update(['team_id' => null]);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    public function guardAgainstTooManyMembers()
    {
        if($this->members()->count() >= $this->size){
            throw new \Exception;
        }
    }
}
