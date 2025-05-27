<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'football_pitch_id', 'content', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function footballPitch()
    {
        return $this->belongsTo(FootballPitch::class);
    }
}
