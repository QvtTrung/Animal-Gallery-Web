<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    class Image extends Model
    {
        protected $table = 'images';
        protected $fillable = ['urls','collection_id'];
        public function collection() {
            return $this->belongsTo(Collection::class);
        }

        public static function validate(array $data) {
            $errors = [];

            if (strlen($data['urls']) > 255) {
                $errors['notes'] = 'urls of the image is too long (> 255 characters)';
            }
            
            return $errors;
        }
    }