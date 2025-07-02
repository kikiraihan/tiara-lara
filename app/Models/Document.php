<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    // protected $fillable = [
    //     'title',
    //     'category',
    //     'total_pages',
    //     'is_private',
    //     'file_path',
    // ];
    protected $guarded=[];
    
    public static array $availableColumns = [
        'id', // BIGINT, NOT NULL,
        'title', // STRING, NOT NULL,
        'category', // STRING, NOT NULL,
        'total_pages', // INTEGER, NOT NULL,
        'is_private', // BOOLEAN, NOT NULL,
        'file_path', // STRING, NOT NULL,
        'created_at', // DATETIME, NULLABLE,
        'updated_at', // DATETIME, NULLABLE
        'last_proc_at', // DATETIME, NULLABLE
    ];


    /**
     * Relasi ke knowledge (satu dokumen punya banyak knowledge entries)
     */
    public function knowledges(): HasMany
    {
        return $this->hasMany(Knowledge::class);
    }
}
