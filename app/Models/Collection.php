<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Collection extends Model
{
    protected $table = 'collections';
    protected $fillable = ['name', 'notes', 'user_id'];
    public function user() {
            return $this->belongsTo(User::class);
    }
    public static function validate(array $data) {
        $errors = [];

        if (! $data['name']) {
            $errors['name'] = 'Name is required.';
        }

        if (strlen($data['notes']) > 255) {
            $errors['notes'] = 'Notes must be at most 255 characters.';
        }
        
        return $errors;
    }

    public function image() {
        return $this->hasMany(Image::class);
    }
}