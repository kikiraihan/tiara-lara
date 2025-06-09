<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Knowledge extends Model
{
    use HasFactory;

    protected $guarded=[];

    public static array $availableColumns = [
        'id', // BIGINT, NOT NULL,
        'content', // TEXT, NOT NULL,
        'page', // INTEGER, NULLABLE,
        'created_at', // DATETIME, NULLABLE,
        'updated_at', // DATETIME, NULLABLE,
        'document_id', // BIGINT, NOT NULL,
        'immutable_document_title', // STRING, NULLABLE,
        'immutable_document_category', // STRING, NULLABLE,
        'embedding', // VEKTOR, NULLABLE
    ];


    /**
     * Tipe casting untuk kolom vector (optional jika kamu ingin manipulasi sebagai array)
     */
    // protected $casts = [
    //     'embedding' => 'array', // pastikan data dihandle sebagai JSON array saat input/output
    // ];

    /**
     * Relasi ke document
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
