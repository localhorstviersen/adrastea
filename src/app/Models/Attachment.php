<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class Attachment
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $referenceType
 * @property string $referenceId
 * @property string $fileName
 * @property string $path
 * @property string $uploadedBy
 * @property string $created_at
 * @property string $updated_at
 */
class Attachment extends Model
{
    public const REFERENCE_TYPE_TICKET = 'ticket';

    protected $table = 'attachments';
    protected $returnType = self::class;
    protected $allowedFields = ['referenceType', 'referenceId', 'fileName', 'path', 'uploadedBy'];
    protected $useTimestamps = true;

    /**
     * This method will return all attachments for the given ticket.
     *
     * @param int $id
     *
     * @return Attachment[]
     */
    public static function getAttachmentsByTicket(int $id): array
    {
        $attachment = new Attachment();

        return $attachment->where('referenceType', self::REFERENCE_TYPE_TICKET)
            ->where('referenceId', $id)
            ->findAll();
    }
}
